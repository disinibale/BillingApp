@extends('adminlte::page')

@section('title', 'Data Pelanggan')

@section('content')

    <div class="container-fluid py-3">
        <div class="card mt-4">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    @if (Request::url() === route('reports.customers'))
                        <h5>Laporan Data Pelanggan</h5>
                        <button class="btn btn-danger">Cetak Laporan <i class="fas fa-fw fa-print"></i></button>
                    @else
                        <h5>Daftar Pelanggan</h5>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    @if ($customers->isEmpty())
                        <div class="callout callout-danger w-100">
                            <h4 class="text-bold">Belum ada data pelanggan.</h4>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <th class="text-center">No</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Email Pelanggan</th>
                                    <th>Nomor Telepon</th>
                                    <th>Alamat</th>
                                    @if (Request::url() != route('reports.customers'))
                                        <th class="text-center">Aksi</th>
                                    @endif
                                </thead>
                                <tbody>
                                    @foreach ($customers as $cus)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $cus->name }}</td>
                                            <td>{{ $cus->email }}</td>
                                            @if (empty($cus->info))
                                                <td>Pelanggan belum mengisi data</td>
                                                <td>Pelanggan belum mengisi data</td>
                                            @else
                                                <td>{{ $cus->info->phone }}</td>
                                                <td>{{ $cus->info->address }}</td>
                                            @endif
                                            @if (Request::url() != route('reports.customers'))
                                                <td class="d-flex justify-content-center">
                                                    <a href="{{ route('customers.show', $cus->id) }}"
                                                        class="btn btn-success" data-toggle="tooltip"
                                                        data-placement="bottom" title="Lihat Pelanggan">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                        </tr>
                                    @endif
                    @endforeach
                    </tbody>
                    </table>
                </div>
                @endif
            </div>
            {{ $customers->links('vendor.pagination.bootstrap-4') }}
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
