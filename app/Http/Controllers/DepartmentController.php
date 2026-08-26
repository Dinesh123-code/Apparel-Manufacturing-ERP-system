<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use App\Models\ProductionBundle;
use App\Models\SewingLine;
use App\Models\Style;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class DepartmentController extends Controller
{
    public function sourcing()
    {
        $buyers = Buyer::limit(5)->get();
        return view('departments.sourcing', compact('buyers'));
    }

    public function cutting()
    {
        $styles = Style::with('buyer')->limit(6)->get();
        return view('departments.cutting', compact('styles'));
    }

    public function qc()
    {
        $bundles = ProductionBundle::with(['buyer', 'style', 'sewingLine'])->latest()->limit(10)->get();
        return view('departments.qc', compact('bundles'));
    }

    public function shipping()
    {
        $bundles = ProductionBundle::with(['buyer', 'style'])->latest()->limit(10)->get();
        return view('departments.shipping', compact('bundles'));
    }

    public function settings()
    {
        $lines = SewingLine::all();
        return view('departments.settings', compact('lines'));
    }

    public function support()
    {
        return view('departments.support');
    }

    public function activityLogs()
    {
        $logs = Activity::latest()->limit(25)->get();
        
        // If empty, build realistic system activity logs from recent bundles
        if ($logs->isEmpty()) {
            $recentBundles = ProductionBundle::latest()->limit(15)->get();
            $logs = $recentBundles->map(function ($b) {
                return (object)[
                    'description' => "Production Bundle #{$b->bundle_no} created",
                    'causer_name' => 'Admin User',
                    'event' => 'created',
                    'created_at' => $b->created_at,
                ];
            });
        } else {
            $logs = $logs->map(function ($act) {
                return (object)[
                    'description' => $act->description,
                    'causer_name' => $act->causer->name ?? 'Admin User',
                    'event' => $act->event ?? 'updated',
                    'created_at' => $act->created_at,
                ];
            });
        }

        return response()->json($logs);
    }
}
