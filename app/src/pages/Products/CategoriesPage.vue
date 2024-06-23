<template>
  <q-page>
    <CategoryIndex />
  </q-page>
</template>

<script setup lang="ts">
import CategoryIndex from 'components/Categories/CategoryIndex.vue';
import { useCategoryStore } from 'src/stores/category';

defineOptions({
  async preFetch({ store }) {
    const categoryStore = useCategoryStore()(store);
    await categoryStore.fetchIndex();
  },
});
</script>
