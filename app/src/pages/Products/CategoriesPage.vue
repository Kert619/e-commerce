<template>
  <q-page>
    <CategoryIndex />
  </q-page>
</template>

<script setup lang="ts">
import CategoryIndex from 'components/Categories/CategoryIndex.vue';
import { useCategoryStore } from 'src/stores/category';

defineOptions({
  async preFetch({ store, currentRoute }) {
    const categoryStore = useCategoryStore()(store);

    let page = 1;
    let perPage = 10;

    //retain pagination and search when reloading the page
    if (currentRoute.query.page)
      page = parseInt(currentRoute.query.page.toString());

    if (currentRoute.query.per_page)
      perPage = parseInt(currentRoute.query.per_page.toString());

    if (currentRoute.query.search)
      categoryStore.filter.category_name = currentRoute.query.search.toString();

    await categoryStore.fetchIndex(page, perPage, true);
    await categoryStore.fetchOptions(true);
  },
});
</script>
