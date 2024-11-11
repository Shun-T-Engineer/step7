<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

class Product extends Model
{
    use HasFactory;
    use Sortable;

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function getList()
    {
        $products = Product::with('company')->get();

        return $products;
    }

    public function searchProductsMethod($request,$query){
        
        $keyword = $request->input('keyword');
        if(! empty($keyword)){
            $query->where('product_name','Like',"%{$keyword}%");
        }

        $companyId = $request->input('company_id');
        if(! empty($companyId)) {
            $query->where('company_id' , $companyId);
        }

        $upperLimitPrice = $request->input('upper_limit_price');
        if(! empty($upperLimitPrice)){
            $query->where('price', '<=', $upperLimitPrice);
        }

        $lowerLimitPrice = $request->input('lower_limit_price');
        if(! empty($lowerLimitPrice)){
            $query->where('price', '>=', $lowerLimitPrice);
        }

        $upperLimitStock = $request->input('upper_limit_stock');
        if(! empty($upperLimitStock)){
            $query->where('stock', '<=', $upperLimitStock);
        }

        $lowerLimitStock = $request->input('lower_limit_stock');
        if(! empty($lowerLimitStock)){
            $query->where('stock', '>=', $lowerLimitStock);
        }

        return $query;
    }

    public function registProduct($data, $image_path = null)
    {
        DB::table('products')->insert([
            'product_name' => $data->product_name,
            'company_id' => $data->company_id,
            'price' => $data->price,
            'stock' => $data->stock,
            'comment' => $data->comment,
            'img_path' => $image_path,
        ]);
    }

    public function updateProduct($data, $image_path)
    {
        $this->company_id = $data->company_id;
        $this->product_name = $data->product_name;
        $this->price = $data->price;
        $this->stock = $data->stock;
        $this->comment = $data->comment;
        $this->img_path = $image_path;

        $this->save();
    }

    public function deleteProductById($id)
    {
        return $this->destroy($id);
    }

    public $sortable = ['id', 'product_name', 'price', 'stock', 'company_id'];

    

    //以下API用のコード

    public function stockCount()
    {
        if ($this->stock <= 0) {
            throw new Exception('在庫がありません。');
        }

        $this->stock -= 1;
        $this->save();

        return $this;
    }
}
