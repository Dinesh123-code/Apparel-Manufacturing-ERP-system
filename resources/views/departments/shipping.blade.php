@extends('layouts.app')

@section('title', 'Shipping Management')
@section('header-title', 'Shipping & Packing Dispatch')

@section('content')
<!-- KPI Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card-custom p-3">
            <div class="text-uppercase text-muted font-weight-bold" style="font-size: 10.5px; letter-spacing: 0.5px;">TOTAL SHIPPED BUNDLES</div>
            <div class="h3 font-weight-bold my-1" style="font-size: 24px; font-weight: 800;">38,400 BND</div>
            <div class="text-muted" style="font-size: 11.5px;">1,280 Export Cartons</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom p-3">
            <div class="text-uppercase text-muted font-weight-bold" style="font-size: 10.5px; letter-spacing: 0.5px;">ON-TIME SHIPMENT RATE</div>
            <div class="h3 font-weight-bold my-1 text-success" style="font-size: 24px; font-weight: 800;">99.1%</div>
            <div class="text-muted" style="font-size: 11.5px;">On Schedule Deliveries</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom p-3">
            <div class="text-uppercase text-muted font-weight-bold" style="font-size: 10.5px; letter-spacing: 0.5px;">DISPATCH IN PACKING</div>
            <div class="h3 font-weight-bold my-1 text-primary" style="font-size: 24px; font-weight: 800;">4,200 PCS</div>
            <div class="text-muted" style="font-size: 11.5px;">Polybagged & Barcoded</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom p-3">
            <div class="text-uppercase text-muted font-weight-bold" style="font-size: 10.5px; letter-spacing: 0.5px;">ACTIVE FREIGHT CONTAINERS</div>
            <div class="h3 font-weight-bold my-1" style="font-size: 24px; font-weight: 800;">6 CONTAINERS</div>
            <div class="text-muted" style="font-size: 11.5px;">Port Chittagong Loading</div>
        </div>
    </div>
</div>

<!-- Table Card -->
<div class="card-custom p-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="h5 font-weight-bold m-0" style="font-weight: 700; font-size: 17px;">Commercial Export Shipping Logs</h2>
        <button class="btn btn-black"><i class="bi bi-plus-lg me-1"></i> New Shipping Order</button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
            <thead>
                <tr style="background-color: #f9fafb; border-bottom: 2px solid #e5e7eb; color: #6b7280; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">
                    <th style="padding: 12px 14px;">SHIPMENT ID</th>
                    <th style="padding: 12px 14px;">BUYER NAME</th>
                    <th style="padding: 12px 14px;">STYLE / PO</th>
                    <th class="text-end" style="padding: 12px 14px;">CARTON COUNT</th>
                    <th class="text-end" style="padding: 12px 14px;">GARMENT QTY</th>
                    <th style="padding: 12px 14px;">DESTINATION PORT</th>
                    <th style="padding: 12px 14px;">STATUS</th>
                    <th class="text-center" style="padding: 12px 14px;">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $ships = [
                        ['id' => 'SHP-2026-401', 'buyer' => 'Global Retail', 'style' => 'ST-8821 / PO-992', 'cartons' => 240, 'qty' => 12000, 'port' => 'Hamburg, Germany', 'status' => 'PORT DISPATCHED', 'bg' => '#dcfce7', 'color' => '#15803d'],
                        ['id' => 'SHP-2026-402', 'buyer' => 'Urban Out', 'style' => 'UO-22X / PO-881', 'cartons' => 180, 'qty' => 9000, 'port' => 'Felixstowe, UK', 'status' => 'IN PACKING', 'bg' => '#e0f2fe', 'color' => '#0369a1'],
                        ['id' => 'SHP-2026-403', 'buyer' => 'Metro Wear', 'style' => 'MW-501 / PO-774', 'cartons' => 320, 'qty' => 16000, 'port' => 'New York, USA', 'status' => 'PORT DISPATCHED', 'bg' => '#dcfce7', 'color' => '#15803d'],
                        ['id' => 'SHP-2026-404', 'buyer' => 'H&M Logistics', 'style' => 'HM-102 / PO-661', 'cartons' => 150, 'qty' => 7500, 'port' => 'Rotterdam, Netherlands', 'status' => 'CUSTOMS PENDING', 'bg' => '#fef3c7', 'color' => '#b45309'],
                    ];
                @endphp
                @foreach($ships as $s)
                <tr style="border-bottom: 1px solid #f3f4f6;">
                    <td style="padding: 12px 14px;" class="font-mono fw-bold">{{ $s['id'] }}</td>
                    <td style="padding: 12px 14px; font-weight: 600; color: #111827;">{{ $s['buyer'] }}</td>
                    <td style="padding: 12px 14px; color: #4b5563;" class="font-mono">{{ $s['style'] }}</td>
                    <td class="text-end fw-semibold" style="padding: 12px 14px;">{{ number_format($s['cartons']) }} ctns</td>
                    <td class="text-end fw-bold" style="padding: 12px 14px; color: #111827;">{{ number_format($s['qty']) }} pcs</td>
                    <td style="padding: 12px 14px; color: #4b5563;"><i class="bi bi-geo-alt me-1 text-danger"></i> {{ $s['port'] }}</td>
                    <td style="padding: 12px 14px;">
                        <span class="badge" style="background-color: {{ $s['bg'] }}; color: {{ $s['color'] }}; font-size: 11px; font-weight: 700; padding: 4px 8px; border-radius: 4px;">
                            {{ $s['status'] }}
                        </span>
                    </td>
                    <td class="text-center" style="padding: 12px 14px;">
                        <button class="btn btn-sm btn-light border p-1" title="View Manifest"><i class="bi bi-truck"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
