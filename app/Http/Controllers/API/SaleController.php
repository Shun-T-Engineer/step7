<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\product;
use App\Models\Sale;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function saleItem(Request $request)
    {
        $product = Product::find($request->product_id);
        if (! $product) {
            return response()->json([
                'success' => false,
                'message' => '商品が見つかりません。',
            ], 404);
        }

        DB::beginTransaction();
        try {
            $product->stockCount();

            $sale = Sale::newSaleRecord($product->id);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => '購入が完了しました。',
                'product' => $product,
                'sale' => $sale,
            ], 200);
        } catch (Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => '購入に失敗しました: ' . $e->getMessage(),
            ], 500);
        }
    }
}
