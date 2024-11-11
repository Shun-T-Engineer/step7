let currentSortColumn = 'id'; 
let currentSortDirection = 'asc'; 

$(document).ready(function() {
  let csrfToken = $('meta[name="csrf-token"]').attr('content');

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
        dataType:'json',
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

  $(document).on('click', '.product_sort_btn',function(){
    let column = $(this).data('column');
    sortProducts(column);
  });

  function sortProducts(column){
    if (currentSortColumn === column){
      currentSortDirection = currentSortDirection === 'asc' ? 'desc' : 'asc';
    } else {
      currentSortColumn = column;
      currentSortDirection = 'asc';
    }
    
    let keyword = $('#keyword').val();
    let companyId = $('#company_id').val();
    let upperLimitPrice = $('#upper_limit_price').val();
    let lowerLimitPrice = $('#lower_limit_price').val();
    let upperLimitStock = $('#upper_limit_stock').val();
    let lowerLimitStock = $('#lower_limit_stock').val();

    searchProductForm(keyword,companyId,upperLimitPrice,lowerLimitPrice,upperLimitStock,lowerLimitStock);
  }

  $('#search__form').on('submit', function(e) {
      e.preventDefault();
      let keyword = $('#keyword').val();
      let companyId = $('#company_id').val();
      let upperLimitPrice = $('#upper_limit_price').val();
      let lowerLimitPrice = $('#lower_limit_price').val();
      let upperLimitStock = $('#upper_limit_stock').val();
      let lowerLimitStock = $('#lower_limit_stock').val();
      searchProductForm(keyword,companyId,upperLimitPrice,lowerLimitPrice,upperLimitStock,lowerLimitStock);
  });

  function searchProductForm(keyword,companyId,upperLimitPrice,lowerLimitPrice,upperLimitStock,lowerLimitStock){

      $.ajax({
          type: 'GET',
          url:  `${baseUrl}products/search`,
          data: {
              keyword: keyword,
              company_id: companyId,
              upper_limit_price: upperLimitPrice,
              lower_limit_price: lowerLimitPrice,
              upper_limit_stock: upperLimitStock,
              lower_limit_stock: lowerLimitStock,
              sort: currentSortColumn,
              direction: currentSortDirection
          },
          dataType: 'json'
      })
      .done(function(data) {
        displayProducts(data);
      }).fail(function(data) {
        alert('検索出来ませんでした。');
      });

      function displayProducts(data){
          let productListHtml = '';
          let productUrl = `${baseUrl}product/show`; 

          $.each(data.products.data, function(index, product) {
              productListHtml +=`
                  <tr id="product-row-${product.id}"> 
                      <td class="products__list-id">${product.id}.</td>
                      <td>${product.img_path ? `<img class="products__list-img" src="${baseUrl}${product.img_path}" width="50" height="50">` : '商品画像'}</td>
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
        }
     
  };
});
