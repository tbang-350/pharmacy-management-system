<?php

// app/Http/Controllers/NotificationController.php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $lowStockProducts = Product::where('stock', '<', 10)->get();
        $expiredProducts = Product::where('expiry_date', '<', now())->get();

        return view('notifications.index', compact('lowStockProducts', 'expiredProducts'));
    }
}
