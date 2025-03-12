@extends('layouts.master')

@section('content')
<div class="container">
    <h2>Register</h2>
    <form method="POST" action="{{ url('/register') }}">
        @csrf
        <input type="text" name="name" placeholder="Nama" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>
        <select name="role">
            <option value="admin">Admin</option>
            <option value="karyawan_borongan">Karyawan Borongan</option>
            <option value="karyawan_bulanan">Karyawan Bulanan</option>
        </select>
        <button type="submit">Register</button>
    </form>
</div>
@endsection
