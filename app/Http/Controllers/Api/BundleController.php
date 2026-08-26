<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBundleRequest;
use App\Http\Requests\UpdateBundleRequest;
use App\Models\ProductionBundle;
use Illuminate\Http\Request;

class BundleController extends Controller
{
    /* ------------------------------------------------------------------ */
    /*  GET /api/v1/bundles                                                  */
    /* ------------------------------------------------------------------ */

    public function index(Request $request)
    {
        $perPage = in_array($request->per_page, [20, 50, 100]) ? $request->per_page : 20;

        $bundles = ProductionBundle::with(['buyer', 'style', 'sewingLine'])
            ->search($request->search)
            ->filterBuyer($request->buyer_id)
            ->filterStyle($request->style_id)
            ->filterLine($request->line_id)
            ->filterDateRange($request->date_from, $request->date_to)
            ->orderBy($request->sort ?? 'id', $request->direction === 'asc' ? 'asc' : 'desc')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data'    => $bundles->items(),
            'meta'    => [
                'total'        => $bundles->total(),
                'per_page'     => $bundles->perPage(),
                'current_page' => $bundles->currentPage(),
                'last_page'    => $bundles->lastPage(),
            ],
        ]);
    }

    /* ------------------------------------------------------------------ */
    /*  POST /api/v1/bundles                                                 */
    /* ------------------------------------------------------------------ */

    public function store(StoreBundleRequest $request)
    {
        $bundle = ProductionBundle::create($request->validated());
        $bundle->load(['buyer', 'style', 'sewingLine']);

        return response()->json([
            'success' => true,
            'message' => 'Bundle created successfully.',
            'data'    => $this->formatBundle($bundle),
        ], 201);
    }

    /* ------------------------------------------------------------------ */
    /*  GET /api/v1/bundles/{id}                                             */
    /* ------------------------------------------------------------------ */

    public function show(ProductionBundle $bundle)
    {
        $bundle->load(['buyer', 'style', 'sewingLine']);

        return response()->json([
            'success' => true,
            'data'    => $this->formatBundle($bundle),
        ]);
    }

    /* ------------------------------------------------------------------ */
    /*  PUT /api/v1/bundles/{id}                                             */
    /* ------------------------------------------------------------------ */

    public function update(UpdateBundleRequest $request, ProductionBundle $bundle)
    {
        $bundle->update($request->validated());
        $bundle->load(['buyer', 'style', 'sewingLine']);

        return response()->json([
            'success' => true,
            'message' => 'Bundle updated successfully.',
            'data'    => $this->formatBundle($bundle),
        ]);
    }

    /* ------------------------------------------------------------------ */
    /*  DELETE /api/v1/bundles/{id}                                          */
    /* ------------------------------------------------------------------ */

    public function destroy(ProductionBundle $bundle)
    {
        $bundle->delete();

        return response()->json([
            'success' => true,
            'message' => 'Bundle deleted successfully.',
        ]);
    }

    /* ------------------------------------------------------------------ */
    /*  Helper                                                               */
    /* ------------------------------------------------------------------ */

    private function formatBundle(ProductionBundle $bundle): array
    {
        return [
            'id'              => $bundle->id,
            'bundle_no'       => $bundle->bundle_no,
            'buyer'           => $bundle->buyer?->buyer_name,
            'style'           => $bundle->style?->style_no,
            'color'           => $bundle->color,
            'size'            => $bundle->size,
            'sewing_line'     => $bundle->sewingLine?->line_name,
            'quantity'        => $bundle->quantity,
            'completed_qty'   => $bundle->completed_qty,
            'rejected_qty'    => $bundle->rejected_qty,
            'balance_qty'     => $bundle->balance_qty,
            'efficiency_pct'  => $bundle->efficiency_pct,
            'rejection_pct'   => $bundle->rejection_pct,
            'operator_name'   => $bundle->operator_name,
            'production_date' => $bundle->production_date?->format('Y-m-d'),
            'remarks'         => $bundle->remarks,
            'created_at'      => $bundle->created_at,
            'updated_at'      => $bundle->updated_at,
        ];
    }
}
