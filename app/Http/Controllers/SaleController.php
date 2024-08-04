<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function store(Request $request)
    {
        $saleItems = $request->input('saleItems');

        DB::transaction(function () use ($saleItems) {
            $sale = Sale::create([
                'user_id' => auth()->id(),
                'total' => array_reduce($saleItems, function ($carry, $item) {
                    return $carry + $item['price'];
                }, 0),
            ]);

            foreach ($saleItems as $item) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                // Update the product's stock
                $product = Product::find($item['product_id']);
                $product->stock -= $item['quantity'];
                $product->save();
            }
        });

        return response()->json(['success' => true]);
    }
}
