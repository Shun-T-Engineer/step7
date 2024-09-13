<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function getList()
    {
        $products = Product::with('company')->get();

        return $products;
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
}
