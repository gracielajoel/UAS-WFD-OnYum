<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        // Total revenue for current month
        $totalRevenue = DB::table('ordered_menus')
            ->join('menus', 'ordered_menus.menu_id', '=', 'menus.id')
            ->join('reservations', 'ordered_menus.reservation_id', '=', 'reservations.id')
            ->where('reservations.status', 'Finished')
            ->whereMonth('reservations.date', now()->month)
            ->whereYear('reservations.date', now()->year)
            ->sum(DB::raw('menus.price * ordered_menus.quantity'));



        // Monthly report (6 bulan terakhir)
        $monthlyReport = DB::table('ordered_menus')
            ->join('menus', 'ordered_menus.menu_id', '=', 'menus.id')
            ->join('reservations', 'ordered_menus.reservation_id', '=', 'reservations.id')
            ->where('reservations.status', 'Finished')
            ->selectRaw("TO_CHAR(reservations.date, 'Mon YYYY') as month, SUM(menus.price * ordered_menus.quantity) as total")
            ->groupByRaw("TO_CHAR(reservations.date, 'Mon YYYY')")
            ->orderByRaw("MIN(reservations.date)") // agar urut waktu
            ->limit(6)
            ->get();


        // Yearly report
        $yearlyReport = DB::table('ordered_menus')
            ->join('menus', 'ordered_menus.menu_id', '=', 'menus.id')
            ->join('reservations', 'ordered_menus.reservation_id', '=', 'reservations.id')
            ->where('reservations.status', 'Finished')
            ->selectRaw("EXTRACT(YEAR FROM reservations.date) as year, SUM(menus.price * ordered_menus.quantity) as total")
            ->groupByRaw("EXTRACT(YEAR FROM reservations.date)")
            ->orderBy('year', 'desc')
            ->get();
        
        // Top 10 menu bulan ini
        $topMenusThisMonth = DB::table('ordered_menus')
            ->join('menus', 'ordered_menus.menu_id', '=', 'menus.id')
            ->join('reservations', 'ordered_menus.reservation_id', '=', 'reservations.id')
            ->where('reservations.status', 'Finished')
            ->whereMonth('reservations.date', now()->month)
            ->whereYear('reservations.date', now()->year)
            ->select('menus.name as menu_name', DB::raw('SUM(ordered_menus.quantity) as total'))
            ->groupBy('menus.name')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        // Top 10 menu all time
        $topMenusAllTime = DB::table('ordered_menus')
            ->join('menus', 'ordered_menus.menu_id', '=', 'menus.id')
            ->join('reservations', 'ordered_menus.reservation_id', '=', 'reservations.id')
            ->where('reservations.status', 'Finished')
            ->select('menus.name as menu_name', DB::raw('SUM(ordered_menus.quantity) as total'))
            ->groupBy('menus.name')
            ->orderByDesc('total')
            ->limit(10)
            ->get();



        return view('orders.index', compact(
            'totalRevenue',
            'monthlyReport',
            'yearlyReport',
            'topMenusThisMonth',
            'topMenusAllTime'
        ));
    }
}
