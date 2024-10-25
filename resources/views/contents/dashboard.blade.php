@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card position-relative">
            <div class="card-body">
                <div class="row">
                    <h2 class="text-black text-center">Laporan Harian</h2>
                    <div class="col-md-12 col-xl-5 d-flex flex-column justify-content-start">
                        <div class="ml-xl-4 mt-3">
                            <h6 class="font-weight-light mb-1 text-primary text-center">Pendapatan Hari Ini</h6>
                            <h2 class="text-primary text-center fs-30 font-weight-medium mb-3">Rp{{ number_format($totalOmset) }}</h2>

                            <h6 class="font-weight-light mb-1 text-success text-center">Keuntungan Hari Ini</h6>
                            <h2 class="text-success text-center fs-30 font-weight-medium mb-3">Rp{{ number_format($totalKeuntungan) }}</h2>

                            <h6 class="font-weight-light mb-1 text-info text-center">Total Pelanggan</h6>
                            <h2 class="text-info text-center fs-30 font-weight-medium mb-3">{{ $jumlahTransaksi }}</h2>
                        </div>
                    </div>
                    <div class="col-md-12 col-xl-7">
                        <div class="row">
                            <div class="card card-body">
                                <div class="table-responsive">
                                    <p class="card-title mb-0 text-center">Transaksi Hari Ini</p>
                                    <table class="table table-striped table-borderless">
                                        <thead>
                                            <tr>
                                                <th>Waktu</th>
                                                <th>Jumlah Pembayaran</th>
                                                <th>Metode Pembayaran</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($riwayatTransaksi as $transaksi)
                                            <tr>
                                                <td>{{ $transaksi->time }}</td>
                                                <td>Rp{{ number_format($transaksi->payment_amount) }}</td>
                                                <td>{{ $transaksi->payment_method }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
