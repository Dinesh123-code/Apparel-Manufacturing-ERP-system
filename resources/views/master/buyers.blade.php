@extends('layouts.app')

@section('title', 'Buyer Master')
@section('header-title', 'Master Data Management')

@section('content')
<div class="card-custom p-4">
    <!-- Header Row -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="h5 font-weight-bold m-0" style="font-weight: 700; font-size: 18px;">Buyer Master</h2>
        <button class="btn btn-black" data-bs-toggle="modal" data-bs-target="#newBuyerModal">
            <i class="bi bi-plus-lg me-1"></i> New Buyer
        </button>
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
            <thead>
                <tr style="background-color: #f9fafb; border-bottom: 2px solid #e5e7eb; color: #6b7280; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">
                    <th style="padding: 12px 16px;">BUYER ID</th>
                    <th style="padding: 12px 16px;">BUYER NAME</th>
                    <th style="padding: 12px 16px;">CONTACT PERSON</th>
                    <th style="padding: 12px 16px;">EMAIL</th>
                    <th style="padding: 12px 16px;">STATUS</th>
                    <th class="text-end" style="padding: 12px 16px;">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($buyers as $buyer)
                <tr style="border-bottom: 1px solid #f3f4f6;">
                    <td style="padding: 12px 16px;" class="font-mono fw-bold">B-{{ str_pad($buyer->id, 3, '0', STR_PAD_LEFT) }}</td>
                    <td style="padding: 12px 16px; color: #111827; font-weight: 500;">{{ $buyer->buyer_name }}</td>
                    <td style="padding: 12px 16px; color: #4b5563;">John Doe</td>
                    <td style="padding: 12px 16px; color: #4b5563;">{{ strtolower(str_replace([' ', '&'], '', $buyer->buyer_name)) }}@global.com</td>
                    <td style="padding: 12px 16px;">
                        <span class="badge-status-active">Active</span>
                    </td>
                    <td class="text-end" style="padding: 12px 16px;">
                        <button class="btn btn-sm btn-light border text-danger" onclick="deleteBuyer({{ $buyer->id }})">
                            <i class="bi bi-trash3"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">No buyers found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="pt-3 mt-2 border-top text-muted" style="font-size: 12.5px;">
        Showing {{ $buyers->firstItem() ?? 0 }} to {{ $buyers->lastItem() ?? 0 }} of {{ $buyers->total() }} entries
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="newBuyerModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" style="font-size: 16px;">Create New Buyer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="newBuyerForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Buyer Name <span class="text-danger">*</span></label>
                        <input type="text" name="buyer_name" class="form-control form-control-custom" placeholder="e.g. Global Retail" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-black">Save Buyer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('newBuyerForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const data = new FormData(this);
    fetch('{{ route("master.buyers.store") }}', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
        body: data
    }).then(r => r.json()).then(res => {
        if(res.success) { location.reload(); }
        else { alert(res.message || 'Error creating buyer'); }
    });
});

function deleteBuyer(id) {
    if(!confirm('Are you sure you want to delete this buyer?')) return;
    fetch('/master/buyers/' + id, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
    }).then(r => r.json()).then(res => {
        if(res.success) { location.reload(); }
    });
}
</script>
@endpush
