<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Company;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->product = new Product();
        $this->company = new Company();
    }

    public function showList(Request $request)
    {
        $query = $this->product->newQuery();
        $companies = $this->company->all();
        $products = $query->paginate(7);

        return view('products_list', [
            'products' => $products,
            'companies' => $companies,
        ]);
    }

    public function searchAndSortProducts(Request $request)
    {

        $query = Product::with('company');

        $query = $this->product->searchAndSortProductsMethod($request,$query);

        $products = $query->paginate(7);

        return response()->json(['products' => $products]);
    }

    public function showProductRegistForm()
    {
        $companies = $this->company->all();

        return view('product_regist_form', [
            'companies' => $companies,
        ]);
    }

    public function productSubmit(ProductRequest $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_name = $image->getClientOriginalName();
            $image->storeAs('public/images', $file_name);
            $image_path = 'storage/images/' . $file_name;
        } else {
            $image_path = null;
        }
        DB::beginTransaction();

        try {
            $this->product->registProduct($request, $image_path);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }

        return redirect(route('product.regist.form'));
    }

    public function productShow($id)
    {
        $product = $this->product->find($id);

        return view('product_show', [
            'product' => $product,
        ]);
    }

    public function showProductUpdate($id)
    {

        return view('product_update', [
            'product' => $this->product->find($id),
            'companies' => $this->company->all(),
        ]);
    }

    public function productUpdateSubmit(ProductRequest $request, $id)
    {
        $product = $this->product->find($id);
        $companies = $this->company->all();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_name = $image->getClientOriginalName();
            $image->storeAs('public/images', $file_name);
            $image_path = 'storage/images/' . $file_name;
        } else {
            $image_path = $product->img_path;
        }

        DB::beginTransaction();
        try {
            $product->updateProduct($request, $image_path);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }

        return redirect(route('product.update', ['id' => $product->id]));
    }

    public function productDestroy($id)
    {
        DB::beginTransaction();
        try {
            $deleteProduct = $this->product->deleteProductById($id);
            DB::commit();

            return response()->json([
                'success' => true,
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
            ]);
        }
    }
}
