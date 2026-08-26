@extends('layouts.app')

@section('title', 'Edit Bundle — ' . $bundle->bundle_no)
@section('page-title', 'Edit Bundle')
@section('breadcrumb', 'Home / Bundles / Edit')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-pencil-square text-primary"></i>
                Edit Bundle: <strong>{{ $bundle->bundle_no }}</strong>
            </div>
            <div class="card-body p-4">
                <div id="formAlerts"></div>
                <form id="bundleForm" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="bundle_no" class="form-label">Bundle Number <span class="text-danger">*</span></label>
                            <input type="text" id="bundle_no" name="bundle_no" class="form-control"
                                value="{{ $bundle->bundle_no }}" required>
                            <div class="invalid-feedback" id="err_bundle_no"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="production_date" class="form-label">Production Date <span class="text-danger">*</span></label>
                            <input type="date" id="production_date" name="production_date" class="form-control"
                                max="{{ date('Y-m-d') }}" value="{{ $bundle->production_date?->format('Y-m-d') }}" required>
                            <div class="invalid-feedback" id="err_production_date"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="buyer_id" class="form-label">Buyer <span class="text-danger">*</span></label>
                            <select id="buyer_id" name="buyer_id" class="form-select" required>
                                <option value="">— Select Buyer —</option>
                                @foreach($buyers as $b)
                                <option value="{{ $b->id }}" {{ $bundle->buyer_id == $b->id ? 'selected' : '' }}>
                                    {{ $b->buyer_name }}
                                </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="err_buyer_id"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="style_id" class="form-label">Style <span class="text-danger">*</span></label>
                            <select id="style_id" name="style_id" class="form-select" required>
                                <option value="">— Select Style —</option>
                                @foreach($styles as $s)
                                <option value="{{ $s->id }}" {{ $bundle->style_id == $s->id ? 'selected' : '' }}>
                                    {{ $s->style_no }}
                                </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="err_style_id"></div>
                        </div>
                        <div class="col-md-4">
                            <label for="color" class="form-label">Color</label>
                            <input type="text" id="color" name="color" class="form-control" value="{{ $bundle->color }}">
                        </div>
                        <div class="col-md-4">
                            <label for="size" class="form-label">Size</label>
                            <input type="text" id="size" name="size" class="form-control" value="{{ $bundle->size }}">
                        </div>
                        <div class="col-md-4">
                            <label for="line_id" class="form-label">Sewing Line <span class="text-danger">*</span></label>
                            <select id="line_id" name="line_id" class="form-select" required>
                                <option value="">— Select Line —</option>
                                @foreach($sewingLines as $l)
                                <option value="{{ $l->id }}" {{ $bundle->line_id == $l->id ? 'selected' : '' }}>
                                    {{ $l->line_name }}
                                </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="err_line_id"></div>
                        </div>
                        <div class="col-md-4">
                            <label for="quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
                            <input type="number" id="quantity" name="quantity" class="form-control calc-trigger"
                                min="1" value="{{ $bundle->quantity }}" required>
                            <div class="invalid-feedback" id="err_quantity"></div>
                        </div>
                        <div class="col-md-4">
                            <label for="completed_qty" class="form-label">Completed Qty <span class="text-danger">*</span></label>
                            <input type="number" id="completed_qty" name="completed_qty" class="form-control calc-trigger"
                                min="0" value="{{ $bundle->completed_qty }}" required>
                            <div class="invalid-feedback" id="err_completed_qty"></div>
                        </div>
                        <div class="col-md-4">
                            <label for="rejected_qty" class="form-label">Rejected Qty <span class="text-danger">*</span></label>
                            <input type="number" id="rejected_qty" name="rejected_qty" class="form-control calc-trigger"
                                min="0" value="{{ $bundle->rejected_qty }}" required>
                            <div class="invalid-feedback" id="err_rejected_qty"></div>
                        </div>
                        <div class="col-12">
                            <div class="calc-panel">
                                <div class="row text-center g-3">
                                    <div class="col-4 calc-item">
                                        <div class="calc-value text-primary" id="calc_balance">{{ $bundle->balance_qty }}</div>
                                        <div class="calc-label">Balance Qty</div>
                                    </div>
                                    <div class="col-4 calc-item">
                                        <div class="calc-value text-success" id="calc_efficiency">{{ $bundle->efficiency_pct }}%</div>
                                        <div class="calc-label">Efficiency %</div>
                                    </div>
                                    <div class="col-4 calc-item">
                                        <div class="calc-value text-danger" id="calc_rejection">{{ $bundle->rejection_pct }}%</div>
                                        <div class="calc-label">Rejection %</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="operator_name" class="form-label">Operator Name</label>
                            <input type="text" id="operator_name" name="operator_name" class="form-control"
                                value="{{ $bundle->operator_name }}">
                        </div>
                        <div class="col-md-6">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea id="remarks" name="remarks" class="form-control" rows="1">{{ $bundle->remarks }}</textarea>
                        </div>
                        <div class="col-12 d-flex gap-2 pt-2 border-top mt-2">
                            <button type="submit" class="btn btn-primary" id="saveBtn">
                                <i class="bi bi-save me-1"></i>Update Bundle
                            </button>
                            <a href="{{ route('bundles.show', $bundle) }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-1"></i>Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header"><i class="bi bi-clock-history me-1"></i>Bundle Info</div>
            <div class="card-body p-3" style="font-size:13px;">
                <div class="mb-2"><strong>Created:</strong> {{ $bundle->created_at?->format('d M Y H:i') }}</div>
                <div class="mb-2"><strong>Updated:</strong> {{ $bundle->updated_at?->format('d M Y H:i') }}</div>
                <div><strong>ID:</strong> #{{ $bundle->id }}</div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function recalculate() {
    const qty       = parseInt(document.getElementById('quantity').value) || 0;
    const completed = parseInt(document.getElementById('completed_qty').value) || 0;
    const rejected  = parseInt(document.getElementById('rejected_qty').value) || 0;
    const balance    = Math.max(0, qty - completed - rejected);
    const efficiency = qty > 0 ? ((completed / qty) * 100).toFixed(2) : '0.00';
    const rejection  = qty > 0 ? ((rejected / qty) * 100).toFixed(2) : '0.00';
    document.getElementById('calc_balance').textContent    = balance.toLocaleString();
    document.getElementById('calc_efficiency').textContent = efficiency + '%';
    document.getElementById('calc_rejection').textContent  = rejection + '%';
}
document.querySelectorAll('.calc-trigger').forEach(el => el.addEventListener('input', recalculate));

document.getElementById('buyer_id').addEventListener('change', function() {
    const buyerId = this.value;
    const styleSelect = document.getElementById('style_id');
    styleSelect.innerHTML = '<option value="">Loading...</option>';
    if (!buyerId) { styleSelect.innerHTML = '<option value="">— Select Buyer First —</option>'; return; }
    fetch(`{{ route('styles.by-buyer') }}?buyer_id=${buyerId}`)
        .then(r => r.json())
        .then(styles => {
            styleSelect.innerHTML = '<option value="">— Select Style —</option>';
            styles.forEach(s => {
                const opt = document.createElement('option');
                opt.value = s.id; opt.textContent = s.style_no;
                styleSelect.appendChild(opt);
            });
        });
});

let submitting = false;
document.getElementById('bundleForm').addEventListener('submit', function(e) {
    e.preventDefault();
    if (submitting) return;
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    document.querySelectorAll('[id^="err_"]').forEach(el => el.textContent = '');
    document.getElementById('formAlerts').innerHTML = '';
    submitting = true;
    const btn = document.getElementById('saveBtn');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-sm me-1"></span>Saving...';

    const data = new FormData(this);
    data.append('_method', 'PUT');

    fetch('{{ route('bundles.update', $bundle) }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
        body: data,
    })
    .then(r => r.json())
    .then(res => {
        if (res.success) {
            showToast(res.message, 'success');
            setTimeout(() => window.location = res.redirect, 1000);
        } else {
            if (res.errors) {
                Object.entries(res.errors).forEach(([field, msgs]) => {
                    const input = document.getElementById(field);
                    const errEl = document.getElementById('err_' + field);
                    if (input) input.classList.add('is-invalid');
                    if (errEl) errEl.textContent = msgs[0];
                });
            }
            submitting = false;
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-save me-1"></i>Update Bundle';
        }
    })
    .catch(() => {
        showToast('An error occurred.', 'error');
        submitting = false;
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-save me-1"></i>Update Bundle';
    });
});
</script>
@endpush
