<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBundleRequest;
use App\Http\Requests\UpdateBundleRequest;
use App\Models\Buyer;
use App\Models\ProductionBundle;
use App\Models\SewingLine;
use App\Models\Style;
use App\Exports\BundlesExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductionBundleController extends Controller
{
    /* ------------------------------------------------------------------ */
    /*  Index — Listing with search/filter/sort/pagination                   */
    /* ------------------------------------------------------------------ */

    public function index(Request $request)
    {
        $perPage   = in_array($request->per_page, [20, 50, 100]) ? $request->per_page : 20;
        $search    = $request->search;
        $sortCol   = $this->resolveSortColumn($request->sort ?? 'id');
        $sortDir   = $request->direction === 'asc' ? 'asc' : 'desc';

        $query = ProductionBundle::with(['buyer', 'style', 'sewingLine'])
            ->search($search)
            ->filterBuyer($request->buyer_id)
            ->filterStyle($request->style_id)
            ->filterLine($request->line_id)
            ->filterDateRange($request->date_from, $request->date_to);

        // Sorting
        if ($sortCol === 'efficiency') {
            $query->orderByRaw('CASE WHEN quantity > 0 THEN (completed_qty / quantity) * 100 ELSE 0 END ' . $sortDir);
        } elseif (in_array($sortCol, ['buyer_name', 'style_no'])) {
            $relation = $sortCol === 'buyer_name' ? 'buyers' : 'styles';
            $query->join($relation, $relation . '.id', '=', 'production_bundles.' . ($sortCol === 'buyer_name' ? 'buyer_id' : 'style_id'))
                  ->orderBy($relation . '.' . $sortCol, $sortDir)
                  ->select('production_bundles.*');
        } else {
            $query->orderBy('production_bundles.' . $sortCol, $sortDir);
        }

        $bundles = $query->paginate($perPage)->withQueryString();

        $buyers      = Buyer::orderBy('buyer_name')->get();
        $styles      = Style::orderBy('style_no')->get();
        $sewingLines = SewingLine::orderBy('line_name')->get();

        return view('bundles.index', compact('bundles', 'buyers', 'styles', 'sewingLines', 'perPage', 'search', 'sortCol', 'sortDir'));
    }

    /* ------------------------------------------------------------------ */
    /*  Create                                                               */
    /* ------------------------------------------------------------------ */

    public function create()
    {
        $buyers      = Buyer::orderBy('buyer_name')->get();
        $sewingLines = SewingLine::orderBy('line_name')->get();
        $styles      = collect();

        return view('bundles.create', compact('buyers', 'sewingLines', 'styles'));
    }

    /* ------------------------------------------------------------------ */
    /*  Store (AJAX)                                                         */
    /* ------------------------------------------------------------------ */

    public function store(StoreBundleRequest $request)
    {
        $bundle = ProductionBundle::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => "Bundle #{$bundle->bundle_no} created successfully.",
            'redirect' => route('bundles.index'),
        ]);
    }

    /* ------------------------------------------------------------------ */
    /*  Show                                                                 */
    /* ------------------------------------------------------------------ */

    public function show(ProductionBundle $bundle)
    {
        $bundle->load(['buyer', 'style', 'sewingLine']);
        return view('bundles.show', compact('bundle'));
    }

    /* ------------------------------------------------------------------ */
    /*  Edit                                                                 */
    /* ------------------------------------------------------------------ */

    public function edit(ProductionBundle $bundle)
    {
        $bundle->load(['buyer', 'style', 'sewingLine']);
        $buyers      = Buyer::orderBy('buyer_name')->get();
        $sewingLines = SewingLine::orderBy('line_name')->get();
        $styles      = Style::where('buyer_id', $bundle->buyer_id)->orderBy('style_no')->get();

        return view('bundles.edit', compact('bundle', 'buyers', 'sewingLines', 'styles'));
    }

    /* ------------------------------------------------------------------ */
    /*  Update (AJAX)                                                        */
    /* ------------------------------------------------------------------ */

    public function update(UpdateBundleRequest $request, ProductionBundle $bundle)
    {
        $bundle->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => "Bundle #{$bundle->bundle_no} updated successfully.",
            'redirect' => route('bundles.index'),
        ]);
    }

    /* ------------------------------------------------------------------ */
    /*  Destroy (Soft Delete)                                                */
    /* ------------------------------------------------------------------ */

    public function destroy(ProductionBundle $bundle)
    {
        $bundle->delete();

        return response()->json([
            'success' => true,
            'message' => "Bundle #{$bundle->bundle_no} deleted.",
        ]);
    }

    /* ------------------------------------------------------------------ */
    /*  AJAX: Styles by Buyer                                                */
    /* ------------------------------------------------------------------ */

    public function stylesByBuyer(Request $request)
    {
        $styles = Style::where('buyer_id', $request->buyer_id)
            ->orderBy('style_no')
            ->get(['id', 'style_no']);

        return response()->json($styles);
    }

    /* ------------------------------------------------------------------ */
    /*  Export                                                               */
    /* ------------------------------------------------------------------ */

    public function export(Request $request)
    {
        $format = $request->format === 'csv' ? 'csv' : 'xlsx';
        $filename = 'bundles_' . now()->format('Ymd_His') . '.' . $format;

        return Excel::download(new BundlesExport($request->all()), $filename);
    }

    /* ------------------------------------------------------------------ */
    /*  Print Slip                                                           */
    /* ------------------------------------------------------------------ */

    public function printSlip(ProductionBundle $bundle)
    {
        $bundle->load(['buyer', 'style', 'sewingLine']);
        return view('bundles.print', compact('bundle'));
    }

    /* ------------------------------------------------------------------ */
    /*  Helpers                                                              */
    /* ------------------------------------------------------------------ */

    private function resolveSortColumn(string $col): string
    {
        $allowed = [
            'id'              => 'id',
            'bundle_no'       => 'bundle_no',
            'buyer'           => 'buyer_name',
            'style'           => 'style_no',
            'quantity'        => 'quantity',
            'efficiency'      => 'efficiency',
            'production_date' => 'production_date',
        ];

        return $allowed[$col] ?? 'id';
    }
}
