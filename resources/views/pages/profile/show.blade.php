@extends('adminlte::page')

@section('title', 'Profile')

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
                <h5>Profile</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <td>Nama</td>
                            <td>
                                <input type="text" name="name" class="form-control" value="{{ $user->name }}" disabled>
                            </td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>
                                <input type="text" name="email" class="form-control" value="{{ $user->email }}" disabled>
                            </td>
                        </tr>
                        <form
                            action="{{ isset($user->info->user_id) ? route('user.info.update') : route('user.info.store') }}"
                            method="POST">
                            @csrf
                            @if (isset($user->info->user_id))
                                @method('PUT')
                            @endif
                            <tr>
                                <td>Nomor Telepon</td>
                                {{-- <td>{{ $info->phone }}</td> --}}
                                <td>
                                    <input type="text" name="phone" class="form-control"
                                        value="{{ isset($user->info->phone) ? $user->info->phone : '' }}" required>
                                </td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>
                                    <input type="text" name="address" class="form-control"
                                        value="{{ isset($user->info->address) ? $user->info->address : '' }}" required>
                                </td>
                            </tr>
                            <tr>
                                <td>Kode Pos</td>
                                <td>
                                    {{-- {{ $info->zip_code }} --}}
                                    <input type="text" name="zip_code" class="form-control"
                                        value="{{ isset($user->info->zip_code) ? $user->info->zip_code : '' }}" required>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="d-flex justify-content-end w-100">
                                        <button type="submit" class="btn btn-danger">Simpan Perubahan</button>
                                    </div>
                                </td>
                            </tr>
                        </form>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
