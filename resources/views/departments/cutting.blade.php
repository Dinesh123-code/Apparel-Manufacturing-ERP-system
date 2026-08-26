@extends('layouts.app')

@section('title', 'Cutting Management')
@section('header-title', 'Cutting Department')

@section('content')
<!-- KPI Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card-custom p-3">
            <div class="text-uppercase text-muted font-weight-bold" style="font-size: 10.5px; letter-spacing: 0.5px;">FABRIC SPREADING YARDS</div>
            <div class="h3 font-weight-bold my-1" style="font-size: 24px; font-weight: 800;">48,200 YDS</div>
            <div class="text-muted" style="font-size: 11.5px;">Today's Lay Table Activity</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom p-3">
            <div class="text-uppercase text-muted font-weight-bold" style="font-size: 10.5px; letter-spacing: 0.5px;">TOTAL CUT PIECES</div>
            <div class="h3 font-weight-bold my-1 text-primary" style="font-size: 24px; font-weight: 800;">64,800 PCS</div>
            <div class="text-muted" style="font-size: 11.5px;">Across 14 Marker Lays</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom p-3">
            <div class="text-uppercase text-muted font-weight-bold" style="font-size: 10.5px; letter-spacing: 0.5px;">BUNDLES CREATED</div>
            <div class="h3 font-weight-bold my-1" style="font-size: 24px; font-weight: 800;">1,296 BND</div>
            <div class="text-muted" style="font-size: 11.5px;">Ready for Sewing Lines</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom p-3">
            <div class="text-uppercase text-muted font-weight-bold" style="font-size: 10.5px; letter-spacing: 0.5px;">FABRIC UTILIZATION %</div>
            <div class="h3 font-weight-bold my-1 text-success" style="font-size: 24px; font-weight: 800;">91.2%</div>
            <div class="text-muted" style="font-size: 11.5px;">Marker Efficiency</div>
        </div>
    </div>
</div>

<!-- Table Card -->
<div class="card-custom p-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="h5 font-weight-bold m-0" style="font-weight: 700; font-size: 17px;">Cut Orders & Spreading Lays</h2>
        <button class="btn btn-black"><i class="bi bi-plus-lg me-1"></i> New Cut Lay Plan</button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
            <thead>
                <tr style="background-color: #f9fafb; border-bottom: 2px solid #e5e7eb; color: #6b7280; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">
                    <th style="padding: 12px 14px;">CUT JOB ORDER</th>
                    <th style="padding: 12px 14px;">MARKER ID</th>
                    <th style="padding: 12px 14px;">STYLE NO</th>
                    <th style="padding: 12px 14px;">FABRIC LOT</th>
                    <th class="text-end" style="padding: 12px 14px;">LAY PLIES</th>
                    <th class="text-end" style="padding: 12px 14px;">TOTAL CUT QTY</th>
                    <th style="padding: 12px 14px;">STATUS</th>
                    <th class="text-center" style="padding: 12px 14px;">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $cuts = [
                        ['job' => 'CJ-2026-101', 'marker' => 'MK-TSH-88', 'style' => 'ST-8821', 'lot' => 'LOT-F992', 'plies' => 120, 'qty' => 7200, 'status' => 'COMPLETED', 'bg' => '#dcfce7', 'color' => '#15803d'],
                        ['job' => 'CJ-2026-102', 'marker' => 'MK-JKT-12', 'style' => 'ST-4021', 'lot' => 'LOT-F994', 'plies' => 80,  'qty' => 4800, 'status' => 'IN CUTTING', 'bg' => '#e0f2fe', 'color' => '#0369a1'],
                        ['job' => 'CJ-2026-103', 'marker' => 'MK-DNM-55', 'style' => 'ST-3012', 'lot' => 'LOT-F998', 'plies' => 150, 'qty' => 9000, 'status' => 'QUALITY CHECK', 'bg' => '#fef3c7', 'color' => '#b45309'],
                        ['job' => 'CJ-2026-104', 'marker' => 'MK-POL-34', 'style' => 'ST-9020', 'lot' => 'LOT-F102', 'plies' => 100, 'qty' => 6000, 'status' => 'PENDING SPREAD', 'bg' => '#f3f4f6', 'color' => '#4b5563'],
                    ];
                @endphp
                @foreach($cuts as $c)
                <tr style="border-bottom: 1px solid #f3f4f6;">
                    <td style="padding: 12px 14px;" class="font-mono fw-bold">{{ $c['job'] }}</td>
                    <td style="padding: 12px 14px; font-weight: 500; color: #111827;" class="font-mono">{{ $c['marker'] }}</td>
                    <td style="padding: 12px 14px; color: #4b5563;" class="font-mono">{{ $c['style'] }}</td>
                    <td style="padding: 12px 14px; color: #4b5563;">{{ $c['lot'] }}</td>
                    <td class="text-end fw-semibold" style="padding: 12px 14px;">{{ $c['plies'] }} plies</td>
                    <td class="text-end fw-bold" style="padding: 12px 14px; color: #111827;">{{ number_format($c['qty']) }} pcs</td>
                    <td style="padding: 12px 14px;">
                        <span class="badge" style="background-color: {{ $c['bg'] }}; color: {{ $c['color'] }}; font-size: 11px; font-weight: 700; padding: 4px 8px; border-radius: 4px;">
                            {{ $c['status'] }}
                        </span>
                    </td>
                    <td class="text-center" style="padding: 12px 14px;">
                        <button class="btn btn-sm btn-light border p-1" title="View Cut Sheet"><i class="bi bi-file-earmark-text"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
