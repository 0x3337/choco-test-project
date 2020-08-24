@extends('layouts.main')

@section('page')
<main id="shop">
  <section>
    <div class="wrap">
      <h1>Shop</h1>

      <div class="shop-container">
        <div class="shop-categories">
          <ul class="sc-nav">
            <category-item
              v-for="item in categoryList"
              :category="item"
              :url="'/shop/' + item.slug">
            </category-item>

            @auth
              <li>
                <a class="sc-nav-link" @click="showCategoryModal">
                  <span>Create Category</span>
                </a>
              </li>
            @endauth
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

  <modal v-if="modal.category.show" @close="modal.category.show = false">
    <template #header>
      <h3>@{{ modal.category.action | capitalize }} Category</h3>
    </template>

    <template #body>
      <input
        type="text"
        placeholder="Name"

        :value="currentCategory.name"
        @input="update(currentCategory, 'name', $event); updateCategoryName()">
      <input
        type="text"
        placeholder="Slug"

        :value="currentCategory.slug"
        @input="update(currentCategory, 'slug', $event);">
    </template>

    <template #footer>
      <button
        class="modal-default-button"
        @click="modal.category.show = false; category()">
        @{{ modal.category.action | capitalize }}
      </button>

      <button
        class="modal-default-button"
        @click="modal.category.show = false">
        Close
      </button>
    </template>
  </modal>

  <modal v-if="modal.product.show" @close="modal.product.show = false">
    <template #header>
      <h3>@{{ modal.product.action | capitalize }} Product</h3>
    </template>

    <template #body>
      <input
        type="text"
        placeholder="Name"

        :value="currentProduct.name"
        @input="update(currentProduct, 'name', $event)">

      <input
        type="text"
        placeholder="Price"

        :value="currentProduct.price"
        @input="update(currentProduct, 'price', $event)">
    </template>

    <template #footer>
      <button
        class="modal-default-button"
        @click="modal.product.show = false; product()">
        @{{ modal.product.action | capitalize }}
      </button>

      <button
        class="modal-default-button"
        @click="modal.product.show = false">
        Close
      </button>
    </template>
  </modal>
</main>
@stop

@push('styles')
<style type="text/css">
  .modal-mask {
    width: 100%;
    height: 100%;

    display: table;
    background-color: rgba(0, 0, 0, 0.5);
    transition: opacity 0.3s ease;

    position: fixed;
    top: 0;
    left: 0;

    z-index: 9998;
  }

  .modal-wrapper {
    display: table-cell;
    vertical-align: middle;
  }

  .modal-container {
    width: 300px;
    margin: 0px auto;
    padding: 20px 30px;

    border-radius: 2px;
    background-color: #fff;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);

    transition: all 0.3s ease;
  }

  .modal-header h3 {
    margin-top: 0;
  }

  .modal-body {
    margin: 20px 0;
  }

  .modal-footer {
    display: flex;
    flex-flow: row nowrap;
  }

  .modal-default-button {
    flex-grow: 1;
  }

  .modal-enter {
    opacity: 0;
  }

  .modal-leave-active {
    opacity: 0;
  }

  .modal-enter .modal-container,
  .modal-leave-active .modal-container {
    -webkit-transform: scale(1.1);
    transform: scale(1.1);
  }
</style>
@endpush

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

          @auth
            <button @click="showCategoryModal(category)">
              <i class="icon-edit"></i>
            </button>
          @endauth
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

            @auth
              <button @click="showProductModal(product)">
                <i class="icon-edit"></i>
              </button>
            @endauth
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