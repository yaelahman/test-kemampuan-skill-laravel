@extends('layouts.app')
@section('contents')
    <div class="py-4">

        @if (Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('success') }}
            </div>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-danger" role="alert">
                {{ Session::get('error') }}
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detail Formulir</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <a href="{{ route('formulir.index') }}" class="btn btn-sm btn-primary mb-3">
                    <i class="fas fa-list"></i>&nbsp;List
                </a>
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>Sekolah</th>
                        <td>{{ $formulir->sekolah }}</td>
                    </tr>
                    <tr>
                        <th>Harga</th>
                        <td>Rp. {{ number_format($formulir->harga, 0) }}</td>
                    </tr>
                    <tr>
                        <th>Dibuat Oleh</th>
                        <td>{{ $formulir->User->name }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{!! \App\Models\Formulir::STATUS[$formulir->status] !!}</td>
                    </tr>
                </table>
            </div>
            @if ($auth->isAdmin() && $formulir->status == 0)
                <div class="card-footer">
                    <div class="btn-group">
                        <button data-status="1" class="btn btn-sm btn-modal btn-success" data-toggle="modal"
                            data-target="#exampleModal">Terima</button>
                        <button data-status="2" class="btn btn-sm btn-modal btn-danger" data-toggle="modal"
                            data-target="#exampleModal">Tolak</button>
                    </div>
                </div>
            @endif
            <!-- /.card-body -->
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">History Approval Formulir</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @if (count($formulir->HistoryApproval) > 0)
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Diapprove Oleh</th>
                                <th>Tanggal Approval</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($formulir->HistoryApproval as $item)
                                <tr>
                                    <td>{{ $item->User->name }}</td>
                                    <td>{{ date('d/m/Y H:i', strtotime($item->created_at)) }}</td>
                                    <td>{!! \App\Models\Formulir::STATUS[$item->status] !!}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center">
                        <h6>Belum ada aksi approval</h6>
                    </div>
                @endif
            </div>
            <!-- /.card-body -->
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('formulir.approval', ['id' => $formulir->id]) }}" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="alasan">Alasan</label>
                            <textarea name="alasan" id="alasan" required cols="30" rows="10" class="form-control"></textarea>
                        </div>
                        <input type="hidden" name="status" id="status">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Lanjutkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('.btn-modal').on('click', function() {
            let status = $(this).data('status')

            $('#exampleModalLabel').html(`${status == "1" ? 'Terima' : 'Tolak'} Formulir`)
            $('#status').val(status)
        })
    </script>
@endsection
