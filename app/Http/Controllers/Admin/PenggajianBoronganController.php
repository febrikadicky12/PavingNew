<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gaji;
use App\Models\Karyawan;
use App\Models\Penggajian;
use App\Models\Produksi;
use App\Models\TotalProduksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenggajianBoronganController extends Controller
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
        
        $penggajianQuery = Penggajian::with(['karyawan', 'gaji'])
            ->whereHas('karyawan', function($query) {
                $query->where('status', 'borongan');
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
        
        return view('admin.penggajian.borongan.index', compact('penggajian', 'period', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $karyawans = Karyawan::where('status', 'borongan')->get();
        $gajis = Gaji::where('jenis_karyawan', 'borongan')->get();
        $totalProduksis = TotalProduksi::with('karyawan')
            ->whereHas('karyawan', function($query) {
                $query->where('status', 'borongan');
            })
            ->whereDoesntHave('penggajian') // Assuming relation is set up to filter out already paid
            ->orderBy('periode_produksi', 'desc')
            ->get();
        
        return view('admin.penggajian.borongan.create', compact('karyawans', 'gajis', 'totalProduksis'));
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
            'id_totalproduksi' => 'required|exists:total_produksi,id_totalproduksi',
            'id_gaji' => 'required|exists:gaji,id_gaji',
            'tgl_penggajian' => 'required|date',
            'status_penggajian' => 'required|in:sudah bayar,belum dibayar',
        ]);

        // Get the total produksi data
        $totalProduksi = TotalProduksi::with('produksi')->findOrFail($request->id_totalproduksi);
        
        // Verify the karyawan ID matches
        if ($totalProduksi->id_karyawan != $request->id_karyawan) {
            return redirect()->back()
                ->with('error', 'ID karyawan tidak sesuai dengan data total produksi!')
                ->withInput();
        }
        
        // Check if penggajian already exists for this total_produksi
        $existingPenggajian = Penggajian::where('id_karyawan', $request->id_karyawan)
            ->whereDate('periode_gaji', Carbon::parse($totalProduksi->periode_produksi)->format('Y-m-d'))
            ->first();
            
        if ($existingPenggajian) {
            return redirect()->back()
                ->with('error', 'Data penggajian untuk karyawan dan periode ini sudah ada!')
                ->withInput();
        }
        
        // Get gaji data
        $gaji = Gaji::findOrFail($request->id_gaji);
        
        if ($gaji->jenis_karyawan !== 'borongan') {
            return redirect()->back()
                ->with('error', 'Data gaji yang dipilih bukan untuk karyawan borongan!')
                ->withInput();
        }
        
        // Calculate total production
        $jumlahProduksi = $totalProduksi->produksi->sum('jumlah_produksi');
        
        // Calculate total salary based on production
        $totalGaji = $jumlahProduksi * $gaji->tarif_produksi;
        
        DB::beginTransaction();
        
        try {
            Penggajian::create([
                'id_karyawan' => $request->id_karyawan,
                'id_rekap' => 0, // No rekap absen for production workers
                'id_gaji' => $request->id_gaji,
                'periode_gaji' => $totalProduksi->periode_produksi,
                'total_produksi' => $jumlahProduksi,
                'total_gaji' => $totalGaji,
                'tgl_penggajian' => $request->tgl_penggajian,
                'status_penggajian' => $request->status_penggajian,
            ]);
            
            DB::commit();
            
            return redirect()->route('admin.penggajian.borongan.index')
                ->with('success', 'Data penggajian karyawan borongan berhasil disimpan!');
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
        $penggajian = Penggajian::with(['karyawan', 'gaji'])->findOrFail($id);
        
        // Ensure this is a production worker's salary
        if ($penggajian->karyawan->status !== 'borongan') {
            return redirect()->route('admin.penggajian.borongan.index')
                ->with('error', 'Data penggajian ini bukan untuk karyawan borongan!');
        }
        
        // Get total produksi details if available
        $totalProduksi = TotalProduksi::with('produksi')
            ->where('id_karyawan', $penggajian->id_karyawan)
            ->whereDate('periode_produksi', Carbon::parse($penggajian->periode_gaji)->format('Y-m-d'))
            ->first();
        
        return view('admin.penggajian.borongan.show', compact('penggajian', 'totalProduksi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $penggajian = Penggajian::with(['karyawan', 'gaji'])->findOrFail($id);
        
        // Ensure this is a production worker's salary
        if ($penggajian->karyawan->status !== 'borongan') {
            return redirect()->route('admin.penggajian.borongan.index')
                ->with('error', 'Data penggajian ini bukan untuk karyawan borongan!');
        }
        
        $gajis = Gaji::where('jenis_karyawan', 'borongan')->get();
        
        // Get total produksi for this payroll
        $totalProduksi = TotalProduksi::with('produksi')
            ->where('id_karyawan', $penggajian->id_karyawan)
            ->whereDate('periode_produksi', Carbon::parse($penggajian->periode_gaji)->format('Y-m-d'))
            ->first();
        
        return view('admin.penggajian.borongan.edit', compact('penggajian', 'gajis', 'totalProduksi'));
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
        
        // Ensure this is a production worker's salary
        if ($penggajian->karyawan->status !== 'borongan') {
            return redirect()->route('admin.penggajian.borongan.index')
                ->with('error', 'Data penggajian ini bukan untuk karyawan borongan!');
        }
        
        // Get gaji data
        $gaji = Gaji::findOrFail($request->id_gaji);
        
        if ($gaji->jenis_karyawan !== 'borongan') {
            return redirect()->back()
                ->with('error', 'Data gaji yang dipilih bukan untuk karyawan borongan!')
                ->withInput();
        }
        
        // Recalculate total salary based on production
        $totalGaji = $penggajian->total_produksi * $gaji->tarif_produksi;
        
        DB::beginTransaction();
        
        try {
            $penggajian->update([
                'id_gaji' => $request->id_gaji,
                'total_gaji' => $totalGaji,
                'tgl_penggajian' => $request->tgl_penggajian,
                'status_penggajian' => $request->status_penggajian,
            ]);
            
            DB::commit();
            
            return redirect()->route('admin.penggajian.borongan.index')
                ->with('success', 'Data penggajian karyawan borongan berhasil diperbarui!');
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
    public function destroy($id)
    {
        $penggajian = Penggajian::findOrFail($id);
        
        // Ensure this is a production worker's salary
        if ($penggajian->karyawan->status !== 'borongan') {
            return redirect()->route('admin.penggajian.borongan.index')
                ->with('error', 'Data penggajian ini bukan untuk karyawan borongan!');
        }
        
        $penggajian->delete();
        
        return redirect()->route('admin.penggajian.borongan.index')
            ->with('success', 'Data penggajian karyawan borongan berhasil dihapus!');
    }
    
    /**
     * Generate salary reports for production workers.
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
        
        // Get gaji data
        $gaji = Gaji::findOrFail($request->id_gaji);
        
        if ($gaji->jenis_karyawan !== 'borongan') {
            return redirect()->back()
                ->with('error', 'Data gaji yang dipilih bukan untuk karyawan borongan!')
                ->withInput();
        }
        
        // Get all total produksi records for this period
        $totalProduksis = TotalProduksi::with(['karyawan', 'produksi'])
            ->whereHas('karyawan', function($query) {
                $query->where('status', 'borongan');
            })
            ->whereBetween('periode_produksi', [$startDate, $endDate])
            ->get();
        
        $created = 0;
        $errors = 0;
        
        DB::beginTransaction();
        
        try {
            foreach ($totalProduksis as $totalProduksi) {
                // Skip if penggajian for this employee and period already exists
                $existingPenggajian = Penggajian::where('id_karyawan', $totalProduksi->id_karyawan)
                    ->whereDate('periode_gaji', Carbon::parse($totalProduksi->periode_produksi)->format('Y-m-d'))
                    ->first();
                    
                if ($existingPenggajian) {
                    $errors++;
                    continue;
                }
                
                // Calculate total production
                $jumlahProduksi = $totalProduksi->produksi->sum('jumlah_produksi');
                
                // Calculate total salary based on production
                $totalGaji = $jumlahProduksi * $gaji->tarif_produksi;
                
                Penggajian::create([
                    'id_karyawan' => $totalProduksi->id_karyawan,
                    'id_rekap' => 0, // No rekap absen for production workers
                    'id_gaji' => $gaji->id_gaji,
                    'periode_gaji' => $totalProduksi->periode_produksi,
                    'total_produksi' => $jumlahProduksi,
                    'total_gaji' => $totalGaji,
                    'tgl_penggajian' => $request->tgl_penggajian,
                    'status_penggajian' => $request->status_penggajian,
                ]);
                
                $created++;
            }
            
            DB::commit();
            
            return redirect()->route('admin.penggajian.borongan.index', ['period' => $request->period])
                ->with('success', "Berhasil membuat $created data penggajian karyawan borongan. $errors data gagal dibuat.");
        } catch (\Exception $e) {
            DB::rollback();
            
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
        $penggajian = Penggajian::with(['karyawan', 'gaji'])->findOrFail($id);
        
        // Ensure this is a production worker's salary
        if ($penggajian->karyawan->status !== 'borongan') {
            return redirect()->route('admin.penggajian.borongan.index')
                ->with('error', 'Data penggajian ini bukan untuk karyawan borongan!');
        }
        
        // Get total produksi details
        $totalProduksi = TotalProduksi::with('produksi')
            ->where('id_karyawan', $penggajian->id_karyawan)
            ->whereDate('periode_produksi', Carbon::parse($penggajian->periode_gaji)->format('Y-m-d'))
            ->first();
        
        $pdf = Pdf::loadView('admin.penggajian.borongan.slip', [
            'penggajian' => $penggajian,
            'totalProduksi' => $totalProduksi
        ]);
        
        $filename = 'slip-gaji-' . $penggajian->karyawan->nama . '-' . Carbon::parse($penggajian->periode_gaji)->format('Y-m-d') . '.pdf';
        
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
        $period = $request->input('period', Carbon::now()->format('Y-m'));
        
        // Parse the selected month
        $selectedMonth = Carbon::createFromFormat('Y-m', $period);
        $startDate = $selectedMonth->copy()->startOfMonth();
        $endDate = $selectedMonth->copy()->endOfMonth();
        
        $penggajian = Penggajian::with(['karyawan', 'gaji'])
            ->whereHas('karyawan', function($query) {
                $query->where('status', 'borongan');
            })
            ->whereBetween('periode_gaji', [$startDate, $endDate])
            ->get();
        
        $pdf = Pdf::loadView('admin.penggajian.borongan.report', [
            'penggajian' => $penggajian,
            'period' => $period,
        ]);
        
        return $pdf->download('laporan-gaji-borongan-' . $period . '.pdf');
    }

}