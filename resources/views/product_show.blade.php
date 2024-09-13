@extends('layouts.template')

@section('title', '商品詳細')

@section('content')

    <div class="row">
        <div class="product_show">
        <div class="product__shows">
            <div class="product__show-title">商品詳細画面</div>
            <div class="product__show-groups">

                <div class="product__show-group">
                    <p class="id_number">ID</p>
                    <div class="product_show_data">{{$product->id}}.</div>
                </div>

                <div class="product__show-group">
                        <p>商品画像</p>
                        <div class="product_show_data">@if($product->img_path)
                        <img src="{{ asset($product->img_path) }}" alt="{{ $product->product_name }}" width="100" height="100">
                            @else
                            <div class="product_show_data"> 商品画像はありません</div>
                            @endif
                        </div>
                </div> 

                <div class="product__show-group">
                    <p>商品名</p>
                    <div class="product_show_data">{{ $product->product_name }}</div>
                </div>

                <div class="product__show-group">
                    <p>メーカー</p>
                    <div class="product_show_data">{{ $product->company->company_name }}</div>
                </div>

                <div class="product__show-group">
                    <p>価格</p>
                    <div class="product_show_data">{{ $product->price }}円</div>
                </div>

                <div class="product__show-group">
                    <p>在庫数</p>
                    <div class="product_show_data">{{ $product->stock }}</div>
                </div>

                <div class="product__show-group"> 
                    <p>コメント</p>
                    <div class="product__show-data">{{ $product->comment }}</div>
                </div>

                <div class="update_link__back_btn">
                    <button type="button" class="update_link_btn" onclick="location.href='{{ route('product.update',['id' =>$product->id]) }}'" class="update_btn">編集</button>
                    <button type="button" class="product_show_btn" onclick="location.href='{{ route('product.list') }}'">戻る</button>
                </div>

                </div>
            </div>
        </div>
    </div>

@endsection