<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bundle Slip — {{ $bundle->bundle_no }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #000; margin: 20px; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 16px; }
        .company { font-size: 18px; font-weight: bold; }
        .slip-title { font-size: 14px; font-weight: bold; letter-spacing: 1px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        td, th { border: 1px solid #ccc; padding: 6px 10px; }
        th { background: #f0f0f0; font-weight: bold; width: 40%; }
        .section-title { font-weight: bold; background: #e8e8e8; padding: 4px 10px; margin-top: 14px; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; }
        .perf-bar { height: 10px; border-radius: 4px; background: #eee; overflow: hidden; display: inline-block; width: 80px; vertical-align: middle; }
        .perf-fill { height: 100%; }
        .footer { margin-top: 30px; display: flex; justify-content: space-between; border-top: 1px solid #ccc; padding-top: 14px; }
        .sig { text-align: center; width: 30%; }
        .sig-line { border-top: 1px solid #000; margin-top: 30px; padding-top: 4px; font-size: 10px; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>
<div class="no-print" style="margin-bottom:14px;">
    <button onclick="window.print()" style="padding:6px 16px;cursor:pointer;font-size:13px;">🖨 Print</button>
    <button onclick="window.close()" style="margin-left:8px;padding:6px 16px;cursor:pointer;font-size:13px;">✕ Close</button>
</div>

<div class="header">
    <div class="company">Apparel Manufacturing ERP</div>
    <div class="slip-title">Production Bundle Slip</div>
    <div style="font-size:10px; color:#555;">Generated: {{ now()->format('d M Y, H:i') }}</div>
</div>

<table>
    <tr><th>Bundle Number</th><td><strong>{{ $bundle->bundle_no }}</strong></td></tr>
    <tr><th>Production Date</th><td>{{ $bundle->production_date?->format('d M Y') }}</td></tr>
    <tr><th>Buyer</th><td>{{ $bundle->buyer?->buyer_name }}</td></tr>
    <tr><th>Style No</th><td>{{ $bundle->style?->style_no }}</td></tr>
    <tr><th>Color</th><td>{{ $bundle->color ?: '—' }}</td></tr>
    <tr><th>Size</th><td>{{ $bundle->size ?: '—' }}</td></tr>
    <tr><th>Sewing Line</th><td>{{ $bundle->sewingLine?->line_name }}</td></tr>
    <tr><th>Operator Name</th><td>{{ $bundle->operator_name ?: '—' }}</td></tr>
</table>

<div class="section-title">Quantity Summary</div>
<table>
    <tr>
        <th>Total Quantity</th><td>{{ number_format($bundle->quantity) }}</td>
        <th>Completed</th><td>{{ number_format($bundle->completed_qty) }}</td>
    </tr>
    <tr>
        <th>Rejected</th><td>{{ number_format($bundle->rejected_qty) }}</td>
        <th>Balance</th><td>{{ number_format($bundle->balance_qty) }}</td>
    </tr>
    <tr>
        <th>Efficiency %</th>
        <td>
            <div class="perf-bar"><div class="perf-fill" style="width:{{ $bundle->efficiency_pct }}%;background:#16a34a;"></div></div>
            <strong>{{ $bundle->efficiency_pct }}%</strong>
        </td>
        <th>Rejection %</th>
        <td>
            <div class="perf-bar"><div class="perf-fill" style="width:{{ $bundle->rejection_pct }}%;background:#dc2626;"></div></div>
            <strong>{{ $bundle->rejection_pct }}%</strong>
        </td>
    </tr>
</table>

@if($bundle->remarks)
<div class="section-title">Remarks</div>
<table><tr><td>{{ $bundle->remarks }}</td></tr></table>
@endif

<div class="footer">
    <div class="sig">
        <div class="sig-line">Prepared By</div>
    </div>
    <div class="sig">
        <div class="sig-line">Line Supervisor</div>
    </div>
    <div class="sig">
        <div class="sig-line">QC Manager</div>
    </div>
</div>
</body>
</html>
