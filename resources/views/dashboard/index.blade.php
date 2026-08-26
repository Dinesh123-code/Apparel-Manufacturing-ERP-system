@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('breadcrumb', 'Home / Dashboard')

@section('content')
<!-- Stat Cards Row -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card">
            <div class="stat-icon" style="background:#eff6ff; color:#2563eb;"><i class="bi bi-stack"></i></div>
            <div class="stat-value">{{ number_format($stats->total_bundles) }}</div>
            <div class="stat-label">Total Bundles</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card">
            <div class="stat-icon" style="background:#f0fdf4; color:#16a34a;"><i class="bi bi-boxes"></i></div>
            <div class="stat-value">{{ number_format($stats->total_quantity) }}</div>
            <div class="stat-label">Total Quantity</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card">
            <div class="stat-icon" style="background:#f0fdf4; color:#16a34a;"><i class="bi bi-check2-circle"></i></div>
            <div class="stat-value">{{ number_format($stats->total_completed) }}</div>
            <div class="stat-label">Total Completed</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fef2f2; color:#dc2626;"><i class="bi bi-x-circle"></i></div>
            <div class="stat-value">{{ number_format($stats->total_rejected) }}</div>
            <div class="stat-label">Total Rejected</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fffbeb; color:#d97706;"><i class="bi bi-lightning-charge"></i></div>
            <div class="stat-value">{{ round($stats->avg_efficiency, 1) }}%</div>
            <div class="stat-label">Avg Efficiency</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card">
            <div class="stat-icon" style="background:#f0f9ff; color:#0891b2;"><i class="bi bi-calendar-day"></i></div>
            <div class="stat-value">{{ number_format($stats->today_production) }}</div>
            <div class="stat-label">Today's Production</div>
            <div class="stat-change text-danger">
                <i class="bi bi-x-circle-fill"></i> {{ number_format($stats->today_rejection) }} rejected
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row g-3">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-bar-chart-line me-1"></i>Last 7 Days Production Trend</span>
            </div>
            <div class="card-body p-3">
                <canvas id="trendChart" height="100"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-trophy me-1"></i>Top 5 Buyers by Efficiency
            </div>
            <div class="card-body p-3">
                <canvas id="buyerChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Bundles -->
<div class="row g-3 mt-1">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-clock-history me-1"></i>Recent Bundles</span>
                <a href="{{ route('bundles.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Bundle No</th><th>Buyer</th><th>Style</th>
                                <th>Qty</th><th>Completed</th><th>Efficiency</th><th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $recent = \App\Models\ProductionBundle::with(['buyer','style'])
                                    ->latest()->limit(8)->get();
                            @endphp
                            @forelse($recent as $b)
                            <tr>
                                <td><a href="{{ route('bundles.show', $b) }}" class="fw-medium text-primary">{{ $b->bundle_no }}</a></td>
                                <td>{{ $b->buyer?->buyer_name }}</td>
                                <td>{{ $b->style?->style_no }}</td>
                                <td>{{ number_format($b->quantity) }}</td>
                                <td>{{ number_format($b->completed_qty) }}</td>
                                <td>
                                    @php $eff = $b->efficiency_pct; @endphp
                                    <span class="badge {{ $eff >= 80 ? 'bg-success' : ($eff >= 50 ? 'bg-warning' : 'bg-danger') }}">
                                        {{ $eff }}%
                                    </span>
                                </td>
                                <td>{{ $b->production_date?->format('d M Y') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="text-center text-muted py-4">No bundles yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const trendLabels = @json($trend->pluck('production_date'));
const trendCompleted = @json($trend->pluck('completed'));
const trendRejected = @json($trend->pluck('rejected'));

new Chart(document.getElementById('trendChart'), {
    type: 'bar',
    data: {
        labels: trendLabels,
        datasets: [
            { label: 'Completed', data: trendCompleted, backgroundColor: '#16a34a', borderRadius: 4 },
            { label: 'Rejected',  data: trendRejected,  backgroundColor: '#dc2626', borderRadius: 4 },
        ]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'top' } },
        scales: { x: { stacked: false }, y: { beginAtZero: true } }
    }
});

const buyerLabels = @json($topBuyers->map(fn($b) => $b->buyer?->buyer_name ?? 'N/A'));
const buyerEffs   = @json($topBuyers->pluck('efficiency')->map(fn($v) => round($v, 1)));

new Chart(document.getElementById('buyerChart'), {
    type: 'doughnut',
    data: {
        labels: buyerLabels,
        datasets: [{
            data: buyerEffs,
            backgroundColor: ['#2563eb','#16a34a','#d97706','#0891b2','#7c3aed'],
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } } }
    }
});
</script>
@endpush
