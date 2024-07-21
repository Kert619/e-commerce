<template>
  <q-page padding style="padding-top: 55px">
    <AttributeDefinitionIndex />
  </q-page>
</template>

<script setup lang="ts">
import AttributeDefinitionIndex from 'components/AttributeDefinitions/AttributeDefinitionIndex.vue';
import { useAttributeCategoryStore } from 'stores/attribute-category';

defineOptions({
  async preFetch({ store }) {
    const attributeCategoryStore = useAttributeCategoryStore(store);
    await attributeCategoryStore.fetchIndex(true);
  },
});
</script>
