<?php

// app/Http/Controllers/ReportController.php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function salesReport(Request $request)
    {
        $date = $request->query('date', now()->toDateString());
        $sales = Sale::whereDate('created_at', $date)->with('saleItems.product')->get();

        $totalSales = $sales->sum('total');
        $totalProfit = $sales->sum(function ($sale) {
            return $sale->saleItems->sum(function ($item) {
                return $item->quantity * ($item->price - $item->product->cost_price);
            });
        });

        return view('reports.sales', compact('sales', 'totalSales', 'totalProfit', 'date'));
    }
}

