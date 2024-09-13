@extends('layouts.template')

@section('title','商品新規登録画面')

@section('content')
    <div class="row">
      <div class="product_regist">
        <div class="product__regist-form">
          <div class="product__regist-title">商品新規登録画面</div>
          <form action="{{ route('product.submit')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form__groups">
              <div class="form__group">
                <label for="product_name" class="required" >商品名</label>
                <input type="text" class="form-control" id="product_name" name="product_name" value="{{ old('product_name')}}" required>
                @if($errors->has('product_name'))
                  <p>{{ $errors->first('product_name')}}</p>
                @endif
              </div>

              <div class="form__group">
                <label for="company_id" class="required">メーカー名</label>
                <select name="company_id" class="form-control" id="company_id" required >
                  <option value=""></option>
                  @foreach($companies as $company)
                  <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                    {{ $company->company_name }}
                  </option>
                  @endforeach
                </select>
                @if($errors->has('company_id'))
                  <p>{{ $errors->first('company_id')}}</p>
                @endif
              </div>
              
              <div class="form__group">
              <label for="price" class="required">価格</label>
              <input type="text" class="form-control" id="price" name="price" value="{{ old('price')}}" required >
              @if($errors->has('price'))
                <p>{{ $errors->first('price')}}</p>
              @endif
              </div>

              <div class="form__group">
                <label for="stock" class="required">在庫数</label>
                <input type="text" class="form-control" id="stock" name="stock" value="{{ old('stock')}}" required>
                @if($errors->has('stock'))
                  <p>{{ $errors->first('stock')}}</p>
                @endif
              </div>

              <div class="form__group">
                <label for="comment">コメント</label>
                <textarea class="form-control" id="comment" name="comment">{{old('comment')}}</textarea>
                @if($errors->has('comment'))
                  <p>{{$errors->first('comment') }}</p>
                @endif
              </div>

              <div class="form__group">
                <label for="image">商品画像</label>
                <input type="file" class="form_control_file" id="image" name="image">
              </div>  

              <div class="new_product__back_btn">
                <button type="submit" class="new_product__submit_btn">新規登録</button>
                <button type="button" onclick="location.href='{{ route('product.list')}}'" class="new_product__back-btn">戻る</button>
              </div>
          </form>
       </div>
      </div>
    </div>
@endsection
