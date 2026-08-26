@extends('layouts.app')

@section('title', 'Style Master')
@section('header-title', 'Master Data Management')

@section('content')
<div class="card-custom p-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="h5 font-weight-bold m-0" style="font-weight: 700; font-size: 18px;">Style Master</h2>
        <button class="btn btn-black" data-bs-toggle="modal" data-bs-target="#newStyleModal">
            <i class="bi bi-plus-lg me-1"></i> New Style
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
            <thead>
                <tr style="background-color: #f9fafb; border-bottom: 2px solid #e5e7eb; color: #6b7280; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">
                    <th style="padding: 12px 16px;">STYLE ID</th>
                    <th style="padding: 12px 16px;">STYLE NO</th>
                    <th style="padding: 12px 16px;">BUYER</th>
                    <th style="padding: 12px 16px;">STATUS</th>
                    <th class="text-end" style="padding: 12px 16px;">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($styles as $style)
                <tr style="border-bottom: 1px solid #f3f4f6;">
                    <td style="padding: 12px 16px;" class="font-mono fw-bold">ST-{{ str_pad($style->id, 3, '0', STR_PAD_LEFT) }}</td>
                    <td style="padding: 12px 16px; color: #111827; font-weight: 600;" class="font-mono">{{ $style->style_no }}</td>
                    <td style="padding: 12px 16px; color: #4b5563;">{{ $style->buyer?->buyer_name }}</td>
                    <td style="padding: 12px 16px;"><span class="badge-status-active">Active</span></td>
                    <td class="text-end" style="padding: 12px 16px;">
                        <button class="btn btn-sm btn-light border text-danger" onclick="deleteStyle({{ $style->id }})"><i class="bi bi-trash3"></i></button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-5 text-muted">No styles found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pt-3 mt-2 border-top text-muted" style="font-size: 12.5px;">
        Showing {{ $styles->firstItem() ?? 0 }} to {{ $styles->lastItem() ?? 0 }} of {{ $styles->total() }} entries
    </div>
</div>

<div class="modal fade" id="newStyleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" style="font-size: 16px;">Create New Style</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="newStyleForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Buyer <span class="text-danger">*</span></label>
                        <select name="buyer_id" class="form-select form-select-custom" required>
                            <option value="">Select Buyer</option>
                            @foreach($buyers as $b)
                                <option value="{{ $b->id }}">{{ $b->buyer_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Style No <span class="text-danger">*</span></label>
                        <input type="text" name="style_no" class="form-control form-control-custom" placeholder="e.g. ST-8821" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-black">Save Style</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('newStyleForm').addEventListener('submit', function(e) {
    e.preventDefault();
    fetch('{{ route("master.styles.store") }}', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
        body: new FormData(this)
    }).then(r => r.json()).then(res => { if(res.success) location.reload(); });
});
function deleteStyle(id) {
    if(!confirm('Delete style?')) return;
    fetch('/master/styles/' + id, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
    }).then(r => r.json()).then(res => { if(res.success) location.reload(); });
}
</script>
@endpush
