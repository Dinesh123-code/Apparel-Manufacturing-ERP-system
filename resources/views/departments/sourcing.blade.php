@extends('layouts.app')

@section('title', 'Sourcing Management')
@section('header-title', 'Sourcing & Fabric Procurement')

@section('content')
<!-- KPI Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card-custom p-3">
            <div class="text-uppercase text-muted font-weight-bold" style="font-size: 10.5px; letter-spacing: 0.5px;">TOTAL FABRIC PURCHASED</div>
            <div class="h3 font-weight-bold my-1" style="font-size: 24px; font-weight: 800;">142,500 KGS</div>
            <div class="text-success" style="font-size: 11.5px;"><i class="bi bi-arrow-up-right"></i> +12% vs last month</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom p-3">
            <div class="text-uppercase text-muted font-weight-bold" style="font-size: 10.5px; letter-spacing: 0.5px;">PENDING RAW FABRICS</div>
            <div class="h3 font-weight-bold my-1" style="font-size: 24px; font-weight: 800;">18,400 KGS</div>
            <div class="text-muted" style="font-size: 11.5px;">Expected in 3 days</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom p-3">
            <div class="text-uppercase text-muted font-weight-bold" style="font-size: 10.5px; letter-spacing: 0.5px;">ACTIVE SUPPLIERS</div>
            <div class="h3 font-weight-bold my-1" style="font-size: 24px; font-weight: 800;">24 VENDORS</div>
            <div class="text-muted" style="font-size: 11.5px;">Verified Mills</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom p-3">
            <div class="text-uppercase text-muted font-weight-bold" style="font-size: 10.5px; letter-spacing: 0.5px;">QUALITY PASS RATE</div>
            <div class="h3 font-weight-bold my-1 text-success" style="font-size: 24px; font-weight: 800;">98.4%</div>
            <div class="text-muted" style="font-size: 11.5px;">Shrinkage & Shade Check</div>
        </div>
    </div>
</div>

<!-- Table Card -->
<div class="card-custom p-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="h5 font-weight-bold m-0" style="font-weight: 700; font-size: 17px;">Fabric & Raw Material Purchase Orders</h2>
        <button class="btn btn-black"><i class="bi bi-plus-lg me-1"></i> New Purchase Order</button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
            <thead>
                <tr style="background-color: #f9fafb; border-bottom: 2px solid #e5e7eb; color: #6b7280; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">
                    <th style="padding: 12px 14px;">PO NUMBER</th>
                    <th style="padding: 12px 14px;">SUPPLIER MILL</th>
                    <th style="padding: 12px 14px;">FABRIC TYPE / GSM</th>
                    <th style="padding: 12px 14px;">COLOR</th>
                    <th class="text-end" style="padding: 12px 14px;">QTY (KGS)</th>
                    <th style="padding: 12px 14px;">DELIVERY DATE</th>
                    <th style="padding: 12px 14px;">STATUS</th>
                    <th class="text-center" style="padding: 12px 14px;">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $pos = [
                        ['po' => 'PO-SR-901', 'mill' => 'Pacific Textiles Ltd', 'fabric' => '100% Cotton Single Jersey 180GSM', 'color' => 'Navy Blue', 'qty' => 4500, 'date' => '2026-08-28', 'status' => 'RECEIVED', 'bg' => '#dcfce7', 'colorText' => '#15803d'],
                        ['po' => 'PO-SR-902', 'mill' => 'Viyellatex Fabrics', 'fabric' => '95% Cotton 5% Elastane Rib 220GSM', 'color' => 'Black', 'qty' => 2800, 'date' => '2026-08-30', 'status' => 'IN TRANSIT', 'bg' => '#e0f2fe', 'colorText' => '#0369a1'],
                        ['po' => 'PO-SR-903', 'mill' => 'Ha-Meem Textile Mills', 'fabric' => '100% Cotton Fleece 300GSM', 'color' => 'Heather Grey', 'qty' => 6200, 'date' => '2026-09-02', 'status' => 'PENDING INSPECTION', 'bg' => '#fef3c7', 'colorText' => '#b45309'],
                        ['po' => 'PO-SR-904', 'mill' => 'Square Textiles', 'fabric' => 'Polyester Micro Mesh 140GSM', 'color' => 'White', 'qty' => 1900, 'date' => '2026-09-05', 'status' => 'RECEIVED', 'bg' => '#dcfce7', 'colorText' => '#15803d'],
                    ];
                @endphp
                @foreach($pos as $p)
                <tr style="border-bottom: 1px solid #f3f4f6;">
                    <td style="padding: 12px 14px;" class="font-mono fw-bold">{{ $p['po'] }}</td>
                    <td style="padding: 12px 14px; font-weight: 500; color: #111827;">{{ $p['mill'] }}</td>
                    <td style="padding: 12px 14px; color: #4b5563;">{{ $p['fabric'] }}</td>
                    <td style="padding: 12px 14px; color: #4b5563;">{{ $p['color'] }}</td>
                    <td class="text-end fw-bold" style="padding: 12px 14px; color: #111827;">{{ number_format($p['qty']) }} KGS</td>
                    <td style="padding: 12px 14px; color: #4b5563;">{{ $p['date'] }}</td>
                    <td style="padding: 12px 14px;">
                        <span class="badge" style="background-color: {{ $p['bg'] }}; color: {{ $p['colorText'] }}; font-size: 11px; font-weight: 700; padding: 4px 8px; border-radius: 4px;">
                            {{ $p['status'] }}
                        </span>
                    </td>
                    <td class="text-center" style="padding: 12px 14px;">
                        <button class="btn btn-sm btn-light border p-1" title="View PO"><i class="bi bi-eye"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
