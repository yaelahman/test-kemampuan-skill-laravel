@extends('layouts.app')
@section('contents')
    <div class="container">
        <div class="py-4">
            <h6>Selamat Datang, {{ Auth::user()->name }}</h6>
            <h6>Role Anda, {{ Auth::user()->role }}</h6>
        </div>
    </div>
@endsection
