<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::when($search, function($query) use ($search) {
            return $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('role', 'like', "%{$search}%")
                        ->orWhere('phone_number', 'like', "%{$search}%");
        })->paginate(10);

        return view('admin.users.index', compact('users', 'search'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,karyawan_borongan,karyawan_bulanan',
            'phone_number' => 'required|string|max:15',
        ]);

        DB::beginTransaction();
        
        try {
            // Buat user terlebih dahulu
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'phone_number' => $request->phone_number,
            ]);
            
            // Jika role adalah karyawan, buat record karyawan juga
            if (str_starts_with($request->role, 'karyawan_')) {
                // Cek apakah karyawan dengan nama tersebut sudah ada
                $karyawanExists = Karyawan::where('nama', $request->name)->first();
                
                if (!$karyawanExists) {
                    // Tentukan status berdasarkan role
                    $status = str_replace('karyawan_', '', $request->role);
                    
                    // Buat record karyawan baru dengan nomor telepon dari user
                    Karyawan::create([
                        'nama' => $request->name,
                        'no_telp' => $request->phone_number,
                        'status' => $status,
                    ]);
                }
            }
            
            DB::commit();
            return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $karyawan = Karyawan::where('nama', $user->name)->first();
        return view('admin.users.edit', compact('user', 'karyawan'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'role' => 'required|in:admin,karyawan_borongan,karyawan_bulanan',
            'phone_number' => 'required|string|max:15',
        ]);

        $oldName = $user->name;
        
        DB::beginTransaction();
        
        try {
            // Update data user
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'phone_number' => $request->phone_number,
            ]);

            if ($request->filled('password')) {
                $request->validate([
                    'password' => 'string|min:8',
                ]);
                $user->update([
                    'password' => Hash::make($request->password),
                ]);
            }

            // Cek jika rolenya karyawan
            if (str_starts_with($request->role, 'karyawan_')) {
                $status = str_replace('karyawan_', '', $request->role);
                
                // Cari karyawan yang namanya sama dengan nama lama user
                $karyawan = Karyawan::where('nama', $oldName)->first();
                
                if ($karyawan) {
                    // Update karyawan yang sudah ada dengan nomor telepon baru
                    $karyawan->update([
                        'nama' => $request->name, // Update nama jika nama user berubah
                        'no_telp' => $request->phone_number, // Selalu update nomor telepon
                        'status' => $status,
                    ]);
                } else {
                    // Jika tidak ada karyawan dengan nama tersebut, buat baru
                    Karyawan::create([
                        'nama' => $request->name,
                        'no_telp' => $request->phone_number,
                        'status' => $status,
                    ]);
                }
            }
            
            DB::commit();
            return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(User $user)
    {
        DB::beginTransaction();
        
        try {
            // Cek apakah ada karyawan dengan nama yang sama
            $karyawan = Karyawan::where('nama', $user->name)->first();
            
            // Hapus karyawan jika ada
            if ($karyawan) {
                $karyawan->delete();
            }
            
            // Hapus user
            $user->delete();
            
            DB::commit();
            return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}