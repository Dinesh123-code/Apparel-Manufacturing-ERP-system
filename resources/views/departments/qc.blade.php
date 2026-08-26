@extends('layouts.app')

@section('title', 'Quality Control (QC)')
@section('header-title', 'Quality Control & Audit')

@section('content')
<!-- KPI Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card-custom p-3">
            <div class="text-uppercase text-muted font-weight-bold" style="font-size: 10.5px; letter-spacing: 0.5px;">TOTAL AUDITED BUNDLES</div>
            <div class="h3 font-weight-bold my-1" style="font-size: 24px; font-weight: 800;">1,180 BND</div>
            <div class="text-muted" style="font-size: 11.5px;">Today's Quality Check</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom p-3">
            <div class="text-uppercase text-muted font-weight-bold" style="font-size: 10.5px; letter-spacing: 0.5px;">PASSED RATE</div>
            <div class="h3 font-weight-bold my-1 text-success" style="font-size: 24px; font-weight: 800;">96.2%</div>
            <div class="text-muted" style="font-size: 11.5px;">AQL 2.5 Standard</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom p-3">
            <div class="text-uppercase text-muted font-weight-bold" style="font-size: 10.5px; letter-spacing: 0.5px;">REJECTED DEFECTS</div>
            <div class="h3 font-weight-bold my-1 text-danger" style="font-size: 24px; font-weight: 800;">45 BUNDLES</div>
            <div class="text-muted" style="font-size: 11.5px;">Sent to Rework</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom p-3">
            <div class="text-uppercase text-muted font-weight-bold" style="font-size: 10.5px; letter-spacing: 0.5px;">TOP DEFECT TYPE</div>
            <div class="h3 font-weight-bold my-1 text-warning" style="font-size: 20px; font-weight: 800;">Stitch Skip (42%)</div>
            <div class="text-muted" style="font-size: 11.5px;">Tension Adjustment Req.</div>
        </div>
    </div>
</div>

<!-- Table Card -->
<div class="card-custom p-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="h5 font-weight-bold m-0" style="font-weight: 700; font-size: 17px;">Quality Audit Logs</h2>
        <button class="btn btn-black"><i class="bi bi-plus-lg me-1"></i> New QC Audit Log</button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
            <thead>
                <tr style="background-color: #f9fafb; border-bottom: 2px solid #e5e7eb; color: #6b7280; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">
                    <th style="padding: 12px 14px;">AUDIT ID</th>
                    <th style="padding: 12px 14px;">BUNDLE NO</th>
                    <th style="padding: 12px 14px;">SEWING LINE</th>
                    <th style="padding: 12px 14px;">QC AUDITOR</th>
                    <th class="text-end" style="padding: 12px 14px;">CHECKED QTY</th>
                    <th class="text-end" style="padding: 12px 14px;">DEFECT COUNT</th>
                    <th style="padding: 12px 14px;">DEFECT DETAILS</th>
                    <th style="padding: 12px 14px;">AUDIT VERDICT</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $qcs = [
                        ['id' => 'QC-2026-801', 'bnd' => 'BN-1842', 'line' => 'Line A1', 'auditor' => 'Sarah Smith', 'checked' => 500, 'defects' => 2, 'details' => 'Minor thread loose', 'verdict' => 'PASSED', 'bg' => '#dcfce7', 'color' => '#15803d'],
                        ['id' => 'QC-2026-802', 'bnd' => 'BN-1843', 'line' => 'Line A1', 'auditor' => 'Sarah Smith', 'checked' => 600, 'defects' => 1, 'details' => 'Shade variation', 'verdict' => 'PASSED', 'bg' => '#dcfce7', 'color' => '#15803d'],
                        ['id' => 'QC-2026-803', 'bnd' => 'BN-1844', 'line' => 'Line B2', 'auditor' => 'Mike Ross', 'checked' => 350, 'defects' => 25, 'details' => 'Stitch skip & hem twist', 'verdict' => 'REJECTED', 'bg' => '#fee2e2', 'color' => '#b91c1c'],
                        ['id' => 'QC-2026-804', 'bnd' => 'BN-1845', 'line' => 'Line C1', 'auditor' => 'John Doe', 'checked' => 400, 'defects' => 8, 'details' => 'Buttonhole misaligned', 'verdict' => 'REWORK', 'bg' => '#fef3c7', 'color' => '#b45309'],
                    ];
                @endphp
                @foreach($qcs as $q)
                <tr style="border-bottom: 1px solid #f3f4f6;">
                    <td style="padding: 12px 14px;" class="font-mono fw-bold">{{ $q['id'] }}</td>
                    <td style="padding: 12px 14px; font-weight: 600;" class="font-mono">{{ $q['bnd'] }}</td>
                    <td style="padding: 12px 14px; color: #4b5563;">{{ $q['line'] }}</td>
                    <td style="padding: 12px 14px; color: #4b5563;">{{ $q['auditor'] }}</td>
                    <td class="text-end fw-semibold" style="padding: 12px 14px;">{{ number_format($q['checked']) }} pcs</td>
                    <td class="text-end fw-bold text-danger" style="padding: 12px 14px;">{{ $q['defects'] }}</td>
                    <td style="padding: 12px 14px; color: #4b5563;">{{ $q['details'] }}</td>
                    <td style="padding: 12px 14px;">
                        <span class="badge" style="background-color: {{ $q['bg'] }}; color: {{ $q['color'] }}; font-size: 11px; font-weight: 700; padding: 4px 8px; border-radius: 4px;">
                            {{ $q['verdict'] }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
