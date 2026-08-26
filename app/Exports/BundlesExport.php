<?php

namespace App\Exports;

use App\Models\ProductionBundle;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BundlesExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function __construct(private array $filters = []) {}

    public function query()
    {
        return ProductionBundle::with(['buyer', 'style', 'sewingLine'])
            ->search($this->filters['search'] ?? null)
            ->filterBuyer($this->filters['buyer_id'] ?? null)
            ->filterStyle($this->filters['style_id'] ?? null)
            ->filterLine($this->filters['line_id'] ?? null)
            ->filterDateRange($this->filters['date_from'] ?? null, $this->filters['date_to'] ?? null)
            ->orderBy('id');
    }

    public function headings(): array
    {
        return [
            'Bundle No', 'Buyer', 'Style', 'Color', 'Size',
            'Sewing Line', 'Quantity', 'Completed', 'Rejected',
            'Balance', 'Efficiency %', 'Rejection %',
            'Operator', 'Production Date', 'Remarks',
        ];
    }

    public function map($bundle): array
    {
        return [
            $bundle->bundle_no,
            $bundle->buyer?->buyer_name,
            $bundle->style?->style_no,
            $bundle->color,
            $bundle->size,
            $bundle->sewingLine?->line_name,
            $bundle->quantity,
            $bundle->completed_qty,
            $bundle->rejected_qty,
            $bundle->balance_qty,
            $bundle->efficiency_pct . '%',
            $bundle->rejection_pct . '%',
            $bundle->operator_name,
            $bundle->production_date?->format('Y-m-d'),
            $bundle->remarks,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
