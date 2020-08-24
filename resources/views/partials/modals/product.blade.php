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
      class="btn modal-btn"
      @click="modal.product.show = false; product()">
      @{{ modal.product.action | capitalize }}
    </button>

    <button
      class="btn modal-btn"
      @click="modal.product.show = false">
      Close
    </button>
  </template>
</modal>