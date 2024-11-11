
@extends('layouts.template')

@section('title','商品一覧')

@section('content')
<script>
    var productUrl = "{{ url('product/show') }}";
</script>


  <div class="row">
    <div class="products_list">
      <div class="products_title__search_form">
        <div class="products_list-title">商品一覧画面</div>
          <div class="search__form">
            <form method="GET" id="search__form">
              <input type="text" id="keyword" name="keyword" value="{{ request('keyword')}}" placeholder="商品キーワード">
  
              <select name="company_id" id="company_id">
                <option value="">メーカー名</option>
                @foreach($companies as $company)
                  <option value="{{ $company->id }}">
                  {{ $company->company_name }}
                  </option>
                @endforeach
              </select>

              <input type="number" id="lower_limit_price" name="lower_limit_price" value="{{ request('lower_limit_price') }}" placeholder="下限価格">
              <input type="number" id="upper_limit_price" name="upper_limit_price" value="{{ request('upper_limit_price') }}" placeholder="上限価格">
              
              <input type="number" id="lower_limit_stock" name="lower_limit_stock" value="{{ request('lower_limit_stock') }}" placeholder="下限在庫数">
              <input type="number" id="upper_limit_stock" name="upper_limit_stock" value="{{ request('upper_limit_stock') }}" placeholder="上限在庫数">

              <button type="submit" class="products_list__search_btn" >検索</button>
            </form>
          </div>
        </div>
      </div>
        <div class="table" id="productList">
        <table>
        <thead>
            <tr>
                <th class="id_number">@sortablelink('id', 'ID', request()->query(), ['class' => 'sortable-link'])</th>
                <th>商品画像</th>
                <th>@sortablelink('product_name', '商品名', request()->query(), ['class' => 'sortable-link'])</th>
                <th>@sortablelink('price', '価格', request()->query(), ['class' => 'sortable-link'])</th>
                <th>@sortablelink('stock', '在庫数', request()->query(), ['class' => 'sortable-link'])</th>
                <th>@sortablelink('company_id', 'メーカー名', request()->query(), ['class' => 'sortable-link'])</th>
                <th>
                    <button type="button" onclick="location.href='{{ route('product.regist.form') }}'" class="new_product__btn" id="new_product_btn">新規登録</button>
                </th>
            </tr>
        </thead>
          <tbody>
            @foreach ($products as $product)
            <tr id="product-row-{{ $product->id }}">
              <td  class="products__list-id">{{$product->id }}.</td>
              <td>
                @if($product->img_path)  
                  <img class="products__list-img" src="{{ asset($product->img_path) }}" >
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
                  <button type="button" class="destroy__btn" data-product-id="{{ $product->id }}" >削除</button>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <div class="pagination">
          {{ $products->appends(request()->query())->links() }}
        </div>
    </div>
  </div>


@endsection
