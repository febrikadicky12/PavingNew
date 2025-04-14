<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gaji;
use App\Models\Karyawan;
use App\Models\Penggajian;
use App\Models\RekapAbsen;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenggajianBulananController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $period = $request->input('period', Carbon::now()->format('Y-m'));
        $search = $request->input('search');
        
        $penggajianQuery = Penggajian::with(['karyawan', 'rekapAbsen', 'gaji'])
            ->whereHas('karyawan', function($query) {
                $query->where('status', 'bulanan');
            })
            ->when($search, function($query) use ($search) {
                return $query->whereHas('karyawan', function($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                });
            });
        
        if ($period) {
            $startDate = Carbon::createFromFormat('Y-m', $period)->startOfMonth();
            $endDate = Carbon::createFromFormat('Y-m', $period)->endOfMonth();
            $penggajianQuery->whereBetween('periode_gaji', [$startDate, $endDate]);
        }
        
        $penggajian = $penggajianQuery->orderBy('periode_gaji', 'desc')->paginate(10);
        
        return view('admin.penggajian.bulanan.index', compact('penggajian', 'period', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $karyawans = Karyawan::where('status', 'bulanan')->get();
        $gajis = Gaji::where('jenis_karyawan', 'bulanan')->get();
        $months = [];
        
        // Generate last 12 months for selection
        for ($i = 0; $i < 12; $i++) {
            $month = Carbon::now()->subMonths($i);
            $months[$month->format('Y-m')] = $month->format('F Y');
        }
        
        return view('admin.penggajian.bulanan.create', compact('karyawans', 'gajis', 'months'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_karyawan' => 'required|exists:karyawan,id_karyawan',
            'period' => 'required|date_format:Y-m',
            'id_gaji' => 'required|exists:gaji,id_gaji',
            'tgl_penggajian' => 'required|date',
            'status_penggajian' => 'required|in:sudah bayar,belum dibayar',
        ]);

        // Parse the selected month
        $selectedMonth = Carbon::createFromFormat('Y-m', $request->period);
        $startDate = $selectedMonth->copy()->startOfMonth();
        
        // Find rekap absen for this employee and period
        $rekapAbsen = RekapAbsen::where('id_karyawan', $request->id_karyawan)
            ->where('periode', $startDate->toDateString())
            ->first();
            
        if (!$rekapAbsen) {
            return redirect()->back()->with('error', 'Data rekap absensi tidak ditemukan untuk periode ini!')->withInput();
        }
        
        // Get gaji data
        $gaji = Gaji::findOrFail($request->id_gaji);
        
       // Calculate total salary based on attendance
$totalGaji = $gaji->gaji_pokok;

// Apply deductions for absences
if ($gaji->potongan_izin) {
    $totalGaji -= ($rekapAbsen->jumlah_izin * $gaji->potongan_izin);
}

if ($gaji->potongan_alpa) {
    $totalGaji -= ($rekapAbsen->jumlah_alpa * $gaji->potongan_alpa);
}

// Ensure total salary is not negative
$totalGaji = max(0, $totalGaji);
        // Check if penggajian for this employee and period already exists
        $existingPenggajian = Penggajian::where('id_karyawan', $request->id_karyawan)
            ->whereMonth('periode_gaji', $startDate->month)
            ->whereYear('periode_gaji', $startDate->year)
            ->first();
            
        if ($existingPenggajian) {
            return redirect()->back()->with('error', 'Data penggajian untuk karyawan dan periode ini sudah ada!')->withInput();
        }
        
        DB::beginTransaction();
        
        try {
            Penggajian::create([
                'id_karyawan' => $request->id_karyawan,
                'id_rekap' => $rekapAbsen->id_rekap,
                'id_gaji' => $request->id_gaji,
                'periode_gaji' => $startDate->toDateTimeString(),
                'total_produksi' => 0, // No production for monthly employees
                'total_gaji' => $totalGaji,
                'tgl_penggajian' => $request->tgl_penggajian,
                'status_penggajian' => $request->status_penggajian,
            ]);
            
            DB::commit();
            
            return redirect()->route('admin.penggajian.bulanan.index')
                ->with('success', 'Data penggajian karyawan bulanan berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $penggajian = Penggajian::with(['karyawan', 'rekapAbsen', 'gaji'])->findOrFail($id);
        
        // Ensure this is a monthly employee's salary
        if ($penggajian->karyawan->status !== 'bulanan') {
            return redirect()->route('admin.penggajian.bulanan.index')
                ->with('error', 'Data penggajian ini bukan untuk karyawan bulanan!');
        }
        
        return view('admin.penggajian.bulanan.show', compact('penggajian'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $penggajian = Penggajian::with(['karyawan', 'rekapAbsen', 'gaji'])->findOrFail($id);
        
        // Ensure this is a monthly employee's salary
        if ($penggajian->karyawan->status !== 'bulanan') {
            return redirect()->route('admin.penggajian.bulanan.index')
                ->with('error', 'Data penggajian ini bukan untuk karyawan bulanan!');
        }
        
        $gajis = Gaji::where('jenis_karyawan', 'bulanan')->get();
        
        return view('admin.penggajian.bulanan.edit', compact('penggajian', 'gajis'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_gaji' => 'required|exists:gaji,id_gaji',
            'tgl_penggajian' => 'required|date',
            'status_penggajian' => 'required|in:sudah bayar,belum dibayar',
        ]);
        
        $penggajian = Penggajian::findOrFail($id);
        
        // Ensure this is a monthly employee's salary
        if ($penggajian->karyawan->status !== 'bulanan') {
            return redirect()->route('admin.penggajian.bulanan.index')
                ->with('error', 'Data penggajian ini bukan untuk karyawan bulanan!');
        }
        
        // Get gaji data
        $gaji = Gaji::findOrFail($request->id_gaji);
        
        // Recalculate total salary based on attendance
        $totalGaji = $gaji->gaji_pokok;
        
        // Apply deductions for absences
        if ($gaji->potongan_izin) {
            $totalGaji -= ($penggajian->rekapAbsen->jumlah_izin * $gaji->potongan_izin);
        }
        
        if ($gaji->potongan_alpa) {
            $totalGaji -= ($penggajian->rekapAbsen->jumlah_alpa * $gaji->potongan_alpa);
        }
        
        // Ensure total salary is not negative
        $totalGaji = max(0, $totalGaji);
        
        DB::beginTransaction();
        
        try {
            $penggajian->update([
                'id_gaji' => $request->id_gaji,
                'total_gaji' => $totalGaji,
                'tgl_penggajian' => $request->tgl_penggajian,
                'status_penggajian' => $request->status_penggajian,
            ]);
            
            DB::commit();
            
            return redirect()->route('admin.penggajian.bulanan.index')
                ->with('success', 'Data penggajian karyawan bulanan berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   // In PenggajianBulananController.php
public function destroy($id)
{
    try {
        $penggajian = Penggajian::findOrFail($id);
        
        // Ensure this is a monthly employee's salary
        if ($penggajian->karyawan->status !== 'bulanan') {
            return redirect()->route('admin.penggajian.bulanan.index')
                ->with('error', 'Data penggajian ini bukan untuk karyawan bulanan!');
        }
        
        $penggajian->delete();
        
        return redirect()->route('admin.penggajian.bulanan.index')
            ->with('success', 'Data penggajian karyawan bulanan berhasil dihapus!');
    } catch (\Exception $e) {
        // Add logging here
        \Log::error('Error deleting penggajian: ' . $e->getMessage());
        return redirect()->route('admin.penggajian.bulanan.index')
            ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
    }
}
    /**
     * Generate salary reports for all monthly employees.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function generateBatch(Request $request)
{
    $request->validate([
        'period' => 'required|date_format:Y-m',
        'id_gaji' => 'required|exists:gaji,id_gaji',
        'tgl_penggajian' => 'required|date',
        'status_penggajian' => 'required|in:sudah bayar,belum dibayar',
    ]);
    
    // Parse the selected month
    $selectedMonth = Carbon::createFromFormat('Y-m', $request->period);
    $startDate = $selectedMonth->copy()->startOfMonth();
    $endDate = $selectedMonth->copy()->endOfMonth();
    
    // Get all monthly employees
    $karyawans = Karyawan::where('status', 'bulanan')->get();
    
    // Get gaji data
    $gaji = Gaji::findOrFail($request->id_gaji);
    
    if ($gaji->jenis_karyawan !== 'bulanan') {
        return redirect()->back()
            ->with('error', 'Data gaji yang dipilih bukan untuk karyawan bulanan!')
            ->withInput();
    }
    
    $created = 0;
    $errors = 0;
    
    DB::beginTransaction();
    
    try {
        foreach ($karyawans as $karyawan) {
            // Skip if penggajian for this employee and period already exists
            $existingPenggajian = Penggajian::where('id_karyawan', $karyawan->id_karyawan)
                ->whereMonth('periode_gaji', $startDate->month)
                ->whereYear('periode_gaji', $startDate->year)
                ->first();
                
            if ($existingPenggajian) {
                $errors++;
                continue;
            }
            
            // Find rekap absen for this employee and period
            $rekapAbsen = RekapAbsen::where('id_karyawan', $karyawan->id_karyawan)
                ->where('periode', $startDate->toDateString())
                ->first();
                
            if (!$rekapAbsen) {
                $errors++;
                continue;
            }
            
            // Calculate total salary based on attendance
            $totalGaji = $gaji->gaji_pokok;
            
            // Apply deductions for absences
            if ($gaji->potongan_izin) {
                $totalGaji -= ($rekapAbsen->jumlah_izin * $gaji->potongan_izin);
            }
            
            if ($gaji->potongan_alpa) {
                $totalGaji -= ($rekapAbsen->jumlah_alpa * $gaji->potongan_alpa);
            }
            
            // Ensure total salary is not negative
            $totalGaji = max(0, $totalGaji);
            
            Penggajian::create([
                'id_karyawan' => $karyawan->id_karyawan,
                'id_rekap' => $rekapAbsen->id_rekap,
                'id_gaji' => $gaji->id_gaji,
                'periode_gaji' => $startDate->toDateTimeString(),
                'total_produksi' => 0, // No production for monthly employees
                'total_gaji' => $totalGaji,
                'tgl_penggajian' => $request->tgl_penggajian,
                'status_penggajian' => $request->status_penggajian,
            ]);
            
            $created++;
        }
        
        DB::commit();
        
        return redirect()->route('admin.penggajian.bulanan.index', ['period' => $request->period])
            ->with('success', "Berhasil membuat $created data penggajian karyawan bulanan. $errors data gagal dibuat.");
    } catch (\Exception $e) {
        DB::rollback();
        \Log::error('Error generating batch: ' . $e->getMessage());
        
        return redirect()->back()
            ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
            ->withInput();
    }
}

    /**
     * Download payslip PDF for a specific salary.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function downloadSlip($id)
    {
        $penggajian = Penggajian::with(['karyawan', 'rekapAbsen', 'gaji'])->findOrFail($id);
        
        // Ensure this is a monthly employee's salary
        if ($penggajian->karyawan->status !== 'bulanan') {
            return redirect()->route('admin.penggajian.bulanan.index')
                ->with('error', 'Data penggajian ini bukan untuk karyawan bulanan!');
        }
        
        $pdf = Pdf::loadView('admin.penggajian.bulanan.slip', compact('penggajian'));
        
        $filename = 'slip-gaji-' . $penggajian->karyawan->nama . '-' . Carbon::parse($penggajian->periode_gaji)->format('Y-m') . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Download salary report PDF for a specific period.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function downloadReport(Request $request)
{
    try {
        $period = $request->input('period', Carbon::now()->format('Y-m'));
        
        // Parse the selected month
        $selectedMonth = Carbon::createFromFormat('Y-m', $period);
        $startDate = $selectedMonth->copy()->startOfMonth();
        $endDate = $selectedMonth->copy()->endOfMonth();
        
        $penggajian = Penggajian::with(['karyawan', 'rekapAbsen', 'gaji'])
            ->whereHas('karyawan', function($query) {
                $query->where('status', 'bulanan');
            })
            ->whereBetween('periode_gaji', [$startDate, $endDate])
            ->get();
        
        // Pass Carbon directly to the view
        $carbon = Carbon::class;
        
        $pdf = PDF::loadView('admin.penggajian.bulanan.report', [
            'penggajian' => $penggajian,
            'period' => $period,
            'Carbon' => $carbon
        ]);
        
        $filename = 'laporan-gaji-bulanan-' . $period . '.pdf';
        
        return $pdf->download($filename);
    } catch (\Exception $e) {
        \Log::error('Error generating PDF report: ' . $e->getMessage());
        \Log::error('Stack trace: ' . $e->getTraceAsString());
        
        return redirect()->route('admin.penggajian.bulanan.index')
            ->with('error', 'Gagal membuat laporan: ' . $e->getMessage());
    }
}
}