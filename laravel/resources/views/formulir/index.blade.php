@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('template') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('template') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('template') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endsection
@section('contents')
    <div class="py-4">

        @if (Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('success') }}
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Formulir</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <a href="{{ route('formulir.create') }}" class="btn btn-sm btn-primary mb-3">
                    <i class="fas fa-plus"></i>&nbsp;Tambah
                </a>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Sekolah</th>
                            <th>Harga</th>
                            <th>Dibuat Oleh</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($formulir as $index => $item)
                            <tr>
                                <td>{{ ++$index }}</td>
                                <td>
                                    {{ $item->sekolah }}
                                </td>
                                <td>{{ number_format($item->harga, 0) }}</td>
                                <td>{{ $item->User->name }}</td>
                                <td>
                                    {!! \App\Models\Formulir::STATUS[$item->status] !!}
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('formulir.detail', ['id' => $item->id]) }}"
                                            class="btn btn-sm btn-light">Detail</a>
                                        @if ($item->created_by == Auth::user()->id)
                                            <a href="{{ route('formulir.edit', ['id' => $item->id]) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            <a href="{{ route('formulir.delete', ['id' => $item->id]) }}"
                                                class="btn btn-sm btn-danger btn-delete">Hapus</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('template') }}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('template') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('template') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('template') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script>
        $(function() {
            $('#example1').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": true,
            });
        });

        $('.btn-delete').on('click', function(e) {
            e.preventDefault()
            let url = $(this).attr('href')

            if (confirm('Apakah anda yakin ingin menghapus formulir ?')) {
                window.location.href = url
            }
        })
    </script>
@endsection
