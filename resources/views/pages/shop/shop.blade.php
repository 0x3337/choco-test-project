@extends('layouts.main')

@section('page')
  <main id="shop">
    <section>
      <div class="wrap">
        <h1>@{{ category }}</h1>

        <div class="shop-container">
          <div class="shop-categories">
            <ul class="sc-nav">
              <category-item
                v-for="item in categoryList"
                :category="item"
                :url="'/shop/' + item.slug">
              </category-item>
            </ul>
          </div>

          <div class="shop-results">
            <div class="product-list">
              <product-item
                v-for="item in productList"
                :product="item"
                :url="'/shop/p/' + item.id">
              </product-item>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
@stop

@push('scripts')
  <script>
    (function () {
      @if ($category)
        var category = '{{ $category->slug }}';
      @else 
        var category = undefined;
      @endif

      Vue.component('category-item', {
        props: ['category', 'url'],
        template: `
          <li>
            <a class="sc-nav-link" :href="url">
              <span>@{{ category.name }}</span>
            </a>
          </li>`,
      });

      Vue.component('product-item', {
        props: ['product', 'url'],
        template: `
          <div class="pl-item">
            <a :href="url">
              <span class="visually-hidden">More</span>
            </a>

            <div class="pl-i-image-box">
              <img :src="product.imagePath">
            </div>

            <h3>@{{ product.name }}</h3>
            <p>@{{ product.price }}</p>
          </div>`,
      });

      var shop = new Vue({
        el: '#shop',
        data: {
          category: 'Shop',
          categoryList: [],
          productList: [],
        }
      });

      l2.ajax({
        url: '/api/category/get_all',
        method: 'POST',
        success: function (res) {
          if (res.success) {
            shop.categoryList = res.categories;
          }
        },
      });

      l2.ajax({
        url: '/api/product/get_all',
        json: {
          categories: category,
        },
        success: function (res) {
          if (res.success) {
            shop.productList = res.products;
          }
        },
      });
    })();
  </script>
@endpush