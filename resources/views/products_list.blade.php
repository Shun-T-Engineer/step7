
@extends('layouts.template')

@section('title','商品一覧')


@section('content')

  <div class="row">
    <div class="products_list">
      <div class="products_title__search_form">
        <div class="products_list-title">商品一覧画面</div>
          <div class="search__form">
            <form method="GET" action="{{ route('product.list')}}">
              <input type="text" name="keyword" value="{{ request('keyword')}}" placeholder="商品キーワード">
              
              <select name="company_id">
                <option value="">メーカー名</option>
                @foreach($companies as $company)
                  <option value="{{ $company->id }}">
                  {{ $company->company_name }}
                  </option>
                @endforeach
              </select>
              <button type="submit" class="products_list_search_btn" >検索</button>
            </form>
          </div>
        </div>
      </div>
        <div class="table">
        <table>
          <thead>
            <tr>
              <th class="id_number">ID</th>
              <th>商品画像</th>
              <th>商品名</th>
              <th>価格</th>
              <th>在庫数</th>
              <th>メーカー名</th>
              <th>
              <button type="button" onclick="location.href='{{ route('product.regist.form') }}'" class="new_product__btn" id="new_product_btn">新規登録</button>
              </th>
            </tr>
          </thead>
          <tbody>
            @foreach ($products as $product)
            <tr>
              <td class="products__list-id">{{$product->id }}.</td>
              <td>
                @if($product->img_path)  
                  <img src="{{ asset($product->img_path) }}" width="50" height="50">
                @else
                  商品画像
                @endif
                </td>
              <td class="product__name">{{$product->product_name }}</td>
              <td>￥{{$product->price }}</td>
              <td>{{$product->stock }}</td>
              <td>{{$product->company->company_name}}</td>
              <td>
                <div class="show__destroy_btn">
                  <button type="button" onclick="location.href='{{ route('product.show',['id' =>$product->id]) }}'" class="show__btn">詳細</button>
                  <form action="{{ route('product.destroy',['id'=>$product->id]) }}" method="POST" class="destroy__form">
                    @csrf
                    <button type="submit" class="destroy__btn" id="destroy_btn" onclick='return confirm("削除します。よろしいですか？")'>削除</button>
                  </form>
                <div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <div class="pagination">
          {{ $products->links() }}
        </div>
    </div>
  </div>


@endsection
