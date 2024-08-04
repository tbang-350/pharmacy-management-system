<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'category', 'batch_number', 'barcode', 'price', 'quantity', 'expiry_date'
    ];

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }
}
