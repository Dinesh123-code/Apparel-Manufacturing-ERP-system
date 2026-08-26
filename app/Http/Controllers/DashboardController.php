<?php

namespace App\Http\Controllers;

use App\Models\ProductionBundle;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        $stats = ProductionBundle::query()
            ->selectRaw("
                COUNT(*) as total_bundles,
                COALESCE(SUM(quantity), 0) as total_quantity,
                COALESCE(SUM(completed_qty), 0) as total_completed,
                COALESCE(SUM(rejected_qty), 0) as total_rejected,
                COALESCE(AVG(CASE WHEN quantity > 0 THEN (completed_qty / quantity) * 100 ELSE 0 END), 0) as avg_efficiency,
                COALESCE(SUM(CASE WHEN production_date = ? THEN quantity ELSE 0 END), 0) as today_production,
                COALESCE(SUM(CASE WHEN production_date = ? THEN rejected_qty ELSE 0 END), 0) as today_rejection
            ", [$today, $today])
            ->first();

        // Last 7 days trend
        $trend = ProductionBundle::query()
            ->selectRaw('production_date, SUM(completed_qty) as completed, SUM(rejected_qty) as rejected')
            ->where('production_date', '>=', now()->subDays(6)->toDateString())
            ->groupBy('production_date')
            ->orderBy('production_date')
            ->get();

        // Top buyers by efficiency
        $topBuyers = ProductionBundle::with('buyer')
            ->selectRaw('buyer_id, AVG(CASE WHEN quantity > 0 THEN (completed_qty / quantity) * 100 ELSE 0 END) as efficiency')
            ->groupBy('buyer_id')
            ->orderByDesc('efficiency')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact('stats', 'trend', 'topBuyers'));
    }
}
