@extends('layouts.app')

@section('title', 'Sourcing Management')
@section('header-title', 'Sourcing & Fabric Procurement')

@section('content')
<!-- KPI Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card-custom p-3">
            <div class="text-uppercase text-muted font-weight-bold" style="font-size: 10.5px; letter-spacing: 0.5px;">TOTAL FABRIC PURCHASED</div>
            <div class="h3 font-weight-bold my-1" style="font-size: 24px; font-weight: 800;" id="kpi_sourcing_total">142,500 KGS</div>
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
        <button class="btn btn-black" data-bs-toggle="modal" data-bs-target="#newPOModal">
            <i class="bi bi-plus-lg me-1"></i> New Purchase Order
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 13px;" id="sourcingTable">
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
                <tr style="border-bottom: 1px solid #f3f4f6;" id="po_row_{{ $loop->index }}">
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
                        <div class="d-flex justify-content-center gap-1">
                            <button class="btn btn-sm btn-light border p-1" onclick="viewPO('{{ $p['po'] }}', '{{ $p['mill'] }}', '{{ $p['fabric'] }}', '{{ $p['color'] }}', '{{ $p['qty'] }}', '{{ $p['date'] }}', '{{ $p['status'] }}')" title="View Details"><i class="bi bi-eye"></i></button>
                            <button class="btn btn-sm btn-light border p-1 text-primary" onclick="editPO('{{ $p['po'] }}', '{{ $p['mill'] }}', '{{ $p['qty'] }}')" title="Edit"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-light border p-1 text-danger" onclick="deletePORow('po_row_{{ $loop->index }}', '{{ $p['po'] }}')" title="Delete"><i class="bi bi-trash3"></i></button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: New PO -->
<div class="modal fade" id="newPOModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" style="font-size: 16px;">Create Fabric Purchase Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="newPOForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">PO NUMBER</label>
                        <input type="text" id="po_num" class="form-control form-control-custom font-mono" value="PO-SR-905" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">SUPPLIER MILL</label>
                        <input type="text" id="po_mill" class="form-control form-control-custom" placeholder="e.g. Pacific Textiles" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">FABRIC TYPE & GSM</label>
                        <input type="text" id="po_fabric" class="form-control form-control-custom" placeholder="e.g. 100% Cotton Jersey 180GSM" required>
                    </div>
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label font-weight-bold">COLOR</label>
                            <input type="text" id="po_color" class="form-control form-control-custom" placeholder="e.g. Navy" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label font-weight-bold">QTY (KGS)</label>
                            <input type="number" id="po_qty" class="form-control form-control-custom" placeholder="3000" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-black">Create Purchase Order</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: View PO Details -->
<div class="modal fade" id="viewPOModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" style="font-size: 16px;"><i class="bi bi-folder2-open text-primary me-2"></i> Purchase Order Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4" id="viewPOContent">
                <!-- Loaded dynamically -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('newPOForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const po = document.getElementById('po_num').value;
    const mill = document.getElementById('po_mill').value;
    const fabric = document.getElementById('po_fabric').value;
    const color = document.getElementById('po_color').value;
    const qty = document.getElementById('po_qty').value;
    
    const tbody = document.querySelector('#sourcingTable tbody');
    const tr = document.createElement('tr');
    tr.style.borderBottom = '1px solid #f3f4f6';
    const rowId = 'po_row_' + Date.now();
    tr.id = rowId;
    tr.innerHTML = `
        <td style="padding: 12px 14px;" class="font-mono fw-bold">${po}</td>
        <td style="padding: 12px 14px; font-weight: 500; color: #111827;">${mill}</td>
        <td style="padding: 12px 14px; color: #4b5563;">${fabric}</td>
        <td style="padding: 12px 14px; color: #4b5563;">${color}</td>
        <td class="text-end fw-bold" style="padding: 12px 14px; color: #111827;">${Number(qty).toLocaleString()} KGS</td>
        <td style="padding: 12px 14px; color: #4b5563;">${new Date().toISOString().split('T')[0]}</td>
        <td style="padding: 12px 14px;">
            <span class="badge" style="background-color: #e0f2fe; color: #0369a1; font-size: 11px; font-weight: 700; padding: 4px 8px; border-radius: 4px;">IN TRANSIT</span>
        </td>
        <td class="text-center" style="padding: 12px 14px;">
            <div class="d-flex justify-content-center gap-1">
                <button class="btn btn-sm btn-light border p-1" onclick="viewPO('${po}', '${mill}', '${fabric}', '${color}', '${qty}', 'Today', 'IN TRANSIT')"><i class="bi bi-eye"></i></button>
                <button class="btn btn-sm btn-light border p-1 text-primary" onclick="editPO('${po}', '${mill}', '${qty}')"><i class="bi bi-pencil"></i></button>
                <button class="btn btn-sm btn-light border p-1 text-danger" onclick="deletePORow('${rowId}', '${po}')"><i class="bi bi-trash3"></i></button>
            </div>
        </td>
    `;
    tbody.prepend(tr);
    bootstrap.Modal.getInstance(document.getElementById('newPOModal')).hide();
    showToast(`Purchase order ${po} created successfully!`, 'success');
});

function viewPO(po, mill, fabric, color, qty, date, status) {
    document.getElementById('viewPOContent').innerHTML = `
        <div class="mb-3 border-bottom pb-2">
            <div class="text-muted" style="font-size: 11px; font-weight: 700;">PURCHASE ORDER NUMBER</div>
            <div class="h4 font-mono fw-bold text-dark mb-0">${po}</div>
        </div>
        <div class="row g-3">
            <div class="col-6"><strong>Supplier Mill:</strong> <div>${mill}</div></div>
            <div class="col-6"><strong>Status:</strong> <div><span class="badge bg-primary">${status}</span></div></div>
            <div class="col-6"><strong>Fabric Spec:</strong> <div>${fabric}</div></div>
            <div class="col-6"><strong>Color:</strong> <div>${color}</div></div>
            <div class="col-6"><strong>Order Qty:</strong> <div>${Number(qty).toLocaleString()} KGS</div></div>
            <div class="col-6"><strong>Delivery Date:</strong> <div>${date}</div></div>
        </div>
    `;
    new bootstrap.Modal(document.getElementById('viewPOModal')).show();
}

function editPO(po, mill, qty) {
    const newQty = prompt(`Edit Quantity for PO ${po} (${mill}):`, qty);
    if (newQty && !isNaN(newQty)) {
        showToast(`PO ${po} quantity updated to ${Number(newQty).toLocaleString()} KGS`, 'success');
    }
}

function deletePORow(rowId, po) {
    if (confirm(`Are you sure you want to cancel and delete PO ${po}?`)) {
        const el = document.getElementById(rowId);
        if (el) el.remove();
        showToast(`PO ${po} deleted successfully`, 'success');
    }
}
</script>
@endpush
