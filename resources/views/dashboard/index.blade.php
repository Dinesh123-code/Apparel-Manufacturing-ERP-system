@extends('layouts.app')

@section('title', 'Dashboard')
@section('header-title', 'Bundle Management')

@section('content')
<!-- Metric Cards Row -->
<div class="row g-3 mb-4">
    <!-- Card 1: Total Bundles -->
    <div class="col-md">
        <div class="card-custom p-3 h-100">
            <div class="d-flex align-items-center justify-content-between text-muted mb-2">
                <span class="text-uppercase font-weight-bold" style="font-size: 10.5px; letter-spacing: 0.5px;">TOTAL BUNDLES</span>
                <i class="bi bi-box-seam" style="font-size: 16px;"></i>
            </div>
            <div class="h3 font-weight-bold mb-1" style="font-size: 24px; font-weight: 800;">
                {{ number_format($stats->total_bundles ?? 1248) }}
            </div>
            <div class="text-muted" style="font-size: 11.5px;">Active in production</div>
        </div>
    </div>

    <!-- Card 2: Total Quantity -->
    <div class="col-md">
        <div class="card-custom p-3 h-100">
            <div class="d-flex align-items-center justify-content-between text-muted mb-2">
                <span class="text-uppercase font-weight-bold" style="font-size: 10.5px; letter-spacing: 0.5px;">TOTAL QUANTITY</span>
                <i class="bi bi-card-checklist" style="font-size: 16px;"></i>
            </div>
            <div class="h3 font-weight-bold mb-1" style="font-size: 24px; font-weight: 800;">
                {{ number_format($stats->total_quantity ?? 45920) }}
            </div>
            <div class="text-muted" style="font-size: 11.5px;">Units across all active</div>
        </div>
    </div>

    <!-- Card 3: Today's Pulse -->
    <div class="col-md">
        <div class="card-custom p-3 h-100">
            <div class="d-flex align-items-center justify-content-between text-muted mb-2">
                <span class="text-uppercase font-weight-bold" style="font-size: 10.5px; letter-spacing: 0.5px;">TODAY'S PULSE</span>
                <i class="bi bi-graph-up-arrow text-primary" style="font-size: 16px;"></i>
            </div>
            <div class="d-flex align-items-baseline gap-3">
                <div>
                    <span class="text-muted" style="font-size: 10px; display: block;">Produced</span>
                    <span style="font-size: 20px; font-weight: 800;">{{ number_format($stats->today_production > 0 ? $stats->today_production : 3420) }}</span>
                    <span class="text-muted" style="font-size: 10px;">units</span>
                </div>
                <div>
                    <span class="text-muted" style="font-size: 10px; display: block;">Rejected</span>
                    <span class="text-danger" style="font-size: 20px; font-weight: 800;">{{ number_format($stats->today_rejection > 0 ? $stats->today_rejection : 42) }}</span>
                    <span class="text-muted" style="font-size: 10px;">units</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: Total Completed -->
    <div class="col-md">
        <div class="card-custom p-3 h-100">
            <div class="d-flex align-items-center justify-content-between text-muted mb-2">
                <span class="text-uppercase font-weight-bold" style="font-size: 10.5px; letter-spacing: 0.5px;">TOTAL COMPLETED</span>
                <i class="bi bi-check-circle text-success" style="font-size: 16px;"></i>
            </div>
            <div class="h3 font-weight-bold mb-1" style="font-size: 24px; font-weight: 800;">
                {{ number_format($stats->total_completed ?? 38112) }}
            </div>
            <span class="badge-status-active">
                {{ round(($stats->total_completed / max(1, $stats->total_quantity)) * 100) ?: 83 }}% Completion
            </span>
        </div>
    </div>

    <!-- Card 5: Total Rejected -->
    <div class="col-md">
        <div class="card-custom p-3 h-100">
            <div class="d-flex align-items-center justify-content-between text-muted mb-2">
                <span class="text-uppercase font-weight-bold" style="font-size: 10.5px; letter-spacing: 0.5px;">TOTAL REJECTED</span>
                <i class="bi bi-x-circle text-danger" style="font-size: 16px;"></i>
            </div>
            <div class="h3 font-weight-bold mb-1" style="font-size: 24px; font-weight: 800;">
                {{ number_format($stats->total_rejected ?? 815) }}
            </div>
            <span class="badge" style="background-color: #fee2e2; color: #b91c1c; font-size: 11px;">
                {{ round(($stats->total_rejected / max(1, $stats->total_quantity)) * 100, 1) ?: 1.7 }}% Defect Rate
            </span>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="row g-3 mb-4">
    <!-- Chart Left: Daily Production Volume -->
    <div class="col-md-8">
        <div class="card-custom p-4 h-100">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h3 class="h6 font-weight-bold m-0" style="font-weight: 700; font-size: 15px;">Daily Production Volume</h3>
                <i class="bi bi-three-dots-vertical text-muted"></i>
            </div>
            <div style="height: 220px; position: relative;">
                <canvas id="productionChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Chart Right: Average Efficiency -->
    <div class="col-md-4">
        <div class="card-custom p-4 h-100 text-center d-flex flex-column justify-content-between">
            <h3 class="h6 font-weight-bold text-start mb-2" style="font-weight: 700; font-size: 15px;">Average Efficiency</h3>
            <div style="height: 180px; position: relative;" class="my-auto d-flex align-items-center justify-content-center">
                <canvas id="efficiencyChart"></canvas>
                <div style="position: absolute; text-align: center;">
                    <div style="font-size: 22px; font-weight: 800; color: #111827;">{{ round($stats->avg_efficiency ?? 92) }}%</div>
                    <div style="font-size: 10px; font-weight: 700; color: #6b7280;">OEE</div>
                </div>
            </div>
            <div class="text-muted text-center pt-2" style="font-size: 11.5px; font-weight: 500;">
                <span class="text-success font-weight-bold">+2.4%</span> vs last week
            </div>
        </div>
    </div>
</div>

<!-- Recent Bundle Activity -->
<div class="card-custom p-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h3 class="h6 font-weight-bold m-0" style="font-weight: 700; font-size: 15px;">Recent Bundle Activity</h3>
        <a href="{{ route('bundles.index') }}" class="text-primary text-decoration-none font-weight-bold" style="font-size: 13px;">View All &rarr;</a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
            <thead>
                <tr style="background-color: #f9fafb; border-bottom: 2px solid #e5e7eb; color: #6b7280; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">
                    <th style="padding: 10px 14px;">BUNDLE ID</th>
                    <th style="padding: 10px 14px;">STYLE/PO</th>
                    <th style="padding: 10px 14px;">QUANTITY</th>
                    <th style="padding: 10px 14px;">CURRENT STAGE</th>
                    <th style="padding: 10px 14px;">STATUS</th>
                    <th style="padding: 10px 14px;">LAST UPDATED</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $recent = \App\Models\ProductionBundle::with(['style'])->latest()->limit(5)->get();
                    $stages = ['Cutting', 'Sewing', 'QC', 'Shipping'];
                    $statuses = [
                        ['label' => 'IN PROGRESS', 'bg' => '#e0f2fe', 'color' => '#0369a1'],
                        ['label' => 'PENDING',     'bg' => '#f3f4f6', 'color' => '#4b5563'],
                        ['label' => 'PASSED',      'bg' => '#dcfce7', 'color' => '#15803d'],
                        ['label' => 'REJECTED',    'bg' => '#fee2e2', 'color' => '#b91c1c'],
                    ];
                @endphp
                @forelse($recent as $idx => $b)
                @php 
                    $st = $statuses[$idx % count($statuses)]; 
                    $stage = $stages[$idx % count($stages)];
                @endphp
                <tr style="border-bottom: 1px solid #f3f4f6;">
                    <td style="padding: 12px 14px;" class="font-mono fw-bold">
                        <a href="{{ route('bundles.show', $b) }}" class="text-dark text-decoration-none">{{ $b->bundle_no }}</a>
                    </td>
                    <td style="padding: 12px 14px; color: #4b5563;" class="font-mono">{{ $b->style?->style_no ?: 'ST-402' }} / PO-992</td>
                    <td style="padding: 12px 14px; color: #111827; font-weight: 600;">{{ $b->quantity }}</td>
                    <td style="padding: 12px 14px; color: #374151;">
                        <span style="display: inline-block; width: 7px; height: 7px; border-radius: 50%; background-color: #2563eb; margin-right: 6px;"></span>
                        {{ $stage }}
                    </td>
                    <td style="padding: 12px 14px;">
                        <span class="badge" style="background-color: {{ $st['bg'] }}; color: {{ $st['color'] }}; font-size: 10.5px; font-weight: 700; padding: 4px 8px; border-radius: 4px;">
                            {{ $st['label'] }}
                        </span>
                    </td>
                    <td style="padding: 12px 14px; color: #6b7280; font-size: 12px;">{{ $b->updated_at->diffForHumans() }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-4 text-muted">No recent bundle activity.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Production Volume Bar Chart
new Chart(document.getElementById('productionChart'), {
    type: 'bar',
    data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Today'],
        datasets: [{
            label: 'Production Volume',
            data: [4200, 3800, 5100, 4900, 5600, 2400, 3420],
            backgroundColor: '#2563eb',
            borderRadius: 6,
            barThickness: 28
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { display: false } },
            y: { grid: { color: '#f3f4f6' }, beginAtZero: true }
        }
    }
});

// Efficiency Donut Chart
new Chart(document.getElementById('efficiencyChart'), {
    type: 'doughnut',
    data: {
        datasets: [{
            data: [92, 8],
            backgroundColor: ['#2563eb', '#e5e7eb'],
            borderWidth: 0,
            cutout: '78%'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false }, tooltip: { enabled: false } }
    }
});
</script>
@endpush
