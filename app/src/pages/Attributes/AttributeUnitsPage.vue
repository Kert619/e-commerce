<template>
  <q-page padding style="padding-top: 55px">
    <AttributeUnitIndex />
  </q-page>
</template>

<script setup lang="ts">
import AttributeUnitIndex from 'components/AttributeUnits/AttributeUnitIndex.vue';
import { useAttributeUnitStore } from 'stores/attribute-unit';

defineOptions({
  async preFetch({ store, currentRoute }) {
    const attributeUnitStore = useAttributeUnitStore(store);

    if (currentRoute.query.search)
      attributeUnitStore.filter.attribute_unit_name =
        currentRoute.query.search.toString();

    await attributeUnitStore.fetchIndex(true);
  },
});
</script>
