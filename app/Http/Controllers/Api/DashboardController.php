<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductionBundle;

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

        return response()->json([
            'success' => true,
            'data'    => [
                'total_bundles'    => (int) $stats->total_bundles,
                'total_quantity'   => (int) $stats->total_quantity,
                'total_completed'  => (int) $stats->total_completed,
                'total_rejected'   => (int) $stats->total_rejected,
                'avg_efficiency'   => round((float) $stats->avg_efficiency, 2),
                'today_production' => (int) $stats->today_production,
                'today_rejection'  => (int) $stats->today_rejection,
            ],
        ]);
    }
}
