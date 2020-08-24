@extends('layouts.main')

@section('page')
<main id="shop">
  <section>
    <div class="wrap">
      <h1 class="sct-title">Shop</h1>

      <div class="shop-container">
        <div class="shop-categories">
          <ul class="sc-nav">
            <category-item
              v-for="item in categoryList"
              :category="item"
              :url="'/shop/' + item.slug">
            </category-item>

            @role('admin')
              <li>
                <a class="sc-nav-link black" @click="showCategoryModal">
                  <span>Create Category</span>
                </a>
              </li>
            @endrole
          </ul>
        </div>

        <div class="shop-results">
          <div class="product-filter">
            <div>
              <input type="text" placeholder="min" v-model="filter.minPrice">
              <input type="text" placeholder="max" v-model="filter.maxPrice">
            </div>
          </div>

          <div class="product-list">
            <product-item
              v-for="item in productFilteredList"
              :product="item"
              :url="'/shop/p/' + item.id">
            </product-item>
          </div>
        </div>
      </div>
    </div>
  </section>

  @include('partials.modals.category')
  @include('partials.modals.product')
</main>
@stop

@push('scripts')
<script type="text/x-template" id="modal-template">
  <transition name="modal">
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container">
          <div class="modal-header">
            <slot name="header">
          </div>

          <div class="modal-body">
            <slot name="body">
          </div>

          <div class="modal-footer">
            <slot name="footer">
              <button class="modal-default-button" @click="$emit('close')">
                OK
              </button>
            </slot>
          </div>
        </div>
      </div>
    </div>
  </transition>
</script>

<script>
  (function () {
    @if ($category)
      var category = '{{ $category->slug }}';
    @else 
      var category = undefined;
    @endif

    Vue.filter('capitalize', function(value) {
      if (!value) return '';
      value = value.toString();
      return value.charAt(0).toUpperCase() + value.slice(1);
    });

    Vue.component('modal', {
      template: '#modal-template'
    });

    Vue.component('category-item', {
      props: ['category', 'url'],
      template: `
        <li>
          <a class="sc-nav-link" :href="url">
            <span>@{{ category.name }}</span>
          </a>

          @role('admin')
            <button @click="showCategoryModal(category)">
              <i class="icon-edit"></i>
            </button>
          @endrole
        </li>`,
      methods: {
        showCategoryModal: function (category) {
          shop.modal.category.show = true;
          shop.modal.category.action = 'update';

          shop.currentCategory = Object.assign({}, category);
        }
      }
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

          <h3>
            <span>@{{ product.name }}</span>

            @role('admin')
              <button @click="showProductModal(product)">
                <i class="icon-edit"></i>
              </button>
            @endrole
          </h3>
          <p>@{{ product.price }}</p>
        </div>`,
      methods: {
        showProductModal: function (product) {
          shop.modal.product.show = true;
          shop.modal.product.action = 'update';

          shop.currentProduct = Object.assign({}, product);
        }
      }
    });

    var shop = new Vue({
      el: '#shop',
      data: {
        modal: {
          category: {
            show: false,
            action: 'create',
          },

          product: {
            show: false,
            action: 'create',
          },
        },

        filter: {
          minPrice: null,
          maxPrice: null,
        },

        currentCategory: {},
        categoryList: [],

        currentProduct: {},
        productList: [],
      },
      methods: {
        update: function(obj, prop, event) {
          Vue.set(obj, prop, event.target.value);
        },

        showCategoryModal: function () {
          shop.modal.category.show = true;
          shop.modal.category.action = 'create';

          shop.currentCategory = {};
        },

        showProductModal: function () {
          shop.modal.product.show = true;
          shop.modal.product.action = 'create';

          shop.currentProduct = {};
        },

        updateCategoryName: function () {
          var text = this.currentCategory.name;

          text = text.replace(/&/g, 'and');
          text = text.replace(/[^\w\d]+/g, '-');
          text = text.replace(/-+/, '-');
          text = text.toLowerCase();

          this.currentCategory.slug = text;
        },


        category: function () {
          l2.ajax({
            url: '/api/category/' + this.modal.category.action,
            json: this.currentCategory,
            success: function (res) {
              shop.currentCategory = {};

              if (res.success) {
                var index = shop.categoryList.findIndex(c => c.id === res.category.id);
                if (index >= 0) {
                  Vue.set(shop.categoryList, index, res.category);
                } else {
                  shop.categoryList.push(res.category);
                }
              }
            }
          });
        },

        product: function () {
          l2.ajax({
            url: '/api/product/' + this.modal.product.action,
            json: this.currentProduct,
            success: function (res) {
              shop.currentProduct = {};

              if (res.success) {
                var index = shop.productList.findIndex(p => p.id === res.product.id);
                if (index >= 0) {
                  Vue.set(shop.productList, index, res.product);
                } else {
                  shop.productList.push(res.product);
                }
              }
            }
          });
        },
      },
      computed: {
        productFilteredList: function () {
          return this.productList.filter(p => {
            if (!this.filter.minPrice && !this.filter.maxPrice) {
              return true;
            }

            var price = parseFloat(p.price);
            var minPrice = parseFloat(this.filter.minPrice || 0);
            var maxPrice = parseFloat(this.filter.maxPrice|| Number.MAX_VALUE);

            return price >= minPrice && price <= maxPrice;
          });
        },
      },
      mounted() {
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
      }
    });
  })();
</script>
@endpush