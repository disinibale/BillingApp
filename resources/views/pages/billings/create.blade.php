@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content')

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

    <div class="container-fluid py-3">
        <div class="card">
            <div class="card-header">
                <h5>Lanjutkan Pembayaran</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped border-dark">
                        <tr class="bg-dark">
                            <td class=" w-25">Periode Pembayaran</td>
                            <td class="text-bold w-25 text-right">
                                {{ $subscription->billing->period }}
                            </td>
                            <td class=" w-25">Batas Waktu Pembayaran</td>
                            <td class="text-bold w-25 text-right">
                                {{ \Carbon\Carbon::parse($subscription->billing->due_date)->format('j F Y, H:i') }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-bold">Tagihan Anda</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-bold">
                                {{ $subscription->plan->name }}
                            </td>
                            <td colspan="2" class="text-bold text-right">
                                Rp. {{ number_format($subscription->plan->price, 2, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Sub Total</td>
                            <td colspan="2" class="text-bold text-right">
                                Rp. {{ number_format($subscription->plan->price, 2, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">PPN</td>
                            <td colspan="2" class="text-bold text-right">
                                {{ round((float) $subscription->plan->tax * 100) }}%
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right">
                                <span class="text-muted">TOTAL TAGIHAN</span>
                                <h4 class="text-bold mb-0">
                                    Rp.
                                    {{ number_format(($subscription->plan->price * ($subscription->plan->tax * 100)) / 100 + $subscription->plan->price, 2, ',', '.') }}
                                </h4>
                                <h6 class="mt-0 h6 text-muted">
                                    Harga sudah termasuk PPN 10%
                                </h6>
                            </td>
                        </tr>
                    </table>
                </div>

                <button class="btn btn-danger float-right" data-toggle="modal" data-target="#payModal">Lanjutkan
                    Pembayaran</button>

            </div>
        </div>
    </div>

    <div class="modal fade" id="payModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Bayar Tagihan Anda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('billings.pay', $subscription->id) }}">
                    @csrf
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <td>
                                        <span class="text-muted">
                                            Total Yang Harus Dibayarkan
                                        </span>
                                        <h5 class="h5 text-bold mb-0">
                                            Rp.
                                            {{ number_format(($subscription->plan->price * ($subscription->plan->tax * 100)) / 100 + $subscription->plan->price, 2, ',', '.') }}
                                        </h5>
                                        <h6 class="mt-0 h6 text-muted">
                                            Harga sudah termasuk PPN 10%
                                        </h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-muted">
                                            Nomor Transaksi
                                        </span>
                                        <h5 class="h5 text-bold mb-0">
                                            <input
                                                    type="text"
                                                    class="bg-none w-100 border-0"
                                                    name="number"
                                                    value="{{ \Ramsey\Uuid\Uuid::uuid1() }}"
                                                    readonly>
                                        </h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span>Masukan Jumlah Pembayaran Anda</span>
                                        <input id="uang" type="text" class="form-control" name="total">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-lg w-100 btn-danger">Bayar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/gh/amiryxe/easy-number-separator/easy-number-separator.js"></script>
    <script>
        easyNumberSeparator({
            'selector': '#uang',
            'separator': '.'
        })
    </script>
@endsection
