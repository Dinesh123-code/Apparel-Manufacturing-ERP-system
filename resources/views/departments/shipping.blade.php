@extends('layouts.app')

@section('title', 'Shipping Management')
@section('header-title', 'Shipping & Packing Dispatch')

@section('content')
<!-- KPI Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card-custom p-3">
            <div class="text-uppercase text-muted font-weight-bold" style="font-size: 10.5px; letter-spacing: 0.5px;">TOTAL SHIPPED BUNDLES</div>
            <div class="h3 font-weight-bold my-1" style="font-size: 24px; font-weight: 800;">38,400 BND</div>
            <div class="text-muted" style="font-size: 11.5px;">1,280 Export Cartons</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom p-3">
            <div class="text-uppercase text-muted font-weight-bold" style="font-size: 10.5px; letter-spacing: 0.5px;">ON-TIME SHIPMENT RATE</div>
            <div class="h3 font-weight-bold my-1 text-success" style="font-size: 24px; font-weight: 800;">99.1%</div>
            <div class="text-muted" style="font-size: 11.5px;">On Schedule Deliveries</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom p-3">
            <div class="text-uppercase text-muted font-weight-bold" style="font-size: 10.5px; letter-spacing: 0.5px;">DISPATCH IN PACKING</div>
            <div class="h3 font-weight-bold my-1 text-primary" style="font-size: 24px; font-weight: 800;">4,200 PCS</div>
            <div class="text-muted" style="font-size: 11.5px;">Polybagged & Barcoded</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom p-3">
            <div class="text-uppercase text-muted font-weight-bold" style="font-size: 10.5px; letter-spacing: 0.5px;">ACTIVE FREIGHT CONTAINERS</div>
            <div class="h3 font-weight-bold my-1" style="font-size: 24px; font-weight: 800;">6 CONTAINERS</div>
            <div class="text-muted" style="font-size: 11.5px;">Port Chittagong Loading</div>
        </div>
    </div>
</div>

<!-- Table Card -->
<div class="card-custom p-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="h5 font-weight-bold m-0" style="font-weight: 700; font-size: 17px;">Commercial Export Shipping Logs</h2>
        <button class="btn btn-black" data-bs-toggle="modal" data-bs-target="#newShipModal">
            <i class="bi bi-plus-lg me-1"></i> New Shipping Order
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 13px;" id="shippingTable">
            <thead>
                <tr style="background-color: #f9fafb; border-bottom: 2px solid #e5e7eb; color: #6b7280; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">
                    <th style="padding: 12px 14px;">SHIPMENT ID</th>
                    <th style="padding: 12px 14px;">BUYER NAME</th>
                    <th style="padding: 12px 14px;">STYLE / PO</th>
                    <th class="text-end" style="padding: 12px 14px;">CARTON COUNT</th>
                    <th class="text-end" style="padding: 12px 14px;">GARMENT QTY</th>
                    <th style="padding: 12px 14px;">DESTINATION PORT</th>
                    <th style="padding: 12px 14px;">STATUS</th>
                    <th class="text-center" style="padding: 12px 14px;">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $ships = [
                        ['id' => 'SHP-2026-401', 'buyer' => 'Global Retail', 'style' => 'ST-8821 / PO-992', 'cartons' => 240, 'qty' => 12000, 'port' => 'Hamburg, Germany', 'status' => 'PORT DISPATCHED', 'bg' => '#dcfce7', 'color' => '#15803d'],
                        ['id' => 'SHP-2026-402', 'buyer' => 'Urban Out', 'style' => 'UO-22X / PO-881', 'cartons' => 180, 'qty' => 9000, 'port' => 'Felixstowe, UK', 'status' => 'IN PACKING', 'bg' => '#e0f2fe', 'color' => '#0369a1'],
                        ['id' => 'SHP-2026-403', 'buyer' => 'Metro Wear', 'style' => 'MW-501 / PO-774', 'cartons' => 320, 'qty' => 16000, 'port' => 'New York, USA', 'status' => 'PORT DISPATCHED', 'bg' => '#dcfce7', 'color' => '#15803d'],
                        ['id' => 'SHP-2026-404', 'buyer' => 'H&M Logistics', 'style' => 'HM-102 / PO-661', 'cartons' => 150, 'qty' => 7500, 'port' => 'Rotterdam, Netherlands', 'status' => 'CUSTOMS PENDING', 'bg' => '#fef3c7', 'color' => '#b45309'],
                    ];
                @endphp
                @foreach($ships as $s)
                <tr style="border-bottom: 1px solid #f3f4f6;" id="ship_row_{{ $loop->index }}">
                    <td style="padding: 12px 14px;" class="font-mono fw-bold">{{ $s['id'] }}</td>
                    <td style="padding: 12px 14px; font-weight: 600; color: #111827;">{{ $s['buyer'] }}</td>
                    <td style="padding: 12px 14px; color: #4b5563;" class="font-mono">{{ $s['style'] }}</td>
                    <td class="text-end fw-semibold" style="padding: 12px 14px;">{{ number_format($s['cartons']) }} ctns</td>
                    <td class="text-end fw-bold" style="padding: 12px 14px; color: #111827;">{{ number_format($s['qty']) }} pcs</td>
                    <td style="padding: 12px 14px; color: #4b5563;"><i class="bi bi-geo-alt me-1 text-danger"></i> {{ $s['port'] }}</td>
                    <td style="padding: 12px 14px;">
                        <span class="badge" style="background-color: {{ $s['bg'] }}; color: {{ $s['color'] }}; font-size: 11px; font-weight: 700; padding: 4px 8px; border-radius: 4px;">
                            {{ $s['status'] }}
                        </span>
                    </td>
                    <td class="text-center" style="padding: 12px 14px;">
                        <div class="d-flex justify-content-center gap-1">
                            <button class="btn btn-sm btn-light border p-1" onclick="viewShipment('{{ $s['id'] }}', '{{ $s['buyer'] }}', '{{ $s['style'] }}', '{{ $s['cartons'] }}', '{{ $s['qty'] }}', '{{ $s['port'] }}', '{{ $s['status'] }}')" title="View Manifest"><i class="bi bi-eye"></i></button>
                            <button class="btn btn-sm btn-light border p-1 text-primary" onclick="editShipment('{{ $s['id'] }}', '{{ $s['cartons'] }}')" title="Edit"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-light border p-1 text-danger" onclick="deleteShipRow('ship_row_{{ $loop->index }}', '{{ $s['id'] }}')" title="Delete"><i class="bi bi-trash3"></i></button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: New Shipping Order -->
<div class="modal fade" id="newShipModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" style="font-size: 16px;">Create New Shipping Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="newShipForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">SHIPMENT ID</label>
                        <input type="text" id="ship_id" class="form-control form-control-custom font-mono" value="SHP-2026-405" required>
                    </div>
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label font-weight-bold">BUYER NAME</label>
                            <input type="text" id="ship_buyer" class="form-control form-control-custom" placeholder="Global Retail" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label font-weight-bold">STYLE / PO</label>
                            <input type="text" id="ship_style" class="form-control form-control-custom font-mono" placeholder="ST-8821 / PO-995" required>
                        </div>
                    </div>
                    <div class="row g-2 mt-2">
                        <div class="col-6">
                            <label class="form-label font-weight-bold">CARTON COUNT</label>
                            <input type="number" id="ship_cartons" class="form-control form-control-custom" placeholder="200" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label font-weight-bold">GARMENT QTY</label>
                            <input type="number" id="ship_qty" class="form-control form-control-custom" placeholder="10000" required>
                        </div>
                    </div>
                    <div class="mb-3 mt-2">
                        <label class="form-label font-weight-bold">DESTINATION PORT</label>
                        <input type="text" id="ship_port" class="form-control form-control-custom" placeholder="Hamburg, Germany" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-black">Dispatch Shipping Order</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: View Shipping Details -->
<div class="modal fade" id="viewShipModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" style="font-size: 16px;"><i class="bi bi-truck text-primary me-2"></i> Shipping Manifest Specification Sheet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4" id="viewShipContent"></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('newShipForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const id = document.getElementById('ship_id').value;
    const buyer = document.getElementById('ship_buyer').value;
    const style = document.getElementById('ship_style').value;
    const cartons = document.getElementById('ship_cartons').value;
    const qty = document.getElementById('ship_qty').value;
    const port = document.getElementById('ship_port').value;

    const tbody = document.querySelector('#shippingTable tbody');
    const tr = document.createElement('tr');
    tr.style.borderBottom = '1px solid #f3f4f6';
    const rowId = 'ship_row_' + Date.now();
    tr.id = rowId;
    tr.innerHTML = `
        <td style="padding: 12px 14px;" class="font-mono fw-bold">${id}</td>
        <td style="padding: 12px 14px; font-weight: 600; color: #111827;">${buyer}</td>
        <td style="padding: 12px 14px; color: #4b5563;" class="font-mono">${style}</td>
        <td class="text-end fw-semibold" style="padding: 12px 14px;">${Number(cartons).toLocaleString()} ctns</td>
        <td class="text-end fw-bold" style="padding: 12px 14px; color: #111827;">${Number(qty).toLocaleString()} pcs</td>
        <td style="padding: 12px 14px; color: #4b5563;"><i class="bi bi-geo-alt me-1 text-danger"></i> ${port}</td>
        <td style="padding: 12px 14px;">
            <span class="badge" style="background-color: #e0f2fe; color: #0369a1; font-size: 11px; font-weight: 700; padding: 4px 8px; border-radius: 4px;">IN PACKING</span>
        </td>
        <td class="text-center" style="padding: 12px 14px;">
            <div class="d-flex justify-content-center gap-1">
                <button class="btn btn-sm btn-light border p-1" onclick="viewShipment('${id}', '${buyer}', '${style}', '${cartons}', '${qty}', '${port}', 'IN PACKING')"><i class="bi bi-eye"></i></button>
                <button class="btn btn-sm btn-light border p-1 text-primary" onclick="editShipment('${id}', '${cartons}')"><i class="bi bi-pencil"></i></button>
                <button class="btn btn-sm btn-light border p-1 text-danger" onclick="deleteShipRow('${rowId}', '${id}')"><i class="bi bi-trash3"></i></button>
            </div>
        </td>
    `;
    tbody.prepend(tr);
    bootstrap.Modal.getInstance(document.getElementById('newShipModal')).hide();
    showToast(`Shipping Order ${id} created successfully!`, 'success');
});

function viewShipment(id, buyer, style, cartons, qty, port, status) {
    document.getElementById('viewShipContent').innerHTML = `
        <div class="mb-3 border-bottom pb-2">
            <div class="text-muted" style="font-size: 11px; font-weight: 700;">SHIPMENT ORDER ID</div>
            <div class="h4 font-mono fw-bold text-dark mb-0">${id}</div>
        </div>
        <div class="row g-3">
            <div class="col-6"><strong>Buyer Name:</strong> <div>${buyer}</div></div>
            <div class="col-6"><strong>Dispatch Status:</strong> <div><span class="badge bg-success">${status}</span></div></div>
            <div class="col-6"><strong>Style / PO:</strong> <div class="font-mono">${style}</div></div>
            <div class="col-6"><strong>Carton Count:</strong> <div>${Number(cartons).toLocaleString()} ctns</div></div>
            <div class="col-6"><strong>Total Garments:</strong> <div>${Number(qty).toLocaleString()} pcs</div></div>
            <div class="col-6"><strong>Destination Port:</strong> <div>${port}</div></div>
        </div>
    `;
    new bootstrap.Modal(document.getElementById('viewShipModal')).show();
}

function editShipment(id, cartons) {
    const newCartons = prompt(`Edit Carton Count for Shipment ${id}:`, cartons);
    if (newCartons !== null && !isNaN(newCartons)) {
        showToast(`Shipment ${id} carton count updated to ${newCartons} cartons`, 'success');
    }
}

function deleteShipRow(rowId, id) {
    if (confirm(`Cancel and delete Shipping Order ${id}?`)) {
        const el = document.getElementById(rowId);
        if (el) el.remove();
        showToast(`Shipping Order ${id} deleted successfully`, 'success');
    }
}
</script>
@endpush
