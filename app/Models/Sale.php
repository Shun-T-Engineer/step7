<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'sales';

    protected $fillable = ['product_id'];

    public static function newSaleRecord($productId)
    {
        $sale = new self();
        $sale->product_id = $productId;
        $sale->save();

        return $sale;
    }
}
