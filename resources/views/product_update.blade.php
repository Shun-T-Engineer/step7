@extends('layouts.template')

@section('title', '商品更新')

@section('content')
<div class="row">
  <div class="product_update">
    <div class="product__update-form">
    <div class="product_update_title">商品情報編集画面</div>
      <form action="{{route('product.update.submit',['id'=>$product->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="update__form-groups">

          <div class="update-form__group_id">
            <p>ID</p>
            <div class="update-form__groups_data">{{$product->id}}.</div>
          </div>

          <div class="update__form-group">
            <label for="product_name" class="required">商品名</label>
            <input type="text" class="form-control" id="product_name" name="product_name" value="{{ old('product_name', $product->product_name) }}" required>
            @if($errors->has('product_name'))
              <p>{{ $errors->first('product_name')}}</p>
            @endif
          </div>

          <div class="update__form-group">
            <label for="company_id" class="required">メーカー名</label>
            <select name="company_id" class="form-control" id="company_id" required>
              <option value=""></option>
              @foreach($companies as $company)
              <option value="{{ $company->id }}" {{ old('company_id',$product->company_id) == $company->id ? 'selected': ''}}>
                {{ $company->company_name }}
              </option>
              @endforeach
            </select>
            @if($errors->has('company_id'))
              <p>{{ $errors->first('company_id')}}</p>
            @endif
          </div>

          <div class="update__form-group">
            <label for="price" class="required">価格</label>
            <input type="text" class="form-control" id="price" name="price" value="{{old('price',$product->price) }}" required>
            @if($errors->has('price'))
              <p>{{ $errors->first('price')}}</p>
            @endif
          </div>

          <div class="update__form-group">
            <label for="stock" class="required">在庫数</label>
            <input type="text" class="form-control" id="stock" name="stock" value="{{old('stock',$product->stock)}}" required>
            @if($errors->has('stock'))
              <p>{{ $errors->first('stock')}}</p>
            @endif
          </div>

          <div class="update__form-group">
            <label for="comment">コメント</label>
            <textarea class="form-control" id="comment" name="comment">{{old('comment',$product->comment)}}</textarea>
            @if($errors->has('comment'))
              <p>{{$errors->first('comment')}}</p>
            @endif
          </div>

          <div class="update__form-group">
            <label for="image">商品画像</label>
            @if($product->img_path)
            <img src="{{ asset($product->img_path ) }}" alt="{{ $product->product_name }}" width="100">
            @else
              <p>商品画像はありません</p>
            @endif
           </div>
            <input type="file" id="image" name="image" class="update-form__control-file">


          <div class="update_product__back_btn">
            <button type="submit" class="update_product__btn">更新</button>
            <button type="button" onclick="location.href='{{ route('product.show',['id' =>$product->id]) }}'" class="update_product__back-btn">戻る</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection