<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\Order;
// use App\Models\OrderDetail;
// use App\Models\Payment;
// use App\Models\Product;
// use Carbon\Carbon;
// use Illuminate\Support\Facades\DB;

// class DashboardController extends Controller
// {
//     // 1. Laporan Realtime Penjualan Hari Ini
//     public function laporanHarian()
//     {
//         $today = Carbon::today();

//         // Total omset hari ini (mengambil total pembayaran dari payment)
//         $totalOmset = Payment::whereDate('payment_date', $today)
//             ->sum('payment_amount');

//         // Jumlah transaksi hari ini
//         $jumlahTransaksi = Payment::whereDate('payment_date', $today)->count();

//         // Riwayat pembayaran per transaksi hari ini
//         $riwayatTransaksi = Payment::join('orders', 'payments.order_id', '=', 'orders.order_id')
//             ->selectRaw('DATE_FORMAT(payments.created_at, "%H:%i:%s") as time, payments.payment_amount, payments.payment_method, orders.order_id')
//             ->whereDate('payments.created_at', $today)
//             ->orderBy('payments.created_at')
//             ->get();

//         $totalKeuntungan = DB::table('order_details')
//             ->join('orders', 'order_details.order_id', '=', 'orders.order_id')
//             ->join('products', 'order_details.product_id', '=', 'products.product_id')
//             ->where('orders.order_date', '>=', $today)
//             ->select(DB::raw('SUM((products.harga_jual - products.harga_beli) * order_details.quantity) AS total_keuntungan'))
//             ->value('total_keuntungan');
    

//         // return response()->json([
//         //     'total_omset_hari_ini' => $totalOmset,
//         //     'jumlah_transaksi_hari_ini' => $jumlahTransaksi,
//         //     'riwayat_transaksi_hari_ini' => $riwayatTransaksi,
//         //     'total_keuntungan_hari_ini' => $totalKeuntungan ?: 0
//         // ]);
//         return view('contents.dashboard', [
//             'totalOmset' => $totalOmset,
//             'jumlahTransaksi' => $jumlahTransaksi,
//             'riwayatTransaksi' => $riwayatTransaksi,
//             'totalKeuntungan' => $totalKeuntungan ?: 0,
//         ]);
//     }

//     // 2. Laporan Bulanan (Bulan Ini)
//     public function laporanBulanan()
//     {
//         // Mendapatkan bulan dan tahun sekarang
//         $currentMonth = Carbon::now()->month;
//         $currentYear = Carbon::now()->year;

//         // Total omset bulan ini
//         $totalOmsetBulanIni = OrderDetail::whereHas('order', function ($query) use ($currentMonth, $currentYear) {
//             $query->whereMonth('order_date', $currentMonth)
//                 ->whereYear('order_date', $currentYear);
//         })->sum(DB::raw('quantity * unit_price'));

//         // Total pendapatan bersih / laba (asumsi laba = harga jual - harga beli)
//         $totalPendapatanBersih = OrderDetail::whereHas('order', function ($query) use ($currentMonth, $currentYear) {
//             $query->whereMonth('order_date', $currentMonth)
//                 ->whereYear('order_date', $currentYear);
//         })->join('products', 'order_details.product_id', '=', 'products.product_id')
//             ->sum(DB::raw('(order_details.unit_price - products.harga_beli) * order_details.quantity'));

//         // Jumlah transaksi bulan ini
//         $jumlahTransaksiBulanIni = Order::whereMonth('order_date', $currentMonth)
//             ->whereYear('order_date', $currentYear)
//             ->count();

//         // Tren transaksi harian di bulan ini
//         $trenTransaksiHarian = Order::whereMonth('order_date', $currentMonth)
//             ->whereYear('order_date', $currentYear)
//             ->select(DB::raw('DAY(order_date) as day'), DB::raw('COUNT(*) as jumlah_transaksi'))
//             ->groupBy('day')
//             ->get();

//         // Persentase metode pembayaran dan jumlah nominal pembayaran untuk tiap metode
//         $persentaseMetodePembayaran = Payment::whereHas('order', function ($query) use ($currentMonth, $currentYear) {
//             $query->whereMonth('order_date', $currentMonth)
//                 ->whereYear('order_date', $currentYear);
//         })
//             ->select(
//                 'payment_method',
//                 DB::raw('COUNT(*) as jumlah'),
//                 DB::raw('SUM(payment_amount) as total_nominal'),
//                 DB::raw('COUNT(*) * 100 / (SELECT COUNT(*) FROM payments WHERE MONTH(payment_date) = ' . $currentMonth . ' AND YEAR(payment_date) = ' . $currentYear . ') as persentase')
//             )
//             ->groupBy('payment_method')
//             ->get();

//         return response()->json([
//             'total_omset_bulan_ini' => $totalOmsetBulanIni,
//             'total_pendapatan_bersih' => $totalPendapatanBersih,
//             'jumlah_transaksi_bulan_ini' => $jumlahTransaksiBulanIni,
//             'tren_transaksi_harian' => $trenTransaksiHarian,
//             'persentase_metode_pembayaran' => $persentaseMetodePembayaran
//         ]);
//     }


    // 3. Produk yang Paling Banyak Dijual dan Produk dengan Stok Hampir Habis
//     public function produkLaporan()
//     {
//         // Produk yang paling banyak dijual (berdasarkan jumlah kuantitas)
//         $produkTerlaris = Product::select('products.product_name', DB::raw('SUM(order_details.quantity) as total_terjual'))
//             ->join('order_details', 'products.product_id', '=', 'order_details.product_id')
//             ->groupBy('products.product_name')
//             ->orderBy('total_terjual', 'desc')
//             ->limit(10)  // Mengambil 10 produk terlaris
//             ->get();

//         // Produk dengan stok hampir habis (asumsi stok <= 10 dianggap hampir habis)
//         $produkHampirHabis = Product::where('quantity_in_stock', '<=', 10)
//             ->orderBy('quantity_in_stock', 'asc')
//             ->get();

//         return response()->json([
//             'produk_terlaris' => $produkTerlaris,
//             'produk_hampir_habis' => $produkHampirHabis
//         ]);
//     }
// }


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Data Laporan Harian
        $totalOmset = Payment::whereDate('payment_date', $today)->sum('payment_amount');
        $jumlahTransaksi = Payment::whereDate('payment_date', $today)->count();

        $riwayatTransaksi = Payment::join('orders', 'payments.order_id', '=', 'orders.order_id')
            ->selectRaw('DATE_FORMAT(payments.created_at, "%H:%i:%s") as time, payments.payment_amount, payments.payment_method, orders.order_id')
            ->whereDate('payments.created_at', $today)
            ->orderBy('payments.created_at')
            ->get();

        $totalKeuntungan = DB::table('order_details')
            ->join('orders', 'order_details.order_id', '=', 'orders.order_id')
            ->join('products', 'order_details.product_id', '=', 'products.product_id')
            ->where('orders.order_date', '>=', $today)
            ->select(DB::raw('SUM((products.harga_jual - products.harga_beli) * order_details.quantity) AS total_keuntungan'))
            ->value('total_keuntungan');

        // Data Laporan Bulanan
        $totalOmsetBulanIni = OrderDetail::whereHas('order', function ($query) use ($currentMonth, $currentYear) {
            $query->whereMonth('order_date', $currentMonth)->whereYear('order_date', $currentYear);
        })->sum(DB::raw('quantity * unit_price'));

        $totalPendapatanBersih = OrderDetail::whereHas('order', function ($query) use ($currentMonth, $currentYear) {
            $query->whereMonth('order_date', $currentMonth)->whereYear('order_date', $currentYear);
        })->join('products', 'order_details.product_id', '=', 'products.product_id')
            ->sum(DB::raw('(order_details.unit_price - products.harga_beli) * order_details.quantity'));

        $jumlahTransaksiBulanIni = Order::whereMonth('order_date', $currentMonth)->whereYear('order_date', $currentYear)->count();

        $trenTransaksiHarian = Order::whereMonth('order_date', $currentMonth)->whereYear('order_date', $currentYear)
            ->select(DB::raw('DAY(order_date) as day'), DB::raw('COUNT(*) as jumlah_transaksi'))
            ->groupBy('day')
            ->get();

        $persentaseMetodePembayaran = Payment::whereHas('order', function ($query) use ($currentMonth, $currentYear) {
            $query->whereMonth('order_date', $currentMonth)->whereYear('order_date', $currentYear);
        })->select(
            'payment_method',
            DB::raw('COUNT(*) as jumlah'),
            DB::raw('SUM(payment_amount) as total_nominal'),
            DB::raw('COUNT(*) * 100 / (SELECT COUNT(*) FROM payments WHERE MONTH(payment_date) = ' . $currentMonth . ' AND YEAR(payment_date) = ' . $currentYear . ') as persentase')
        )->groupBy('payment_method')->get();

        // Data Produk
        $produkTerlaris = Product::select('products.product_name', DB::raw('SUM(order_details.quantity) as total_terjual'))
            ->join('order_details', 'products.product_id', '=', 'order_details.product_id')
            ->groupBy('products.product_name')
            ->orderBy('total_terjual', 'desc')
            ->limit(10)
            ->get();

        $produkHampirHabis = Product::where('quantity_in_stock', '<=', 10)
            ->orderBy('quantity_in_stock', 'asc')
            ->get();

        return view('contents.dashboard', [
            'totalOmset' => $totalOmset,
            'jumlahTransaksi' => $jumlahTransaksi,
            'riwayatTransaksi' => $riwayatTransaksi,
            'totalKeuntungan' => $totalKeuntungan ?: 0,
            'totalOmsetBulanIni' => $totalOmsetBulanIni,
            'totalPendapatanBersih' => $totalPendapatanBersih,
            'jumlahTransaksiBulanIni' => $jumlahTransaksiBulanIni,
            'trenTransaksiHarian' => $trenTransaksiHarian,
            'persentaseMetodePembayaran' => $persentaseMetodePembayaran,
            'produkTerlaris' => $produkTerlaris,
            'produkHampirHabis' => $produkHampirHabis
        ]);
    }
}
