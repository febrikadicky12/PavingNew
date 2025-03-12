@extends('layouts.master')

@section('content')
    <h1>Selamat datang, {{ auth()->user()->name }}</h1>
    <p>Role: {{ auth()->user()->role }}</p>
@endsection
