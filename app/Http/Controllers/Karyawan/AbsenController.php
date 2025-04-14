<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Absen;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AbsenController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:karyawan_bulanan');
    }

    /**
     * Display attendance form.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get current logged-in user
        $user = Auth::user();
        
        // Find the karyawan associated with the user
        $karyawan = Karyawan::where('nama', $user->name)->first();
        
        if (!$karyawan || $karyawan->status !== 'bulanan') {
            return redirect()->route('home')
                ->with('error', 'Anda tidak memiliki akses sebagai karyawan bulanan.');
        }
        
        // Get today's date
        $today = Carbon::today()->toDateString();
        
        // Check if user has already submitted attendance today
        $todayAttendance = Absen::where('id_karyawan', $karyawan->id_karyawan)
                                ->where('tanggal', $today)
                                ->first();
        
        // Get attendance history for current user (last 30 days)
        $attendanceHistory = Absen::where('id_karyawan', $karyawan->id_karyawan)
                                  ->orderBy('tanggal', 'desc')
                                  ->take(30)
                                  ->get();
        
        return view('karyawan.bulanan.absen.index', compact('karyawan', 'todayAttendance', 'attendanceHistory', 'today'));
    }

    /**
     * Store attendance record.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|in:masuk,ijin,alpha',
        ]);
        
        // Get current logged-in user
        $user = Auth::user();
        
        // Find the karyawan associated with the user
        $karyawan = Karyawan::where('nama', $user->name)->first();
        
        if (!$karyawan || $karyawan->status !== 'bulanan') {
            return redirect()->route('home')
                ->with('error', 'Anda tidak memiliki akses sebagai karyawan bulanan.');
        }
        
        // Get today's date
        $today = Carbon::today()->toDateString();
        
        // Check if user has already submitted attendance today
        $existingAttendance = Absen::where('id_karyawan', $karyawan->id_karyawan)
                                   ->where('tanggal', $today)
                                   ->first();
        
        if ($existingAttendance) {
            return redirect()->route('karyawan.bulanan.absen.index')
                ->with('error', 'Anda sudah melakukan absensi hari ini.');
        }
        
        // Create new attendance record
        DB::beginTransaction();
        
        try {
            Absen::create([
                'id_karyawan' => $karyawan->id_karyawan,
                'status' => $request->status,
                'tanggal' => $today,
            ]);
            
            DB::commit();
            
            return redirect()->route('karyawan.bulanan.absen.index')
                ->with('success', 'Absensi berhasil dicatat.');
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->route('karyawan.bulanan.absen.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}