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

        $users = User::when($search, function ($query) use ($search) {
            return $query->where('name', 'like', "%{$search}%")
<<<<<<< HEAD
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('role', 'like', "%{$search}%")
                ->orWhere('phone_number', 'like', "%{$search}%");
=======
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('role', 'like', "%{$search}%")
                        ->orWhere('phone_number', 'like', "%{$search}%");
>>>>>>> d76b8a2b8e63c4187c6e59c3e92145e9a9e5c106
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
            'phone_number' => 'required|string|digits_between:10,15|unique:users',
            'role' => 'required|in:admin,karyawan_borongan,karyawan_bulanan',
        ]);

        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'phone_number' => $request->phone_number,
            ]);

            if (str_starts_with($request->role, 'karyawan_')) {
                $karyawanExists = Karyawan::where('nama', $request->name)->first();

                if (!$karyawanExists) {
                    $status = str_replace('karyawan_', '', $request->role);

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
<<<<<<< HEAD
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone_number' => 'required|string|digits_between:10,15|unique:users,phone_number,' . $user->id,
            'role' => 'required|in:admin,karyawan_borongan,karyawan_bulanan',

=======
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'phone_number' => 'required|string|digits_between:10,15|unique:users,phone_number,'.$user->id,
            'role' => 'required|in:admin,karyawan_borongan,karyawan_bulanan',
>>>>>>> d76b8a2b8e63c4187c6e59c3e92145e9a9e5c106
        ]);

        $oldName = $user->name;

        DB::beginTransaction();

        try {
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

            if (str_starts_with($request->role, 'karyawan_')) {
                $status = str_replace('karyawan_', '', $request->role);
                $karyawan = Karyawan::where('nama', $oldName)->first();

                if ($karyawan) {
                    $karyawan->update([
                        'nama' => $request->name,
                        'no_telp' => $request->phone_number,
                        'status' => $status,
                    ]);
                } else {
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
            $karyawan = Karyawan::where('nama', $user->name)->first();

            if ($karyawan) {
                $karyawan->delete();
            }

            $user->delete();

            DB::commit();
            return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
