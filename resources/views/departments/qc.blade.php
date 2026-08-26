@extends('layouts.app')

@section('title', 'Quality Control (QC)')
@section('header-title', 'Quality Control & Audit')

@section('content')
<!-- KPI Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card-custom p-3">
            <div class="text-uppercase text-muted font-weight-bold" style="font-size: 10.5px; letter-spacing: 0.5px;">TOTAL AUDITED BUNDLES</div>
            <div class="h3 font-weight-bold my-1" style="font-size: 24px; font-weight: 800;">1,180 BND</div>
            <div class="text-muted" style="font-size: 11.5px;">Today's Quality Check</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom p-3">
            <div class="text-uppercase text-muted font-weight-bold" style="font-size: 10.5px; letter-spacing: 0.5px;">PASSED RATE</div>
            <div class="h3 font-weight-bold my-1 text-success" style="font-size: 24px; font-weight: 800;">96.2%</div>
            <div class="text-muted" style="font-size: 11.5px;">AQL 2.5 Standard</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom p-3">
            <div class="text-uppercase text-muted font-weight-bold" style="font-size: 10.5px; letter-spacing: 0.5px;">REJECTED DEFECTS</div>
            <div class="h3 font-weight-bold my-1 text-danger" style="font-size: 24px; font-weight: 800;">45 BUNDLES</div>
            <div class="text-muted" style="font-size: 11.5px;">Sent to Rework</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom p-3">
            <div class="text-uppercase text-muted font-weight-bold" style="font-size: 10.5px; letter-spacing: 0.5px;">TOP DEFECT TYPE</div>
            <div class="h3 font-weight-bold my-1 text-warning" style="font-size: 20px; font-weight: 800;">Stitch Skip (42%)</div>
            <div class="text-muted" style="font-size: 11.5px;">Tension Adjustment Req.</div>
        </div>
    </div>
</div>

<!-- Table Card -->
<div class="card-custom p-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="h5 font-weight-bold m-0" style="font-weight: 700; font-size: 17px;">Quality Audit Logs</h2>
        <button class="btn btn-black" data-bs-toggle="modal" data-bs-target="#newQCModal">
            <i class="bi bi-plus-lg me-1"></i> New QC Audit Log
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 13px;" id="qcTable">
            <thead>
                <tr style="background-color: #f9fafb; border-bottom: 2px solid #e5e7eb; color: #6b7280; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">
                    <th style="padding: 12px 14px;">AUDIT ID</th>
                    <th style="padding: 12px 14px;">BUNDLE NO</th>
                    <th style="padding: 12px 14px;">SEWING LINE</th>
                    <th style="padding: 12px 14px;">QC AUDITOR</th>
                    <th class="text-end" style="padding: 12px 14px;">CHECKED QTY</th>
                    <th class="text-end" style="padding: 12px 14px;">DEFECT COUNT</th>
                    <th style="padding: 12px 14px;">DEFECT DETAILS</th>
                    <th style="padding: 12px 14px;">AUDIT VERDICT</th>
                    <th class="text-center" style="padding: 12px 14px;">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $qcs = [
                        ['id' => 'QC-2026-801', 'bnd' => 'BN-1842', 'line' => 'Line A1', 'auditor' => 'Sarah Smith', 'checked' => 500, 'defects' => 2, 'details' => 'Minor thread loose', 'verdict' => 'PASSED', 'bg' => '#dcfce7', 'color' => '#15803d'],
                        ['id' => 'QC-2026-802', 'bnd' => 'BN-1843', 'line' => 'Line A1', 'auditor' => 'Sarah Smith', 'checked' => 600, 'defects' => 1, 'details' => 'Shade variation', 'verdict' => 'PASSED', 'bg' => '#dcfce7', 'color' => '#15803d'],
                        ['id' => 'QC-2026-803', 'bnd' => 'BN-1844', 'line' => 'Line B2', 'auditor' => 'Mike Ross', 'checked' => 350, 'defects' => 25, 'details' => 'Stitch skip & hem twist', 'verdict' => 'REJECTED', 'bg' => '#fee2e2', 'color' => '#b91c1c'],
                        ['id' => 'QC-2026-804', 'bnd' => 'BN-1845', 'line' => 'Line C1', 'auditor' => 'John Doe', 'checked' => 400, 'defects' => 8, 'details' => 'Buttonhole misaligned', 'verdict' => 'REWORK', 'bg' => '#fef3c7', 'color' => '#b45309'],
                    ];
                @endphp
                @foreach($qcs as $q)
                <tr style="border-bottom: 1px solid #f3f4f6;" id="qc_row_{{ $loop->index }}">
                    <td style="padding: 12px 14px;" class="font-mono fw-bold">{{ $q['id'] }}</td>
                    <td style="padding: 12px 14px; font-weight: 600;" class="font-mono">{{ $q['bnd'] }}</td>
                    <td style="padding: 12px 14px; color: #4b5563;">{{ $q['line'] }}</td>
                    <td style="padding: 12px 14px; color: #4b5563;">{{ $q['auditor'] }}</td>
                    <td class="text-end fw-semibold" style="padding: 12px 14px;">{{ number_format($q['checked']) }} pcs</td>
                    <td class="text-end fw-bold text-danger" style="padding: 12px 14px;">{{ $q['defects'] }}</td>
                    <td style="padding: 12px 14px; color: #4b5563;">{{ $q['details'] }}</td>
                    <td style="padding: 12px 14px;">
                        <span class="badge" style="background-color: {{ $q['bg'] }}; color: {{ $q['color'] }}; font-size: 11px; font-weight: 700; padding: 4px 8px; border-radius: 4px;">
                            {{ $q['verdict'] }}
                        </span>
                    </td>
                    <td class="text-center" style="padding: 12px 14px;">
                        <div class="d-flex justify-content-center gap-1">
                            <button class="btn btn-sm btn-light border p-1" onclick="viewQC('{{ $q['id'] }}', '{{ $q['bnd'] }}', '{{ $q['line'] }}', '{{ $q['auditor'] }}', '{{ $q['checked'] }}', '{{ $q['defects'] }}', '{{ $q['details'] }}', '{{ $q['verdict'] }}')" title="View QC Sheet"><i class="bi bi-eye"></i></button>
                            <button class="btn btn-sm btn-light border p-1 text-primary" onclick="editQC('{{ $q['id'] }}', '{{ $q['defects'] }}')" title="Edit"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-light border p-1 text-danger" onclick="deleteQCRow('qc_row_{{ $loop->index }}', '{{ $q['id'] }}')" title="Delete"><i class="bi bi-trash3"></i></button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: New QC Audit -->
<div class="modal fade" id="newQCModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" style="font-size: 16px;">Create Quality Audit Log</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="newQCForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">AUDIT ID</label>
                        <input type="text" id="qc_id" class="form-control form-control-custom font-mono" value="QC-2026-805" required>
                    </div>
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label font-weight-bold">BUNDLE NO</label>
                            <input type="text" id="qc_bnd" class="form-control form-control-custom font-mono" placeholder="BN-1846" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label font-weight-bold">SEWING LINE</label>
                            <input type="text" id="qc_line" class="form-control form-control-custom" placeholder="Line A1" required>
                        </div>
                    </div>
                    <div class="row g-2 mt-2">
                        <div class="col-6">
                            <label class="form-label font-weight-bold">CHECKED QTY</label>
                            <input type="number" id="qc_checked" class="form-control form-control-custom" placeholder="500" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label font-weight-bold">DEFECT COUNT</label>
                            <input type="number" id="qc_defects" class="form-control form-control-custom" placeholder="0" required>
                        </div>
                    </div>
                    <div class="mb-3 mt-2">
                        <label class="form-label font-weight-bold">DEFECT DETAILS</label>
                        <input type="text" id="qc_details" class="form-control form-control-custom" placeholder="e.g. Minor thread loose" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">AUDIT VERDICT</label>
                        <select id="qc_verdict" class="form-select form-select-custom">
                            <option value="PASSED">PASSED</option>
                            <option value="REWORK">REWORK</option>
                            <option value="REJECTED">REJECTED</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-black">Save Audit Log</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: View QC Details -->
<div class="modal fade" id="viewQCModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" style="font-size: 16px;"><i class="bi bi-clipboard-check text-primary me-2"></i> Quality Audit Inspection Sheet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4" id="viewQCContent"></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('newQCForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const id = document.getElementById('qc_id').value;
    const bnd = document.getElementById('qc_bnd').value;
    const line = document.getElementById('qc_line').value;
    const checked = document.getElementById('qc_checked').value;
    const defects = document.getElementById('qc_defects').value;
    const details = document.getElementById('qc_details').value;
    const verdict = document.getElementById('qc_verdict').value;

    const bg = verdict === 'PASSED' ? '#dcfce7' : (verdict === 'REWORK' ? '#fef3c7' : '#fee2e2');
    const color = verdict === 'PASSED' ? '#15803d' : (verdict === 'REWORK' ? '#b45309' : '#b91c1c');

    const tbody = document.querySelector('#qcTable tbody');
    const tr = document.createElement('tr');
    tr.style.borderBottom = '1px solid #f3f4f6';
    const rowId = 'qc_row_' + Date.now();
    tr.id = rowId;
    tr.innerHTML = `
        <td style="padding: 12px 14px;" class="font-mono fw-bold">${id}</td>
        <td style="padding: 12px 14px; font-weight: 600;" class="font-mono">${bnd}</td>
        <td style="padding: 12px 14px; color: #4b5563;">${line}</td>
        <td style="padding: 12px 14px; color: #4b5563;">Admin User</td>
        <td class="text-end fw-semibold" style="padding: 12px 14px;">${Number(checked).toLocaleString()} pcs</td>
        <td class="text-end fw-bold text-danger" style="padding: 12px 14px;">${defects}</td>
        <td style="padding: 12px 14px; color: #4b5563;">${details}</td>
        <td style="padding: 12px 14px;">
            <span class="badge" style="background-color: ${bg}; color: ${color}; font-size: 11px; font-weight: 700; padding: 4px 8px; border-radius: 4px;">
                ${verdict}
            </span>
        </td>
        <td class="text-center" style="padding: 12px 14px;">
            <div class="d-flex justify-content-center gap-1">
                <button class="btn btn-sm btn-light border p-1" onclick="viewQC('${id}', '${bnd}', '${line}', 'Admin User', '${checked}', '${defects}', '${details}', '${verdict}')"><i class="bi bi-eye"></i></button>
                <button class="btn btn-sm btn-light border p-1 text-primary" onclick="editQC('${id}', '${defects}')"><i class="bi bi-pencil"></i></button>
                <button class="btn btn-sm btn-light border p-1 text-danger" onclick="deleteQCRow('${rowId}', '${id}')"><i class="bi bi-trash3"></i></button>
            </div>
        </td>
    `;
    tbody.prepend(tr);
    bootstrap.Modal.getInstance(document.getElementById('newQCModal')).hide();
    showToast(`Audit Log ${id} saved successfully!`, 'success');
});

function viewQC(id, bnd, line, auditor, checked, defects, details, verdict) {
    document.getElementById('viewQCContent').innerHTML = `
        <div class="mb-3 border-bottom pb-2">
            <div class="text-muted" style="font-size: 11px; font-weight: 700;">AUDIT LOG ID</div>
            <div class="h4 font-mono fw-bold text-dark mb-0">${id}</div>
        </div>
        <div class="row g-3">
            <div class="col-6"><strong>Bundle No:</strong> <div class="font-mono">${bnd}</div></div>
            <div class="col-6"><strong>Verdict:</strong> <div><span class="badge bg-primary">${verdict}</span></div></div>
            <div class="col-6"><strong>Sewing Line:</strong> <div>${line}</div></div>
            <div class="col-6"><strong>Auditor:</strong> <div>${auditor}</div></div>
            <div class="col-6"><strong>Checked Qty:</strong> <div>${Number(checked).toLocaleString()} pcs</div></div>
            <div class="col-6"><strong>Defect Count:</strong> <div class="text-danger fw-bold">${defects}</div></div>
            <div class="col-12"><strong>Defect Notes:</strong> <div>${details}</div></div>
        </div>
    `;
    new bootstrap.Modal(document.getElementById('viewQCModal')).show();
}

function editQC(id, defects) {
    const newDefects = prompt(`Edit Defect Count for Audit ${id}:`, defects);
    if (newDefects !== null && !isNaN(newDefects)) {
        showToast(`Audit ${id} defect count updated to ${newDefects}`, 'success');
    }
}

function deleteQCRow(rowId, id) {
    if (confirm(`Delete Audit Log ${id}?`)) {
        const el = document.getElementById(rowId);
        if (el) el.remove();
        showToast(`Audit Log ${id} deleted successfully`, 'success');
    }
}
</script>
@endpush
