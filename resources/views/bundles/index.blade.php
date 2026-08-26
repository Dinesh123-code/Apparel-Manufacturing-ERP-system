@extends('layouts.app')

@section('title', 'Bundle Listing')
@section('header-title', 'Bundle Management')

@section('content')
<div class="card-custom p-4">
    <!-- Header Row -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="h5 font-weight-bold m-0" style="font-weight: 700; font-size: 17px;">Bundle Listing</h2>
        <button class="btn btn-outline-custom" type="button" data-bs-toggle="collapse" data-bs-target="#advancedFilters">
            <i class="bi bi-sliders me-1"></i> Advanced Filters
        </button>
    </div>

    <!-- Filters Section -->
    <form method="GET" action="{{ route('bundles.index') }}" id="filterForm">
        <div class="row g-3 mb-4 collapse show" id="advancedFilters">
            <div class="col-md-3">
                <label class="form-label text-uppercase text-muted font-weight-bold" style="font-size: 10.5px; letter-spacing: 0.5px;">BUYER</label>
                <select name="buyer_id" class="form-select form-select-custom" onchange="this.form.submit()">
                    <option value="">All Buyers</option>
                    @foreach($buyers as $b)
                        <option value="{{ $b->id }}" {{ request('buyer_id') == $b->id ? 'selected' : '' }}>{{ $b->buyer_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label text-uppercase text-muted font-weight-bold" style="font-size: 10.5px; letter-spacing: 0.5px;">STYLE</label>
                <input type="text" name="search" class="form-control form-control-custom" placeholder="Enter Style No." value="{{ request('search') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label text-uppercase text-muted font-weight-bold" style="font-size: 10.5px; letter-spacing: 0.5px;">SEWING LINE</label>
                <select name="line_id" class="form-select form-select-custom" onchange="this.form.submit()">
                    <option value="">All Lines</option>
                    @foreach($sewingLines as $l)
                        <option value="{{ $l->id }}" {{ request('line_id') == $l->id ? 'selected' : '' }}>{{ $l->line_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label text-uppercase text-muted font-weight-bold" style="font-size: 10.5px; letter-spacing: 0.5px;">DATE RANGE</label>
                <div class="d-flex align-items-center gap-1">
                    <input type="date" name="date_from" class="form-control form-control-custom" value="{{ request('date_from') }}">
                    <span class="text-muted">–</span>
                    <input type="date" name="date_to" class="form-control form-control-custom" value="{{ request('date_to') }}">
                </div>
            </div>
        </div>
    </form>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
            <thead>
                <tr style="background-color: #f9fafb; border-bottom: 2px solid #e5e7eb; color: #6b7280; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">
                    <th style="padding: 12px 14px;">BUNDLE NO</th>
                    <th style="padding: 12px 14px;">BUYER</th>
                    <th style="padding: 12px 14px;">STYLE</th>
                    <th style="padding: 12px 14px;">COLOR / SIZE</th>
                    <th style="padding: 12px 14px;">LINE</th>
                    <th class="text-end" style="padding: 12px 14px;">QTY</th>
                    <th class="text-end" style="padding: 12px 14px;">DONE</th>
                    <th class="text-end" style="padding: 12px 14px;">REJ</th>
                    <th class="text-end" style="padding: 12px 14px;">BAL</th>
                    <th class="text-center" style="padding: 12px 14px;">EFF %</th>
                    <th class="text-end" style="padding: 12px 14px;">REJ %</th>
                    <th class="text-center" style="padding: 12px 14px;">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bundles as $bundle)
                @php 
                    $eff = $bundle->efficiency_pct; 
                    $rej = $bundle->rejection_pct;
                @endphp
                <tr style="border-bottom: 1px solid #f3f4f6;">
                    <td style="padding: 12px 14px;">
                        <a href="{{ route('bundles.show', $bundle) }}" class="font-mono text-dark text-decoration-none fw-bold" style="font-size: 13px;">
                            {{ $bundle->bundle_no }}
                        </a>
                    </td>
                    <td style="padding: 12px 14px; color: #374151;">{{ $bundle->buyer?->buyer_name }}</td>
                    <td style="padding: 12px 14px; color: #4b5563;" class="font-mono">{{ $bundle->style?->style_no }}</td>
                    <td style="padding: 12px 14px; color: #4b5563;">
                        {{ $bundle->color ?: 'Navy' }} / {{ $bundle->size ?: 'M' }}
                    </td>
                    <td style="padding: 12px 14px; color: #4b5563;">{{ $bundle->sewingLine?->line_name }}</td>
                    <td class="text-end fw-semibold" style="padding: 12px 14px; color: #111827;">{{ number_format($bundle->quantity) }}</td>
                    <td class="text-end fw-semibold" style="padding: 12px 14px; color: #111827;">{{ number_format($bundle->completed_qty) }}</td>
                    <td class="text-end fw-semibold text-danger" style="padding: 12px 14px;">{{ number_format($bundle->rejected_qty) }}</td>
                    <td class="text-end fw-semibold" style="padding: 12px 14px; color: #111827;">{{ number_format($bundle->balance_qty) }}</td>
                    <td class="text-center" style="padding: 12px 14px;">
                        <span class="{{ $eff >= 80 ? 'badge-eff-high' : ($eff >= 50 ? 'badge-eff-mid' : 'badge-eff-low') }}">
                            {{ $eff }}%
                        </span>
                    </td>
                    <td class="text-end fw-semibold text-danger" style="padding: 12px 14px;">{{ $rej }}%</td>
                    <td class="text-center" style="padding: 12px 14px;">
                        <div class="d-flex justify-content-center gap-1">
                            <a href="{{ route('bundles.show', $bundle) }}" class="btn btn-sm btn-light border p-1" title="View"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('bundles.edit', $bundle) }}" class="btn btn-sm btn-light border p-1" title="Edit"><i class="bi bi-pencil"></i></a>
                            <a href="{{ route('bundles.print', $bundle) }}" target="_blank" class="btn btn-sm btn-light border p-1" title="Print"><i class="bi bi-printer"></i></a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="12" class="text-center py-5 text-muted">
                        No bundles found matching your filter criteria.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Footer Pagination -->
    <div class="d-flex align-items-center justify-content-between pt-3 mt-2 border-top text-muted" style="font-size: 12.5px;">
        <div class="d-flex align-items-center gap-2">
            <span>Rows per page:</span>
            <select class="form-select form-select-sm" style="width: auto; font-size: 12px;" onchange="location = this.value;">
                @foreach([20, 50, 100] as $pp)
                    <option value="{{ request()->fullUrlWithQuery(['per_page' => $pp, 'page' => 1]) }}" {{ $perPage == $pp ? 'selected' : '' }}>
                        {{ $pp }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="d-flex align-items-center gap-3">
            <span>{{ $bundles->firstItem() ?? 0 }}-{{ $bundles->lastItem() ?? 0 }} of {{ number_format($bundles->total()) }}</span>
            <div class="btn-group">
                @if($bundles->onFirstPage())
                    <button class="btn btn-sm btn-outline-secondary" disabled>&lt;</button>
                @else
                    <a href="{{ $bundles->previousPageUrl() }}" class="btn btn-sm btn-outline-secondary">&lt;</a>
                @endif

                @if($bundles->hasMorePages())
                    <a href="{{ $bundles->nextPageUrl() }}" class="btn btn-sm btn-outline-secondary">&gt;</a>
                @else
                    <button class="btn btn-sm btn-outline-secondary" disabled>&gt;</button>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
