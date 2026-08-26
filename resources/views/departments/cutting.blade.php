@extends('layouts.app')

@section('title', 'Cutting Management')
@section('header-title', 'Cutting Department')

@section('content')
<!-- KPI Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card-custom p-3">
            <div class="text-uppercase text-muted font-weight-bold" style="font-size: 10.5px; letter-spacing: 0.5px;">FABRIC SPREADING YARDS</div>
            <div class="h3 font-weight-bold my-1" style="font-size: 24px; font-weight: 800;">48,200 YDS</div>
            <div class="text-muted" style="font-size: 11.5px;">Today's Lay Table Activity</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom p-3">
            <div class="text-uppercase text-muted font-weight-bold" style="font-size: 10.5px; letter-spacing: 0.5px;">TOTAL CUT PIECES</div>
            <div class="h3 font-weight-bold my-1 text-primary" style="font-size: 24px; font-weight: 800;">64,800 PCS</div>
            <div class="text-muted" style="font-size: 11.5px;">Across 14 Marker Lays</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom p-3">
            <div class="text-uppercase text-muted font-weight-bold" style="font-size: 10.5px; letter-spacing: 0.5px;">BUNDLES CREATED</div>
            <div class="h3 font-weight-bold my-1" style="font-size: 24px; font-weight: 800;">1,296 BND</div>
            <div class="text-muted" style="font-size: 11.5px;">Ready for Sewing Lines</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom p-3">
            <div class="text-uppercase text-muted font-weight-bold" style="font-size: 10.5px; letter-spacing: 0.5px;">FABRIC UTILIZATION %</div>
            <div class="h3 font-weight-bold my-1 text-success" style="font-size: 24px; font-weight: 800;">91.2%</div>
            <div class="text-muted" style="font-size: 11.5px;">Marker Efficiency</div>
        </div>
    </div>
</div>

<!-- Table Card -->
<div class="card-custom p-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="h5 font-weight-bold m-0" style="font-weight: 700; font-size: 17px;">Cut Orders & Spreading Lays</h2>
        <button class="btn btn-black" data-bs-toggle="modal" data-bs-target="#newCutModal">
            <i class="bi bi-plus-lg me-1"></i> New Cut Lay Plan
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 13px;" id="cuttingTable">
            <thead>
                <tr style="background-color: #f9fafb; border-bottom: 2px solid #e5e7eb; color: #6b7280; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">
                    <th style="padding: 12px 14px;">CUT JOB ORDER</th>
                    <th style="padding: 12px 14px;">MARKER ID</th>
                    <th style="padding: 12px 14px;">STYLE NO</th>
                    <th style="padding: 12px 14px;">FABRIC LOT</th>
                    <th class="text-end" style="padding: 12px 14px;">LAY PLIES</th>
                    <th class="text-end" style="padding: 12px 14px;">TOTAL CUT QTY</th>
                    <th style="padding: 12px 14px;">STATUS</th>
                    <th class="text-center" style="padding: 12px 14px;">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $cuts = [
                        ['job' => 'CJ-2026-101', 'marker' => 'MK-TSH-88', 'style' => 'ST-8821', 'lot' => 'LOT-F992', 'plies' => 120, 'qty' => 7200, 'status' => 'COMPLETED', 'bg' => '#dcfce7', 'color' => '#15803d'],
                        ['job' => 'CJ-2026-102', 'marker' => 'MK-JKT-12', 'style' => 'ST-4021', 'lot' => 'LOT-F994', 'plies' => 80,  'qty' => 4800, 'status' => 'IN CUTTING', 'bg' => '#e0f2fe', 'color' => '#0369a1'],
                        ['job' => 'CJ-2026-103', 'marker' => 'MK-DNM-55', 'style' => 'ST-3012', 'lot' => 'LOT-F998', 'plies' => 150, 'qty' => 9000, 'status' => 'QUALITY CHECK', 'bg' => '#fef3c7', 'color' => '#b45309'],
                        ['job' => 'CJ-2026-104', 'marker' => 'MK-POL-34', 'style' => 'ST-9020', 'lot' => 'LOT-F102', 'plies' => 100, 'qty' => 6000, 'status' => 'PENDING SPREAD', 'bg' => '#f3f4f6', 'color' => '#4b5563'],
                    ];
                @endphp
                @foreach($cuts as $c)
                <tr style="border-bottom: 1px solid #f3f4f6;" id="cut_row_{{ $loop->index }}">
                    <td style="padding: 12px 14px;" class="font-mono fw-bold">{{ $c['job'] }}</td>
                    <td style="padding: 12px 14px; font-weight: 500; color: #111827;" class="font-mono">{{ $c['marker'] }}</td>
                    <td style="padding: 12px 14px; color: #4b5563;" class="font-mono">{{ $c['style'] }}</td>
                    <td style="padding: 12px 14px; color: #4b5563;">{{ $c['lot'] }}</td>
                    <td class="text-end fw-semibold" style="padding: 12px 14px;">{{ $c['plies'] }} plies</td>
                    <td class="text-end fw-bold" style="padding: 12px 14px; color: #111827;">{{ number_format($c['qty']) }} pcs</td>
                    <td style="padding: 12px 14px;">
                        <span class="badge" style="background-color: {{ $c['bg'] }}; color: {{ $c['color'] }}; font-size: 11px; font-weight: 700; padding: 4px 8px; border-radius: 4px;">
                            {{ $c['status'] }}
                        </span>
                    </td>
                    <td class="text-center" style="padding: 12px 14px;">
                        <div class="d-flex justify-content-center gap-1">
                            <button class="btn btn-sm btn-light border p-1" onclick="viewCut('{{ $c['job'] }}', '{{ $c['marker'] }}', '{{ $c['style'] }}', '{{ $c['lot'] }}', '{{ $c['plies'] }}', '{{ $c['qty'] }}', '{{ $c['status'] }}')" title="View Cut Details"><i class="bi bi-eye"></i></button>
                            <button class="btn btn-sm btn-light border p-1 text-primary" onclick="editCut('{{ $c['job'] }}', '{{ $c['plies'] }}')" title="Edit"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-light border p-1 text-danger" onclick="deleteCutRow('cut_row_{{ $loop->index }}', '{{ $c['job'] }}')" title="Delete"><i class="bi bi-trash3"></i></button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: New Cut Order -->
<div class="modal fade" id="newCutModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" style="font-size: 16px;">Create New Cut Order Plan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="newCutForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">CUT JOB ORDER</label>
                        <input type="text" id="cut_job" class="form-control form-control-custom font-mono" value="CJ-2026-105" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">MARKER ID</label>
                        <input type="text" id="cut_marker" class="form-control form-control-custom font-mono" placeholder="e.g. MK-TSH-90" required>
                    </div>
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label font-weight-bold">STYLE NO</label>
                            <input type="text" id="cut_style" class="form-control form-control-custom" placeholder="ST-8821" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label font-weight-bold">FABRIC LOT</label>
                            <input type="text" id="cut_lot" class="form-control form-control-custom" placeholder="LOT-F999" required>
                        </div>
                    </div>
                    <div class="row g-2 mt-2">
                        <div class="col-6">
                            <label class="form-label font-weight-bold">LAY PLIES</label>
                            <input type="number" id="cut_plies" class="form-control form-control-custom" placeholder="100" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label font-weight-bold">TOTAL CUT QTY</label>
                            <input type="number" id="cut_qty" class="form-control form-control-custom" placeholder="6000" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-black">Save Cut Order</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: View Cut Details -->
<div class="modal fade" id="viewCutModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" style="font-size: 16px;"><i class="bi bi-scissors text-primary me-2"></i> Cut Order Specification Sheet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4" id="viewCutContent"></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('newCutForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const job = document.getElementById('cut_job').value;
    const marker = document.getElementById('cut_marker').value;
    const style = document.getElementById('cut_style').value;
    const lot = document.getElementById('cut_lot').value;
    const plies = document.getElementById('cut_plies').value;
    const qty = document.getElementById('cut_qty').value;

    const tbody = document.querySelector('#cuttingTable tbody');
    const tr = document.createElement('tr');
    tr.style.borderBottom = '1px solid #f3f4f6';
    const rowId = 'cut_row_' + Date.now();
    tr.id = rowId;
    tr.innerHTML = `
        <td style="padding: 12px 14px;" class="font-mono fw-bold">${job}</td>
        <td style="padding: 12px 14px; font-weight: 500; color: #111827;" class="font-mono">${marker}</td>
        <td style="padding: 12px 14px; color: #4b5563;" class="font-mono">${style}</td>
        <td style="padding: 12px 14px; color: #4b5563;">${lot}</td>
        <td class="text-end fw-semibold" style="padding: 12px 14px;">${plies} plies</td>
        <td class="text-end fw-bold" style="padding: 12px 14px; color: #111827;">${Number(qty).toLocaleString()} pcs</td>
        <td style="padding: 12px 14px;">
            <span class="badge" style="background-color: #e0f2fe; color: #0369a1; font-size: 11px; font-weight: 700; padding: 4px 8px; border-radius: 4px;">IN CUTTING</span>
        </td>
        <td class="text-center" style="padding: 12px 14px;">
            <div class="d-flex justify-content-center gap-1">
                <button class="btn btn-sm btn-light border p-1" onclick="viewCut('${job}', '${marker}', '${style}', '${lot}', '${plies}', '${qty}', 'IN CUTTING')"><i class="bi bi-eye"></i></button>
                <button class="btn btn-sm btn-light border p-1 text-primary" onclick="editCut('${job}', '${plies}')"><i class="bi bi-pencil"></i></button>
                <button class="btn btn-sm btn-light border p-1 text-danger" onclick="deleteCutRow('${rowId}', '${job}')"><i class="bi bi-trash3"></i></button>
            </div>
        </td>
    `;
    tbody.prepend(tr);
    bootstrap.Modal.getInstance(document.getElementById('newCutModal')).hide();
    showToast(`Cut Order ${job} created successfully!`, 'success');
});

function viewCut(job, marker, style, lot, plies, qty, status) {
    document.getElementById('viewCutContent').innerHTML = `
        <div class="mb-3 border-bottom pb-2">
            <div class="text-muted" style="font-size: 11px; font-weight: 700;">CUT JOB ORDER</div>
            <div class="h4 font-mono fw-bold text-dark mb-0">${job}</div>
        </div>
        <div class="row g-3">
            <div class="col-6"><strong>Marker ID:</strong> <div class="font-mono">${marker}</div></div>
            <div class="col-6"><strong>Status:</strong> <div><span class="badge bg-success">${status}</span></div></div>
            <div class="col-6"><strong>Style No:</strong> <div class="font-mono">${style}</div></div>
            <div class="col-6"><strong>Fabric Lot:</strong> <div>${lot}</div></div>
            <div class="col-6"><strong>Lay Plies:</strong> <div>${plies} layers</div></div>
            <div class="col-6"><strong>Cut Pieces:</strong> <div>${Number(qty).toLocaleString()} pcs</div></div>
        </div>
    `;
    new bootstrap.Modal(document.getElementById('viewCutModal')).show();
}

function editCut(job, plies) {
    const newPlies = prompt(`Edit Lay Plies for Job ${job}:`, plies);
    if (newPlies && !isNaN(newPlies)) {
        showToast(`Job ${job} lay plies updated to ${newPlies} layers`, 'success');
    }
}

function deleteCutRow(rowId, job) {
    if (confirm(`Delete Cut Job Order ${job}?`)) {
        const el = document.getElementById(rowId);
        if (el) el.remove();
        showToast(`Cut Order ${job} deleted successfully`, 'success');
    }
}
</script>
@endpush
