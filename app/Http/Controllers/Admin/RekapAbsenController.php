<?php

namespace App\Http\Controllers\Admin;

use Barryvdh\DomPDF\Facade\Pdf; // Updated import statement for Laravel 9+

use App\Http\Controllers\Controller;
use App\Models\Absen;
use App\Models\Karyawan;
use App\Models\RekapAbsen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RekapAbsenController extends Controller
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
     * Display a listing of the attendance records.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $month = $request->input('month', Carbon::now()->format('Y-m'));
        $search = $request->input('search');
        
        // Get all karyawan with status 'bulanan'
        $karyawanQuery = Karyawan::where('status', 'bulanan');
        
        // Apply search filter if provided
        if ($search) {
            $karyawanQuery->where('nama', 'like', "%{$search}%");
        }
        
        $karyawans = $karyawanQuery->get();
        
        // Parse the selected month
        $selectedMonth = Carbon::createFromFormat('Y-m', $month);
        $startDate = $selectedMonth->copy()->startOfMonth();
        $endDate = $selectedMonth->copy()->endOfMonth();
        
        // Get all attendance records for the selected month
        $attendanceData = [];
        
        foreach ($karyawans as $karyawan) {
            $absensi = Absen::where('id_karyawan', $karyawan->id_karyawan)
                            ->whereBetween('tanggal', [$startDate->toDateString(), $endDate->toDateString()])
                            ->get();
            
            $hadir = $absensi->where('status', 'masuk')->count();
            $izin = $absensi->where('status', 'ijin')->count();
            $alpha = $absensi->where('status', 'alpha')->count();
            
            // Find or create recap record for this month
            $rekap = RekapAbsen::firstOrNew([
                'id_karyawan' => $karyawan->id_karyawan,
                'periode' => $startDate->toDateString(),
            ]);
            
            if (!$rekap->exists) {
                $rekap->jumlah_hadir = $hadir;
                $rekap->jumlah_izin = $izin;
                $rekap->jumlah_alpa = $alpha;
                $rekap->save();
            }
            
            $attendanceData[] = [
                'karyawan' => $karyawan,
                'hadir' => $hadir,
                'izin' => $izin,
                'alpha' => $alpha,
                'rekap' => $rekap,
            ];
        }
        
        return view('admin.rekap_absen.index', compact('attendanceData', 'month', 'search'));
    }

    /**
     * Show detailed attendance records for a specific employee.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id_karyawan)
    {
        $month = $request->month ?? now()->format('Y-m');
    
        // Tentukan awal dan akhir bulan
        $startDate = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $endDate = Carbon::createFromFormat('Y-m', $month)->endOfMonth();
    
        // Ambil data karyawan
        $karyawan = Karyawan::findOrFail($id_karyawan);
    
        // Ambil semua absen untuk karyawan dan bulan tersebut
        $absensi = Absen::where('id_karyawan', $id_karyawan)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get()
            // Pastikan key menggunakan format tanggal yang benar
            ->keyBy(fn($absen) => Carbon::parse($absen->tanggal)->toDateString());
    
        // Buat kalender harian untuk bulan tsb
        $calendar = [];
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $tanggalStr = $date->toDateString();
    
            // Ambil status jika tersedia, jika tidak tampilkan "kosong"
            $status = isset($absensi[$tanggalStr]) ? $absensi[$tanggalStr]->status : 'kosong';
    
            $calendar[] = [
                'date' => $tanggalStr,
                'status' => $status,
            ];
        }
    
        return view('admin.rekap_absen.show', compact('karyawan', 'calendar', 'month'));
    }
    
    /**
     * Download PDF report of attendance records.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function downloadPdf(Request $request)
    {
        $month = $request->input('month', Carbon::now()->format('Y-m'));
        $search = $request->input('search');

        $karyawanQuery = Karyawan::where('status', 'bulanan');
        if ($search) {
            $karyawanQuery->where('nama', 'like', "%{$search}%");
        }

        $karyawans = $karyawanQuery->get();
        $selectedMonth = Carbon::createFromFormat('Y-m', $month);
        $startDate = $selectedMonth->copy()->startOfMonth();
        $endDate = $selectedMonth->copy()->endOfMonth();

        $attendanceData = [];

        foreach ($karyawans as $karyawan) {
            $absensi = Absen::where('id_karyawan', $karyawan->id_karyawan)
                            ->whereBetween('tanggal', [$startDate->toDateString(), $endDate->toDateString()])
                            ->get();

            $hadir = $absensi->where('status', 'masuk')->count();
            $izin = $absensi->where('status', 'ijin')->count();
            $alpha = $absensi->where('status', 'alpha')->count();

            $attendanceData[] = [
                'nama' => $karyawan->nama,
                'hadir' => $hadir,
                'izin' => $izin,
                'alpha' => $alpha,
            ];
        }

        $pdf = Pdf::loadView('admin.rekap_absen.pdf', [
            'attendanceData' => $attendanceData,
            'month' => $month,
        ]);

        return $pdf->download('rekap-absensi-' . $month . '.pdf');
    }
    
    /**
     * Generate monthly attendance report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function generateReport(Request $request)
    {
        $month = $request->input('month', Carbon::now()->format('Y-m'));
        
        // Parse the selected month
        $selectedMonth = Carbon::createFromFormat('Y-m', $month);
        $startDate = $selectedMonth->copy()->startOfMonth();
        
        // Get all karyawan with status 'bulanan'
        $karyawans = Karyawan::where('status', 'bulanan')->get();
        
        DB::beginTransaction();
        
        try {
            foreach ($karyawans as $karyawan) {
                // Count attendance for the selected month
                $hadir = Absen::where('id_karyawan', $karyawan->id_karyawan)
                              ->where('tanggal', 'like', $month . '%')
                              ->where('status', 'masuk')
                              ->count();
                
                $izin = Absen::where('id_karyawan', $karyawan->id_karyawan)
                              ->where('tanggal', 'like', $month . '%')
                              ->where('status', 'ijin')
                              ->count();
                
                $alpha = Absen::where('id_karyawan', $karyawan->id_karyawan)
                              ->where('tanggal', 'like', $month . '%')
                              ->where('status', 'alpha')
                              ->count();
                
                // Update or create recap record
                RekapAbsen::updateOrCreate(
                    [
                        'id_karyawan' => $karyawan->id_karyawan,
                        'periode' => $startDate->toDateString(),
                    ],
                    [
                        'jumlah_hadir' => $hadir,
                        'jumlah_izin' => $izin,
                        'jumlah_alpa' => $alpha,
                    ]
                );
            }
            
            DB::commit();
            
            return redirect()->route('admin.rekap_absen.index', ['month' => $month])
                ->with('success', 'Laporan rekap absensi berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->route('admin.rekap_absen.index', ['month' => $month])
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}