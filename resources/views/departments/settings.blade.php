@extends('layouts.app')

@section('title', 'ERP Settings')
@section('header-title', 'System & Factory Settings')

@section('content')
<div class="row g-4">
    <!-- General Settings -->
    <div class="col-md-6">
        <div class="card-custom p-4 h-100">
            <h2 class="h5 font-weight-bold mb-3" style="font-weight: 700; font-size: 16px;"><i class="bi bi-building me-2"></i> Factory Profile & ERP Settings</h2>
            <form>
                <div class="mb-3">
                    <label class="form-label font-weight-bold" style="font-size: 12px;">FACTORY NAME</label>
                    <input type="text" class="form-control form-control-custom" value="ERP Management Apparel Manufacturing Ltd.">
                </div>
                <div class="mb-3">
                    <label class="form-label font-weight-bold" style="font-size: 12px;">CURRENCY SYMBOL</label>
                    <input type="text" class="form-control form-control-custom" value="USD ($)">
                </div>
                <div class="mb-3">
                    <label class="form-label font-weight-bold" style="font-size: 12px;">DEFAULT AQL STANDARD</label>
                    <select class="form-select form-select-custom">
                        <option selected>AQL 2.5 (Standard Garment Inspection)</option>
                        <option>AQL 1.5 (Strict Quality Inspection)</option>
                        <option>AQL 4.0 (Basic Quality Inspection)</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label font-weight-bold" style="font-size: 12px;">SHIFT OPERATING HOURS</label>
                    <input type="text" class="form-control form-control-custom" value="08:00 AM - 05:00 PM (Shift A)">
                </div>
                <button type="button" class="btn btn-black" onclick="showToast('Settings saved successfully.', 'success')">Save Profile</button>
            </form>
        </div>
    </div>

    <!-- Production Capacity per Line -->
    <div class="col-md-6">
        <div class="card-custom p-4 h-100">
            <h2 class="h5 font-weight-bold mb-3" style="font-weight: 700; font-size: 16px;"><i class="bi bi-speedometer2 me-2"></i> Target Production Capacity per Line</h2>
            <div class="table-responsive">
                <table class="table align-middle" style="font-size: 13px;">
                    <thead>
                        <tr class="text-muted" style="font-size: 11px;">
                            <th>SEWING LINE</th>
                            <th class="text-end">TARGET DAILY QTY</th>
                            <th class="text-end">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lines as $line)
                        <tr>
                            <td class="font-weight-bold">{{ $line->line_name }}</td>
                            <td class="text-end fw-bold font-mono">1,200 pcs/day</td>
                            <td class="text-end"><span class="badge-status-active">Active</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
