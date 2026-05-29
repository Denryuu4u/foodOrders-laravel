<?php

namespace App\Http\Controllers;

use App\Models\FoodOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ── Stat cards ──────────────────────────────────────────
        $totalUsers      = User::count();
        $totalOrders     = FoodOrder::count();
        $pendingOrders   = FoodOrder::where('status', 'Pending')->count();
        $deliveredOrders = FoodOrder::where('status', 'Delivered')->count();

        // ── Chart 1: Orders per status (Doughnut) ───────────────
        $ordersByStatus = FoodOrder::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        // ── Chart 2: New users per month (Bar) ───────────────────
        $usersPerMonth = User::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');

        // Fill all 12 months (0 if no data)
        $monthlyUsers = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthlyUsers[] = $usersPerMonth[$m] ?? 0;
        }

        // ── Chart 3: Orders per month (Line) ─────────────────────
        $ordersPerMonth = FoodOrder::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');

        $monthlyOrders = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthlyOrders[] = $ordersPerMonth[$m] ?? 0;
        }

        return view('dashboard.index', compact(
            'totalUsers',
            'totalOrders',
            'pendingOrders',
            'deliveredOrders',
            'ordersByStatus',
            'monthlyUsers',
            'monthlyOrders'
        ));
    }
}
