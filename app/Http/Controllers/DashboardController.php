<?php

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

        $riwayatTransaksi = Payment::whereDate('created_at', $today)
            ->selectRaw('DATE_FORMAT(created_at, "%H:%i:%s") as time, payment_amount, payment_method, order_id')
            ->orderBy('created_at')
            ->get();

        $totalKeuntungan = DB::table('order_details')
            ->join('products', 'order_details.product_id', '=', 'products.product_id')
            ->whereDate('order_details.created_at', $today)
            ->select(DB::raw('SUM((products.harga_jual - products.harga_beli) * order_details.quantity) AS total_keuntungan'))
            ->value('total_keuntungan');

        // Data Laporan Bulanan
        $totalOmsetBulanIni = Payment::whereMonth('payment_date', $currentMonth)
            ->whereYear('payment_date', $currentYear)
            ->sum('payment_amount');

        $jumlahTransaksiBulanIni = Payment::whereMonth('payment_date', $currentMonth)
            ->whereYear('payment_date', $currentYear)
            ->count();

        $totalPendapatanBersih = DB::table('order_details')
            ->join('products', 'order_details.product_id', '=', 'products.product_id')
            ->join('orders', 'order_details.order_id', '=', 'orders.order_id')
            ->whereMonth('orders.order_date', $currentMonth)
            ->whereYear('orders.order_date', $currentYear)
            ->sum(DB::raw('(order_details.unit_price - products.harga_beli) * order_details.quantity'));

        $trenTransaksiHarian = Order::whereMonth('order_date', $currentMonth)
            ->whereYear('order_date', $currentYear)
            ->select(DB::raw('DAY(order_date) as day'), DB::raw('COUNT(*) as jumlah_transaksi'))
            ->groupBy('day')
            ->get();

        $persentaseMetodePembayaran = Payment::whereMonth('payment_date', $currentMonth)
            ->whereYear('payment_date', $currentYear)
            ->select(
                'payment_method',
                DB::raw('COUNT(*) as jumlah'),
                DB::raw('SUM(payment_amount) as total_nominal'),
                DB::raw('COUNT(*) * 100 / (SELECT COUNT(*) FROM payments WHERE MONTH(payment_date) = ' . $currentMonth . ' AND YEAR(payment_date) = ' . $currentYear . ') as persentase')
            )->groupBy('payment_method')->get();

        // Data Produk
        $produkTerlaris = Product::join('order_details', 'products.product_id', '=', 'order_details.product_id')
            ->select('products.product_name', DB::raw('SUM(order_details.quantity) as total_terjual'))
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
