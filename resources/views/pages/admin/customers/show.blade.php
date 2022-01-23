@extends('adminlte::page')

@section('title', 'Data Pelanggan')

@section('content')

<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5>Daftar Pelanggan</h5>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <td>Nama Pelanggan</td>
                        <td>{{$customer->name}}</td>
                    </tr>
                    <tr>
                        <td>Email Pelanggan</td>
                        <td>{{$customer->email}}</td>
                    </tr>
                    @if(empty($customer->info))
                        <tr>
                            <td>Nomor Telepon</td>
                            <td>Pelanggan belum mengisi Data</td>
                        </tr>
                        <tr>
                            <td>Alamat Pelanggan</td>
                            <td>Pelanggan belum mengisi Data</td>
                        </tr>
                    @else
                        <tr>
                            <td>Nomor Telepon</td>
                            <td>{{$customer->info->phone}}</td>
                        </tr>
                        <tr>
                            <td>Alamat Pelanggan</td>
                            <td>{{$customer->info->address}}</td>
                        </tr>
                    @endif
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
