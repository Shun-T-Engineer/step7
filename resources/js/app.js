$(document).ready(function() {
  let csrfToken = $('meta[name="csrf-token"]').attr('content');
  const productSearchUrl = document.querySelector('meta[name="product-search-url"]').getAttribute('content');

  function deleteProduct(productId) {
      if (!confirm("削除します。よろしいですか？")) {
          return;
      }

      $.ajax({
        url: `${baseUrl}product/destroy/${productId}`,
        type: 'POST',
        data: {
            _token: csrfToken,
            _method: 'DELETE'
        },
        dataType: 'json',
       })
        .done(function(response) {
          if (response.success) {
          alert("商品を削除しました。");
          $(`#product-row-${productId}`).remove();
          } else {
            alert("削除に失敗しました。");
          }
        })
        .fail(function(error) {
          alert("削除に失敗しました。");
   
      });
    }

  $(document).on('click', '.destroy__btn', function() {
    let productId = $(this).data('product-id');
    deleteProduct(productId);
  });


  $('#search__form').on('submit', function(e) {
      e.preventDefault();
      let keyword = $('#keyword').val();
      let companyId = $('#company_id').val();
      let upperLimitPrice = $('#upper_limit_price').val();
      let lowerLimitPrice = $('#lower_limit_price').val();
      let upperLimitStock = $('#upper_limit_stock').val();
      let lowerLimitStock = $('#lower_limit_stock').val();

      let searchParams = new URLSearchParams();
      if (keyword) searchParams.set('keyword', keyword);
      if (companyId) searchParams.set('company_id', companyId);
      if (upperLimitPrice) searchParams.set('upper_limit_price', upperLimitPrice);
      if (lowerLimitPrice) searchParams.set('lower_limit_price', lowerLimitPrice);
      if (upperLimitStock) searchParams.set('upper_limit_stock', upperLimitStock);
      if (lowerLimitStock) searchParams.set('lower_limit_stock', lowerLimitStock);

      const newUrl = `${window.location.pathname}?${searchParams.toString()}`;
      history.replaceState(null, '', newUrl); 
      
      let searchUrl = new URL(productSearchUrl);
      searchUrl.search = searchParams.toString();

      $.ajax({
          type: 'GET',
          url: searchUrl.toString(),
          dataType: 'json'
      })
      .done(function(data) {
          let productListHtml = '';
          let productUrl = `${baseUrl}product/show`; 

          $.each(data.products.data, function(index, product) {
              productListHtml +=`
                  <tr id="product-row-${product.id}"> 
                      <td class="products__list-id">${product.id}.</td>
                      <td>${product.img_path ? `<img src="${baseUrl}${product.img_path}" width="50" height="50">` : '商品画像'}</td>
                      <td class="product__name">${product.product_name}</td>
                      <td>￥${product.price}</td>
                      <td>${product.stock}</td>
                      <td>${product.company.company_name}</td>
                      <td>
                        <div class="show__destroy_btn">
                          <button type="button" onclick="location.href='${productUrl}/${product.id}'" class="show__btn">詳細</button>
                          <button type="button" data-product-id="${product.id}" class="destroy__btn">削除</button>
                        </div>
                      </td>
                  </tr>`;
          });
          $('#productList tbody').html(productListHtml);


          updateSortableLinks(searchParams);
      }).fail(function() {
          alert('検索出来ませんでした。');
      });
  });
  
  function updateSortableLinks(searchParams) {
    $('.sortable-link').off('click').on('click', function(e) {
        e.preventDefault();
        
        // クリックしたソートリンクのURLを取得し、パラメータを組み合わせる
        let link = $(this);
        let href = new URL(link.attr('href'), window.location.origin);

        // 現在のソート方向を取得
        let currentDirection = href.searchParams.get('direction') || 'asc'; // デフォルトは昇順
        let newDirection = currentDirection === 'asc' ? 'desc' : 'asc'; // 昇順と降順を交互に設定

        // 検索条件と新しいソート条件を追加
        searchParams.forEach((value, key) => {
            href.searchParams.set(key, value);
        });
        href.searchParams.set('direction', newDirection); // 新しい方向をセット

        // リンクのhref属性を更新して次のクリック時に反映されるようにする
        link.attr('href', href.toString());

        // デバッグ用にリクエストURLを確認
        console.log('AjaxリクエストURL:', href.toString());

        // ソートされた結果を非同期で取得
        $.ajax({
            type: 'GET',
            url: productSearchUrl, // ベースのURLを指定
            data: {
                keyword: searchParams.get('keyword'),
                company_id: searchParams.get('company_id'),
                upper_limit_price: searchParams.get('upper_limit_price'),
                lower_limit_price: searchParams.get('lower_limit_price'),
                upper_limit_stock: searchParams.get('upper_limit_stock'),
                lower_limit_stock: searchParams.get('lower_limit_stock'),
                sort: href.searchParams.get('sort'),
                direction: newDirection // 更新されたdirectionを渡す
            },
            dataType: 'json'
        })
        .done(function(data) {
            let productListHtml = '';
            let productUrl = `${baseUrl}product/show`; 

            $.each(data.products.data, function(index, product) {
                productListHtml +=`
                    <tr id="product-row-${product.id}"> 
                        <td class="products__list-id">${product.id}.</td>
                        <td>${product.img_path ? `<img src="${baseUrl}${product.img_path}" width="50" height="50">` : '商品画像'}</td>
                        <td class="product__name">${product.product_name}</td>
                        <td>￥${product.price}</td>
                        <td>${product.stock}</td>
                        <td>${product.company.company_name}</td>
                        <td>
                          <div class="show__destroy_btn">
                            <button type="button" onclick="location.href='${productUrl}/${product.id}'" class="show__btn">詳細</button>
                            <button type="button" data-product-id="${product.id}" class="destroy__btn">削除</button>
                          </div>
                        </td>
                    </tr>`;
            });
            $('#productList tbody').html(productListHtml);

            // 更新後のリンクを再度設定
            updateSortableLinks(searchParams);
        })
        .fail(function() {
            alert('ソートに失敗しました。');
        });
    });
}
});
