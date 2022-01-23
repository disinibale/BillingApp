@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content')

    <div class="container-fluid py-3">

        @if (session('success'))
            <div class="alert alert-success">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h5>Data Berlangganan Anda</h5>
            </div>
            <div class="card-body">
                @if ($subscriptions->isEmpty())
                    <div class="callout callout-danger">
                        <h5>Anda belum berlangganan dengan layanan telkomsel</h5>
                        <p>Silahkan berlangganan terlebih dahulu di menu layanan</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="bg-secondary">
                                <tr>
                                    @role('admin')
                                    <th>Nama Pelanggan</th>
                                    @endrole
                                    <th>Nama Layanan</th>
                                    <th>Harga</th>
                                    <th>Periode Pembayaran</th>
                                    <th>Tanggal Berlangganan Dimulai</th>
                                    <th>Tanggal Berlangganan Berakhir</th>
                                    <th>Status</th>
                                    @role('user')
                                    <th class="text-center">Aksi</th>
                                    @endrole
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subscriptions as $subs)
                                    <tr>
                                        @role('admin')
                                        <td>
                                            {{ $subs->user->name }}
                                        </td>
                                        @endrole
                                        <td>{{ $subs->plan->name }}</td>
                                        <td>
                                            Rp. {{ number_format($subs->plan->price, 2, ',', '.') }}
                                        </td>
                                        <td>{{ ucfirst($subs->plan->type) }}</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($subs->start_date)->format('j F Y') }}
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($subs->end_date)->format('j F Y') }}
                                        </td>
                                        <td>
                                            @if ($subs->status === 'inactive')
                                                <span class="text-danger">
                                                    {{ 'Belum Dibayar' }}
                                                </span>
                                            @else
                                                <span class="text-success">
                                                    {{ 'Aktif' }}
                                                </span>
                                            @endif
                                        </td>
                                        @role('user')
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('billings.create', $subs->id) }}"
                                                    class="btn btn-primary mr-2 @if ($subs->status === 'active') disabled @endif" data-toggle="tooltip"
                                                    data-placement="bottom" title="Lanjutkan Pembayaran">
                                                    <i class="fas fa-sign-in-alt"></i>
                                                </a>
                                                <form action="" method="POST">
                                                    <button class="btn btn-danger" data-toggle="tooltip"
                                                        data-placement="bottom" title="Berhenti Berlangganan">
                                                        <i class="fas fa-ban"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                        @endrole
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $subscriptions->links('vendor.pagination.bootstrap-4') }}

                @endif
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endsection
