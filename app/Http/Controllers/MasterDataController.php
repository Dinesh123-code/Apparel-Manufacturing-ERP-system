<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use App\Models\SewingLine;
use App\Models\Style;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    public function buyers(Request $request)
    {
        $buyers = Buyer::withCount('productionBundles')->orderBy('id', 'desc')->paginate(20);
        return view('master.buyers', compact('buyers'));
    }

    public function storeBuyer(Request $request)
    {
        $request->validate([
            'buyer_name' => 'required|string|max:150|unique:buyers,buyer_name',
        ]);

        Buyer::create(['buyer_name' => $request->buyer_name]);

        return response()->json([
            'success' => true,
            'message' => 'Buyer created successfully.',
        ]);
    }

    public function destroyBuyer(Buyer $buyer)
    {
        $buyer->delete();
        return response()->json([
            'success' => true,
            'message' => 'Buyer deleted successfully.',
        ]);
    }

    public function styles(Request $request)
    {
        $styles = Style::with('buyer')->withCount('productionBundles')->orderBy('id', 'desc')->paginate(20);
        $buyers = Buyer::orderBy('buyer_name')->get();
        return view('master.styles', compact('styles', 'buyers'));
    }

    public function storeStyle(Request $request)
    {
        $request->validate([
            'buyer_id' => 'required|exists:buyers,id',
            'style_no' => 'required|string|max:100',
        ]);

        Style::create($request->only('buyer_id', 'style_no'));

        return response()->json([
            'success' => true,
            'message' => 'Style created successfully.',
        ]);
    }

    public function destroyStyle(Style $style)
    {
        $style->delete();
        return response()->json([
            'success' => true,
            'message' => 'Style deleted successfully.',
        ]);
    }

    public function sewingLines(Request $request)
    {
        $lines = SewingLine::withCount('productionBundles')->orderBy('id', 'desc')->paginate(20);
        return view('master.lines', compact('lines'));
    }

    public function storeSewingLine(Request $request)
    {
        $request->validate([
            'line_name' => 'required|string|max:100|unique:sewing_lines,line_name',
        ]);

        SewingLine::create(['line_name' => $request->line_name]);

        return response()->json([
            'success' => true,
            'message' => 'Sewing line created successfully.',
        ]);
    }

    public function destroySewingLine(SewingLine $line)
    {
        $line->delete();
        return response()->json([
            'success' => true,
            'message' => 'Sewing line deleted successfully.',
        ]);
    }
}
