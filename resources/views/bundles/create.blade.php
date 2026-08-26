@extends('layouts.app')

@section('title', 'Entry Form')
@section('header-title', 'Bundle Management')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card-custom p-4">
            <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom">
                <h2 class="h5 font-weight-bold m-0" style="font-weight: 700; font-size: 17px;">New Production Bundle Entry</h2>
                <span class="badge bg-light text-dark border">Step 1 of 1</span>
            </div>

            <div id="formAlerts"></div>

            <form id="bundleForm" novalidate>
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label font-weight-bold" style="font-size: 12px; color: #374151;">BUNDLE NUMBER <span class="text-danger">*</span></label>
                        <input type="text" id="bundle_no" name="bundle_no" class="form-control form-control-custom font-mono" placeholder="e.g. BN-1842" required>
                        <div class="invalid-feedback" id="err_bundle_no"></div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label font-weight-bold" style="font-size: 12px; color: #374151;">PRODUCTION DATE <span class="text-danger">*</span></label>
                        <input type="date" id="production_date" name="production_date" class="form-control form-control-custom" max="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" required>
                        <div class="invalid-feedback" id="err_production_date"></div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label font-weight-bold" style="font-size: 12px; color: #374151;">BUYER <span class="text-danger">*</span></label>
                        <select id="buyer_id" name="buyer_id" class="form-select form-select-custom" required>
                            <option value="">Select Buyer</option>
                            @foreach($buyers as $b)
                                <option value="{{ $b->id }}">{{ $b->buyer_name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="err_buyer_id"></div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label font-weight-bold" style="font-size: 12px; color: #374151;">STYLE <span class="text-danger">*</span></label>
                        <select id="style_id" name="style_id" class="form-select form-select-custom" required>
                            <option value="">Select Buyer First</option>
                        </select>
                        <div class="invalid-feedback" id="err_style_id"></div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label font-weight-bold" style="font-size: 12px; color: #374151;">COLOR</label>
                        <input type="text" id="color" name="color" class="form-control form-control-custom" placeholder="e.g. Navy">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label font-weight-bold" style="font-size: 12px; color: #374151;">SIZE</label>
                        <input type="text" id="size" name="size" class="form-control form-control-custom" placeholder="e.g. M">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label font-weight-bold" style="font-size: 12px; color: #374151;">SEWING LINE <span class="text-danger">*</span></label>
                        <select id="line_id" name="line_id" class="form-select form-select-custom" required>
                            <option value="">Select Line</option>
                            @foreach($sewingLines as $l)
                                <option value="{{ $l->id }}">{{ $l->line_name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="err_line_id"></div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label font-weight-bold" style="font-size: 12px; color: #374151;">QUANTITY <span class="text-danger">*</span></label>
                        <input type="number" id="quantity" name="quantity" class="form-control form-control-custom calc-trigger" min="1" placeholder="0" required>
                        <div class="invalid-feedback" id="err_quantity"></div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label font-weight-bold" style="font-size: 12px; color: #374151;">COMPLETED QTY <span class="text-danger">*</span></label>
                        <input type="number" id="completed_qty" name="completed_qty" class="form-control form-control-custom calc-trigger" min="0" value="0" required>
                        <div class="invalid-feedback" id="err_completed_qty"></div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label font-weight-bold" style="font-size: 12px; color: #374151;">REJECTED QTY <span class="text-danger">*</span></label>
                        <input type="number" id="rejected_qty" name="rejected_qty" class="form-control form-control-custom calc-trigger" min="0" value="0" required>
                        <div class="invalid-feedback" id="err_rejected_qty"></div>
                    </div>

                    <!-- Realtime Calculation Panel -->
                    <div class="col-12 my-3">
                        <div class="p-3 border rounded-3" style="background-color: #f8fafc;">
                            <div class="row text-center g-3">
                                <div class="col-4 border-end">
                                    <div class="text-muted text-uppercase" style="font-size: 10.5px; font-weight: 700;">BALANCE QTY</div>
                                    <div class="h4 font-weight-bold mb-0 text-primary" id="calc_balance" style="font-size: 20px; font-weight: 800;">0</div>
                                </div>
                                <div class="col-4 border-end">
                                    <div class="text-muted text-uppercase" style="font-size: 10.5px; font-weight: 700;">EFFICIENCY %</div>
                                    <div class="h4 font-weight-bold mb-0 text-success" id="calc_efficiency" style="font-size: 20px; font-weight: 800;">0.00%</div>
                                </div>
                                <div class="col-4">
                                    <div class="text-muted text-uppercase" style="font-size: 10.5px; font-weight: 700;">REJECTION %</div>
                                    <div class="h4 font-weight-bold mb-0 text-danger" id="calc_rejection" style="font-size: 20px; font-weight: 800;">0.00%</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label font-weight-bold" style="font-size: 12px; color: #374151;">OPERATOR NAME</label>
                        <input type="text" id="operator_name" name="operator_name" class="form-control form-control-custom" placeholder="e.g. John Doe">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label font-weight-bold" style="font-size: 12px; color: #374151;">REMARKS</label>
                        <input type="text" id="remarks" name="remarks" class="form-control form-control-custom" placeholder="Optional remarks...">
                    </div>

                    <div class="col-12 pt-3 border-top d-flex gap-2">
                        <button type="submit" class="btn btn-black" id="saveBtn"><i class="bi bi-check2-circle me-1"></i> Save Bundle</button>
                        <a href="{{ route('bundles.index') }}" class="btn btn-outline-custom">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card-custom p-4">
            <h3 class="h6 font-weight-bold mb-3" style="font-weight: 700; font-size: 15px;">Business Rules</h3>
            <ul class="list-unstyled text-muted mb-0" style="font-size: 12.5px; line-height: 1.8;">
                <li><i class="bi bi-check-circle-fill text-success me-2"></i>Bundle Number must be unique</li>
                <li><i class="bi bi-check-circle-fill text-success me-2"></i>Quantity must be greater than zero</li>
                <li><i class="bi bi-check-circle-fill text-success me-2"></i>Completed &le; Total Quantity</li>
                <li><i class="bi bi-check-circle-fill text-success me-2"></i>Rejected &le; Total Quantity</li>
                <li><i class="bi bi-check-circle-fill text-success me-2"></i>Completed + Rejected &le; Quantity</li>
                <li><i class="bi bi-check-circle-fill text-success me-2"></i>Production Date cannot be future</li>
            </ul>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function recalculate() {
    const qty = parseInt(document.getElementById('quantity').value) || 0;
    const completed = parseInt(document.getElementById('completed_qty').value) || 0;
    const rejected = parseInt(document.getElementById('rejected_qty').value) || 0;

    const balance = Math.max(0, qty - completed - rejected);
    const eff = qty > 0 ? ((completed / qty) * 100).toFixed(2) : '0.00';
    const rej = qty > 0 ? ((rejected / qty) * 100).toFixed(2) : '0.00';

    document.getElementById('calc_balance').textContent = balance.toLocaleString();
    document.getElementById('calc_efficiency').textContent = eff + '%';
    document.getElementById('calc_rejection').textContent = rej + '%';
}
document.querySelectorAll('.calc-trigger').forEach(el => el.addEventListener('input', recalculate));

document.getElementById('buyer_id').addEventListener('change', function() {
    const buyerId = this.value;
    const styleSelect = document.getElementById('style_id');
    styleSelect.innerHTML = '<option value="">Loading...</option>';
    if (!buyerId) { styleSelect.innerHTML = '<option value="">Select Buyer First</option>'; return; }

    fetch(`{{ route('styles.by-buyer') }}?buyer_id=${buyerId}`)
        .then(r => r.json())
        .then(styles => {
            styleSelect.innerHTML = '<option value="">Select Style</option>';
            styles.forEach(s => {
                const opt = document.createElement('option');
                opt.value = s.id; opt.textContent = s.style_no;
                styleSelect.appendChild(opt);
            });
        });
});

document.getElementById('bundleForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const btn = document.getElementById('saveBtn');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Saving...';

    fetch('{{ route("bundles.store") }}', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
        body: new FormData(this)
    }).then(r => r.json()).then(res => {
        if(res.success) {
            showToast(res.message, 'success');
            setTimeout(() => location.href = res.redirect, 1000);
        } else {
            showToast(res.message || 'Validation error', 'danger');
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-check2-circle me-1"></i> Save Bundle';
        }
    });
});
</script>
@endpush
