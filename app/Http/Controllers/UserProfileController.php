<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserProfileController extends Controller
{
    /**
     * Display the user profile page
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get the authenticated user
        $user = Auth::user();
        
        return view('profile.index', compact('user'));
    }

    /**
     * Show the form for editing the user's profile
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        // Get the authenticated user
        $user = Auth::user();
        
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();
        
        // Validate the input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Update the user's profile
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        
        return redirect()->route('profile.index')->with('success', 'Profil berhasil diubah!');
    }

    /**
     * Check user role and authorize access if needed
     *
     * @param  string  $role
     * @return bool
     */
    private function authorizeRole($role)
    {
        // Check if the authenticated user has the specified role
        return Auth::user()->role === $role;
    }

    /**
     * Check if the user is an admin
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->authorizeRole('admin');
    }

    /**
     * Check if the user is a karyawan borongan
     *
     * @return bool
     */
    public function isKaryawanBorongan()
    {
        return $this->authorizeRole('karyawan borongan');
    }

    /**
     * Check if the user is a karyawan bulanan
     *
     * @return bool
     */
    public function isKaryawanBulanan()
    {
        return $this->authorizeRole('karyawan bulanan');
    }
}