@extends('layouts.app')

@section('content')
<style>
    .table-striped tbody tr:nth-child(odd) {
        background-color: #f9f9f9;
    }

    .table-striped tbody tr:nth-child(even) {
        background-color: #ffffff;
    }

    .table-striped tbody tr.empty-row {
        min-height: 40px;
    }

    /* Perkecil tinggi baris tabel */
    .table-striped th,
    .table-striped td {
        padding: 8px 10px;
        font-size: 14px;
    }

    /* Atur ukuran maksimal untuk tinggi list-wrapper */
    .list-wrapper {
        max-height: 250px;
        overflow-y: auto;
    }

    .table-responsive {
        max-width: 100%;
    }

</style>

<div class="col-md-12 grid-margin stretch-card">
    <div class="card position-relative">
        <div class="card-body">
            <div class="row mt-4">
                <div class="col-md-6 grid-margin transparent">
                    <div class="row">
                        <div class="col-md-6 mb-4 stretch-card transparent">
                            <div class="card align-self-center">
                                <div class="card-people mt-auto">
                                    <img src="{{ asset('assets/images/laporanharian.png')}}" alt="" style="width: 75%; display: block; margin: auto;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4 stretch-card transparent">
                            <div class="card card-dark-blue">
                                <div class="card-body">
                                    <p class="mb-4">Pendapatan Hari Ini</p>
                                    <p class="fs-30 mb-2">Rp{{ number_format($totalOmset) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                            <div class="card card-light-blue">
                                <div class="card-body">
                                    <p class="mb-4">Keuntungan Hari Ini</p>
                                    <p class="fs-30 mb-2">Rp{{ number_format($totalKeuntungan) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 stretch-card transparent">
                            <div class="card card-tale">
                                <div class="card-body">
                                    <p class="mb-4">Total Pelanggan</p>
                                    <p class="fs-30 mb-2">{{ $jumlahTransaksi }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card mb-0">
                        <p class="card-title mb-2 text-center">Transaksi Hari Ini</p>
                        <div class="card card-body">
                            <div class="table-responsive list-wrapper">
                                <table class="table table-striped table-borderless">
                                    <thead>
                                        <tr>
                                            <th>Waktu</th>
                                            <th>Jumlah Pembayaran</th>
                                            <th>Metode Pembayaran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($riwayatTransaksi as $transaksi)
                                        <tr>
                                            <td>{{ $transaksi->time }}</td>
                                            <td>Rp{{ number_format($transaksi->payment_amount) }}</td>
                                            <td>{{ $transaksi->payment_method }}</td>
                                        </tr>
                                        @empty
                                        <tr class="empty-row">
                                            <td colspan="3" class="text-center">Tidak ada transaksi hari ini</td>
                                        </tr>
                                        @endforelse
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

<div class="col-md-12 grid-margin stretch-card">
    <div class="card position-relative">
        <div class="card-body">
            <div class="row mt-4">
                <div class="col-md-6 grid-margin transparent">
                    <div class="row">
                        <div class="col-md-6 mb-4 stretch-card transparent">
                            <div class="card align-self-center">
                                <div class="card-people mt-auto">
                                    <img src="{{ asset('assets/images/laporanharian.png')}}" alt="" style="width: 75%; display: block; margin: auto;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4 stretch-card transparent">
                            <div class="card card-dark-blue">
                                <div class="card-body">
                                    <p class="mb-4">Pendapatan Bulan Ini</p>
                                    <p class="fs-30 mb-2">Rp{{ number_format($totalOmsetBulanIni) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                            <div class="card card-light-blue">
                                <div class="card-body">
                                    <p class="mb-4">Keuntungan Bulan Ini</p>
                                    <p class="fs-30 mb-2">Rp{{ number_format($totalPendapatanBersih) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 stretch-card transparent">
                            <div class="card card-tale">
                                <div class="card-body">
                                    <p class="mb-4">Total Pelanggan</p>
                                    <p class="fs-30 mb-2">{{ $jumlahTransaksiBulanIni }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card mb-0">
                        <p class="card-title mb-2 text-center">Tren Transaksi Harian Bulan Ini</p>
                        <div class="card card-body">
                            <canvas id="trenTransaksiChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Get the data from PHP
    const labels = @json($trenTransaksiHarian->pluck('day'));
    const data = @json($trenTransaksiHarian->pluck('jumlah_transaksi'));

    const ctx = document.getElementById('trenTransaksiChart').getContext('2d');
    const trenTransaksiChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Transaksi',
                data: data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3 // Smooth line
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Transaksi'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Hari'
                    }
                }
            }
        }
    });
</script>

@endsection
