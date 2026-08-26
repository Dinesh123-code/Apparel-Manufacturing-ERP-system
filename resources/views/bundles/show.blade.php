@extends('layouts.app')

@section('title', 'Bundle — ' . $bundle->bundle_no)
@section('page-title', 'Bundle Details')
@section('breadcrumb', 'Home / Bundles / ' . $bundle->bundle_no)

@section('content')
<div class="row g-3">
    <!-- Main Info -->
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div><i class="bi bi-file-text me-1"></i>Bundle: <strong>{{ $bundle->bundle_no }}</strong></div>
                <div class="d-flex gap-2">
                    <a href="{{ route('bundles.edit', $bundle) }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-pencil me-1"></i>Edit
                    </a>
                    <a href="{{ route('bundles.print', $bundle) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-printer me-1"></i>Print
                    </a>
                    <button class="btn btn-sm btn-outline-danger delete-btn"
                        data-url="{{ route('bundles.destroy', $bundle) }}"
                        data-bundle="{{ $bundle->bundle_no }}">
                        <i class="bi bi-trash3 me-1"></i>Delete
                    </button>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-6 col-md-3">
                        <div class="text-muted" style="font-size:11px;text-transform:uppercase;font-weight:600;">Buyer</div>
                        <div class="fw-medium mt-1">{{ $bundle->buyer?->buyer_name }}</div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="text-muted" style="font-size:11px;text-transform:uppercase;font-weight:600;">Style</div>
                        <div class="fw-medium mt-1">{{ $bundle->style?->style_no }}</div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="text-muted" style="font-size:11px;text-transform:uppercase;font-weight:600;">Color</div>
                        <div class="fw-medium mt-1">{{ $bundle->color ?: '—' }}</div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="text-muted" style="font-size:11px;text-transform:uppercase;font-weight:600;">Size</div>
                        <div class="fw-medium mt-1">{{ $bundle->size ?: '—' }}</div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="text-muted" style="font-size:11px;text-transform:uppercase;font-weight:600;">Sewing Line</div>
                        <div class="fw-medium mt-1">{{ $bundle->sewingLine?->line_name }}</div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="text-muted" style="font-size:11px;text-transform:uppercase;font-weight:600;">Operator</div>
                        <div class="fw-medium mt-1">{{ $bundle->operator_name ?: '—' }}</div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="text-muted" style="font-size:11px;text-transform:uppercase;font-weight:600;">Production Date</div>
                        <div class="fw-medium mt-1">{{ $bundle->production_date?->format('d M Y') }}</div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="text-muted" style="font-size:11px;text-transform:uppercase;font-weight:600;">Remarks</div>
                        <div class="fw-medium mt-1">{{ $bundle->remarks ?: '—' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Qty Summary -->
        <div class="row g-3">
            @foreach([
                ['label'=>'Quantity',    'val'=>$bundle->quantity,       'color'=>'primary',  'icon'=>'bi-boxes'],
                ['label'=>'Completed',   'val'=>$bundle->completed_qty,  'color'=>'success',  'icon'=>'bi-check2-circle'],
                ['label'=>'Rejected',    'val'=>$bundle->rejected_qty,   'color'=>'danger',   'icon'=>'bi-x-circle'],
                ['label'=>'Balance',     'val'=>$bundle->balance_qty,    'color'=>'warning',  'icon'=>'bi-hourglass-split'],
            ] as $card)
            <div class="col-6 col-md-3">
                <div class="stat-card text-center">
                    <div class="stat-icon mx-auto" style="background:var(--bs-{{ $card['color'] }}-bg-subtle, #f8f9fa);color:var(--bs-{{ $card['color'] }});">
                        <i class="bi {{ $card['icon'] }}"></i>
                    </div>
                    <div class="stat-value">{{ number_format($card['val']) }}</div>
                    <div class="stat-label">{{ $card['label'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Right Panel -->
    <div class="col-lg-4">
        <!-- Efficiency Panel -->
        <div class="card mb-3">
            <div class="card-header"><i class="bi bi-lightning-charge me-1"></i>Performance</div>
            <div class="card-body p-3">
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span style="font-size:13px;">Efficiency</span>
                        <strong class="{{ $bundle->efficiency_pct >= 80 ? 'text-success' : ($bundle->efficiency_pct >= 50 ? 'text-warning' : 'text-danger') }}">
                            {{ $bundle->efficiency_pct }}%
                        </strong>
                    </div>
                    <div class="progress" style="height:8px;">
                        <div class="progress-bar {{ $bundle->efficiency_pct >= 80 ? 'bg-success' : ($bundle->efficiency_pct >= 50 ? 'bg-warning' : 'bg-danger') }}"
                            style="width:{{ $bundle->efficiency_pct }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="d-flex justify-content-between mb-1">
                        <span style="font-size:13px;">Rejection Rate</span>
                        <strong class="text-danger">{{ $bundle->rejection_pct }}%</strong>
                    </div>
                    <div class="progress" style="height:8px;">
                        <div class="progress-bar bg-danger" style="width:{{ $bundle->rejection_pct }}%"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Meta -->
        <div class="card">
            <div class="card-header"><i class="bi bi-info-circle me-1"></i>Meta</div>
            <div class="card-body p-3" style="font-size:13px;">
                <div class="mb-2"><strong>Bundle ID:</strong> #{{ $bundle->id }}</div>
                <div class="mb-2"><strong>Created:</strong> {{ $bundle->created_at?->format('d M Y H:i') }}</div>
                <div><strong>Updated:</strong> {{ $bundle->updated_at?->format('d M Y H:i') }}</div>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('bundles.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Back to List
    </a>
</div>
@endsection
