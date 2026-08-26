@extends('layouts.app')

@section('title', 'Production Bundles')
@section('page-title', 'Production Bundles')
@section('breadcrumb', 'Home / Bundles')

@section('content')
<!-- Search & Filter Card -->
<div class="card mb-3">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('bundles.index') }}" id="filterForm">
            <div class="row g-2 align-items-end">
                <!-- Search -->
                <div class="col-12 col-md-3">
                    <label class="form-label mb-1"><i class="bi bi-search me-1"></i>Search</label>
                    <input type="text" name="search" class="form-control form-control-sm"
                        placeholder="Bundle No, Buyer, Style, Operator, Color..."
                        value="{{ $search }}">
                </div>
                <!-- Buyer Filter -->
                <div class="col-6 col-md-2">
                    <label class="form-label mb-1">Buyer</label>
                    <select name="buyer_id" class="form-select form-select-sm">
                        <option value="">All Buyers</option>
                        @foreach($buyers as $b)
                        <option value="{{ $b->id }}" {{ request('buyer_id') == $b->id ? 'selected' : '' }}>
                            {{ $b->buyer_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <!-- Style Filter -->
                <div class="col-6 col-md-2">
                    <label class="form-label mb-1">Style</label>
                    <select name="style_id" class="form-select form-select-sm">
                        <option value="">All Styles</option>
                        @foreach($styles as $s)
                        <option value="{{ $s->id }}" {{ request('style_id') == $s->id ? 'selected' : '' }}>
                            {{ $s->style_no }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <!-- Line Filter -->
                <div class="col-6 col-md-2">
                    <label class="form-label mb-1">Sewing Line</label>
                    <select name="line_id" class="form-select form-select-sm">
                        <option value="">All Lines</option>
                        @foreach($sewingLines as $l)
                        <option value="{{ $l->id }}" {{ request('line_id') == $l->id ? 'selected' : '' }}>
                            {{ $l->line_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <!-- Date Range -->
                <div class="col-6 col-md-1">
                    <label class="form-label mb-1">Date From</label>
                    <input type="date" name="date_from" class="form-control form-control-sm" value="{{ request('date_from') }}">
                </div>
                <div class="col-6 col-md-1">
                    <label class="form-label mb-1">Date To</label>
                    <input type="date" name="date_to" class="form-control form-control-sm" value="{{ request('date_to') }}">
                </div>
                <!-- Actions -->
                <div class="col-12 col-md-1 d-flex gap-1">
                    <button type="submit" class="btn btn-primary btn-sm flex-fill">
                        <i class="bi bi-funnel"></i>
                    </button>
                    <a href="{{ route('bundles.index') }}" class="btn btn-outline-secondary btn-sm flex-fill">
                        <i class="bi bi-x"></i>
                    </a>
                </div>
                <!-- Hidden sort params -->
                <input type="hidden" name="sort" value="{{ $sortCol }}">
                <input type="hidden" name="direction" value="{{ $sortDir }}">
                <input type="hidden" name="per_page" value="{{ $perPage }}">
            </div>
        </form>
    </div>
</div>

<!-- Listing Card -->
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <div>
            <i class="bi bi-stack me-1"></i>
            Bundles
            <span class="badge bg-primary ms-1">{{ $bundles->total() }}</span>
        </div>
        <div class="d-flex align-items-center gap-2">
            <!-- Per page -->
            <div class="d-flex align-items-center gap-1">
                <span class="text-muted" style="font-size:12px;">Show</span>
                @foreach([20,50,100] as $pp)
                <a href="{{ request()->fullUrlWithQuery(['per_page' => $pp, 'page' => 1]) }}"
                   class="btn btn-sm {{ $perPage == $pp ? 'btn-primary' : 'btn-outline-secondary' }}">{{ $pp }}</a>
                @endforeach
            </div>
            <!-- Actions -->
            <a href="{{ route('bundles.create') }}" class="btn btn-sm btn-success">
                <i class="bi bi-plus-lg me-1"></i>New Bundle
            </a>
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="bi bi-download me-1"></i>Export
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('bundles.export', array_merge(request()->all(), ['format'=>'xlsx'])) }}">
                        <i class="bi bi-file-earmark-excel me-1 text-success"></i>Export Excel
                    </a></li>
                    <li><a class="dropdown-item" href="{{ route('bundles.export', array_merge(request()->all(), ['format'=>'csv'])) }}">
                        <i class="bi bi-file-earmark-text me-1 text-info"></i>Export CSV
                    </a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    @php
                        function sortLink($col, $label, $currentSort, $currentDir) {
                            $dir = ($currentSort === $col && $currentDir === 'desc') ? 'asc' : 'desc';
                            $icon = $currentSort === $col
                                ? ($currentDir === 'asc' ? '↑' : '↓')
                                : '';
                            return '<a href="'.request()->fullUrlWithQuery(['sort'=>$col,'direction'=>$dir,'page'=>1]).'" class="sort-link">'.$label.' '.$icon.'</a>';
                        }
                    @endphp
                    <th>{!! sortLink('bundle_no', 'Bundle No', $sortCol, $sortDir) !!}</th>
                    <th>{!! sortLink('buyer', 'Buyer', $sortCol, $sortDir) !!}</th>
                    <th>{!! sortLink('style', 'Style', $sortCol, $sortDir) !!}</th>
                    <th>Color</th>
                    <th>Size</th>
                    <th>Line</th>
                    <th class="text-end">{!! sortLink('quantity', 'Qty', $sortCol, $sortDir) !!}</th>
                    <th class="text-end">Completed</th>
                    <th class="text-end">Rejected</th>
                    <th class="text-end">Balance</th>
                    <th class="text-end">{!! sortLink('efficiency', 'Efficiency%', $sortCol, $sortDir) !!}</th>
                    <th class="text-end">Rejection%</th>
                    <th>{!! sortLink('production_date', 'Date', $sortCol, $sortDir) !!}</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bundles as $bundle)
                @php $eff = $bundle->efficiency_pct; @endphp
                <tr>
                    <td><a href="{{ route('bundles.show', $bundle) }}" class="fw-medium text-primary">{{ $bundle->bundle_no }}</a></td>
                    <td>{{ $bundle->buyer?->buyer_name }}</td>
                    <td>{{ $bundle->style?->style_no }}</td>
                    <td>{{ $bundle->color ?: '—' }}</td>
                    <td>{{ $bundle->size ?: '—' }}</td>
                    <td>{{ $bundle->sewingLine?->line_name }}</td>
                    <td class="text-end">{{ number_format($bundle->quantity) }}</td>
                    <td class="text-end text-success fw-medium">{{ number_format($bundle->completed_qty) }}</td>
                    <td class="text-end text-danger">{{ number_format($bundle->rejected_qty) }}</td>
                    <td class="text-end fw-medium">{{ number_format($bundle->balance_qty) }}</td>
                    <td class="text-end">
                        <span class="badge badge-efficiency {{ $eff >= 80 ? 'bg-success' : ($eff >= 50 ? 'bg-warning text-dark' : 'bg-danger') }}">
                            {{ $eff }}%
                        </span>
                    </td>
                    <td class="text-end">
                        <span class="badge bg-danger-subtle text-danger">{{ $bundle->rejection_pct }}%</span>
                    </td>
                    <td>{{ $bundle->production_date?->format('d M Y') }}</td>
                    <td class="text-center">
                        <div class="d-flex gap-1 justify-content-center">
                            <a href="{{ route('bundles.show', $bundle) }}" class="btn btn-sm btn-outline-info action-btn" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('bundles.edit', $bundle) }}" class="btn btn-sm btn-outline-primary action-btn" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="{{ route('bundles.print', $bundle) }}" target="_blank" class="btn btn-sm btn-outline-secondary action-btn" title="Print">
                                <i class="bi bi-printer"></i>
                            </a>
                            <button class="btn btn-sm btn-outline-danger action-btn delete-btn"
                                data-url="{{ route('bundles.destroy', $bundle) }}"
                                data-bundle="{{ $bundle->bundle_no }}" title="Delete">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="14" class="text-center text-muted py-5">
                        <i class="bi bi-inbox" style="font-size:2rem;display:block;margin-bottom:8px;"></i>
                        No bundles found. <a href="{{ route('bundles.create') }}">Create one?</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($bundles->hasPages())
    <div class="card-footer bg-white d-flex align-items-center justify-content-between py-2">
        <div class="text-muted" style="font-size:12px;">
            Showing {{ $bundles->firstItem() }}–{{ $bundles->lastItem() }} of {{ $bundles->total() }} records
        </div>
        {{ $bundles->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
