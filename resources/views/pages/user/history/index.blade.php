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
                <div class="d-flex justify-content-between">
                    @if (Request::url() == route('reports.billings'))
                    <h5>Laporan Data Pembayaran Pelanggan</h5>
                    <button class="btn btn-danger">Cetak Laporan <i class="fas fa-fw fa-print"></i></button>
                    @else
                    <h5>Data Berlangganan Anda</h5>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                @role('admin')
                                <th>Nama Pelanggan</th>
                                @endrole
                                <th>Nama Layanan</th>
                                <th>Status</th>
                                <th>Jumlah Pembayaran</th>
                                <th>Tanggal Pembayaran</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($invoices->isEmpty())
                            <tr>
                                <td colspan="6">
                                    <div class="callout callout-danger">
                                        <h5>Anda belum membeli layanan atau belum melunasi semua tagihan anda</h5>
                                    </div>
                                </td>
                            </tr>
                            @else
                                @foreach ($invoices as $i)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        @role('admin')
                                        <td>{{ $i->user->name }}</td>
                                        @endrole
                                        <td class="text-bold">{{ $i->plan->name }}</td>
                                        <td>
                                            @if ($i->status === 'active')
                                                Lunas
                                            @endif
                                        </td>
                                        <td>
                                            Rp. {{ number_format($i->billing->invoice->total, 2, ',', '.') }}
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($i->billing->invoice->created_at)->format('j F Y, H:i:s') }}
                                        </td>
                                        <td class="d-flex justify-content-center">
                                            <a href="" class="btn btn-success"><i class="fas fa-print" data-toggle="tooltip" data-placement="bottom" title="Cetak Invoice"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
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
