@extends('layouts.app')
@section('styles')
@endsection
@section('contents')
    <div class="py-4">

        @if (Session::has('error'))
            <div class="alert alert-danger" role="alert">
                {{ Session::get('error') }}
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tambah Formulir</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <a href="{{ route('formulir.index') }}" class="btn btn-sm btn-primary mb-3">
                    <i class="fas fa-list"></i>&nbsp;List
                </a>

                <form action="{{ route('formulir.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $formulir->id ?? '' }}">
                    <div class="form-group">
                        <label for="sekolah">Nama Sekolah</label>
                        <input type="text" class="form-control" value="{{ $formulir->sekolah ?? '' }}" name="sekolah"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga Sekolah</label>
                        <input type="number" class="form-control" value="{{ $formulir->harga ?? '' }}" name="harga"
                            required>
                    </div>
                    <button class="my-2 btn btn-primary">
                        <i class="fas fa-save"></i>&nbsp; Simpan
                    </button>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
@endsection
@section('scripts')
@endsection
