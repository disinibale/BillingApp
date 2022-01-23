@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content')

<div class="container-fluid py-3">
    <div class="card">
        <div class="card-header">
            <h5>Lihat Layanan ({{ $plan->name }})</h5>
        </div>
        <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form @role('admin') action="{{ route('plans.update', $plan->id) }}" @endrole @role('user')
                action="{{ route('user.plans.subscribe', $plan->id) }}" @endrole method="POST">

                @csrf
                @role('admin')
                    @method('PUT')
                @endrole

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <td>Nama Paket Layanan</td>
                            <td>
                                <input name="name" class="form-control" value="{{ $plan->name }}" required
                                    @role('user')readonly @endrole>
                            </td>
                        </tr>
                        <tr>
                            <td>Tipe Layanan</td>
                            <td>
                                {{-- <input name="" class="form-control" value="{{ $plan->type }}" required> --}}
                                @role('user')
                                <input class="form-control" type="text" name="type" value="{{ ucfirst($plan->type) }}" readonly>
                                @endrole
                                @role('admin')
                                <select name="type" class="form-control">
                                    <option value="daily" @if ($plan->type === 'daily') {{ 'selected' }} @endif>Harian</option>
                                    <option value="weekly" @if ($plan->type === 'weekly') {{ 'selected' }} @endif>Mingguan</option>
                                    <option value="monthly" @if ($plan->type === 'monthly') {{ 'selected' }} @endif>Bulanan</option>
                                </select>
                                @endrole
                            </td>
                        </tr>
                        <tr>
                            <td>Deskripsi</td>
                            <td>
                                <textarea name="description" class="form-control" required @role('user')readonly
                                    @endrole>{{ $plan->description }}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>Harga Layanan</td>
                            <td>
                                <input name="price" class="form-control" value="{{ $plan->price }}" required
                                    @role('user')readonly @endrole>
                            </td>
                        </tr>
                    </table>
                </div>

                <input type="hidden" name="start_date" value="13/22/2022">
                <input type="hidden" name="start_date" value="14/22/2022">
                <input type="hidden" name="status" value="inactive">

                @role('admin')
                <button type="submit" class="btn btn-primary float-right">Simpan Perubahan</button>
                @endrole
                @role('user')
                <input type="submit" class="btn btn-primary float-right" value="Berlangganan">
                @endrole
            </form>
        </div>
    </div>
</div>

@endsection
