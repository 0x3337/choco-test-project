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