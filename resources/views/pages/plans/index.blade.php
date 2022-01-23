@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content')

    <div class="container-fluid py-3">

        @if (session('success'))
            <div class="callout callout-success">
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
                    <h5>Paket Layanan</h5>
                    @role('admin')
                    <button type="buttom" class="btn btn-danger" data-toggle="modal" data-target="#modalAdd">Buat
                        Layanan</button>
                    @endrole
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    @if ($plans->isEmpty())
                        <div class="callout callout-danger w-100">
                            <h4 class="text-bold">Belum ada Layanan yang tersedia</h4>
                            @role('admin')
                                <p>
                                    Silahkan buat layanan untuk pelanggan terlebih dahulu
                                </p>
                            @endrole
                        </div>
                    @else
                        @foreach ($plans as $plan)
                            <div class="col-3">
                                <div class="card card-outline card-danger">
                                    <div class="card-body">
                                        <h5 class="card-title text-bold">{{ $plan->name }}</h5><br>
                                        <h6 class="text-left text-muted text-secondary"> {{ strtoupper($plan->type) }} </h6>
                                        <p class="card-text">{{ $plan->description }}</p>
                                        <p class="text-dark">
                                            Harga : Rp.
                                                {{ number_format($plan->price, 2, ',', '.') }} +
                                            PPN {{ round((float) $plan->tax * 100) }}%</p>
                                    </div>
                                    <div class="card-footer">
                                        <div class="d-flex justify-content-end">
                                            @role('admin')
                                                <a data-toggle="tooltip" data-placement="bottom" title="Lihat Layanan"
                                                    href="{{ route('plans.show', $plan->id) }}"
                                                    class="btn btn-danger mr-2 card-link">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <form action="{{ route('plans.destroy', $plan->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger card-link"
                                                        data-toggle="tooltip" data-placement="bottom" title="Hapus Layanan">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endrole
                                            @role('user')
                                                <a href="{{ route('user.plans.show', $plan->id) }}" class="btn btn-danger card-link" data-toggle="tooltip" data-placement="bottom" title="Lihat Layanan">
                                                    <i class="fas fa-eye" aria-hidden="true"></i>
                                                </a>
                                                <form action="{{ route('user.plans.subscribe', $plan->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn ml-2 btn-danger card-link" data-toggle="tooltip" data-placement="bottom" title="Berlangganan">
                                                        <i class="fas fa-play" aria-hidden="true"></i>
                                                    </button>
                                                </form>
                                            @endrole
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                {{ $plans->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Buat Layanan Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('plans.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <td>Nama Layanan</td>
                                    <td>
                                        <input type="text" name="name" class="form-control" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tipe Layanan</td>
                                    <td>
                                        <select name="type" class="form-control">
                                            <option value="daily">Harian</option>
                                            <option value="weekly">Mingguan</option>
                                            <option value="monthly">Bulanan</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Deskripsi</td>
                                    <td>
                                        <textarea type="text" name="description" class="form-control" required></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Harga Layanan</td>
                                    <td>
                                        <input type="text" name="price" class="form-control" required>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Buat Layanan</button>
                    </div>
                </form>
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
