<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'product_name' => 'required|max:255',
            'company_id' => 'required|integer',
            'price' => 'required|integer|min:1',
            'stock' => 'required|integer|min:0',
            'comment' => 'nullable|max:10000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
        ];
    }

    public function attributes()
    {
        return [
            'product_name' => '商品名',
            'price' => '価格',
            'stock' => '在庫数',
            'comment' => 'コメント',
            'company_id' => 'メーカー名',
            'image' => '写真',
        ];
    }

    public function messages()
    {
        return [
            'product_name.required' => ':attributeは必須項目です。',
            'product_name.max' => ':attributeは:max字以内で入力してください。',
            'price.required' => ':attributeは必須項目です。',
            'price.integer' => ':attributeは整数で入力してください。',
            'price.min' => ':attributeは1円以上で入力してください。',
            'stock.required' => ':attributeは必須項目です。',
            'stock.integer' => ':attributeは整数で入力してください。',
            'stock.min' => ':attributeは0個以上で入力してください。',
            'comment.max' => ':attributeは:max字以内で入力してください。',
            'company_id.required' => ':attributeは必須項目です。',
            'image.image' => '写真ではありません。',
            'image.mimes' => 'jpg,jpeg,pngで登録してください。',
        ];
    }
}
