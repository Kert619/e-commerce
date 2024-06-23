<template>
  <div class="q-pa-sm">
    <q-input
      filled
      v-model="filter"
      label="Search Category"
      clearable
      style="max-width: 800px"
    >
      <template #append>
        <q-btn
          label="Search"
          color="primary"
          class="fit"
          unelevated
          icon="search"
        />
      </template>
    </q-input>

    <q-table
      :columns="columns"
      :rows="categoryStore.index"
      row-key="id"
      :rows-per-page-options="[10, 20, 30, 40, 50]"
      class="q-mt-sm"
      :filter="filter"
    >
      <template v-slot:header-cell-row="props">
        <q-th :props="props" auto-width>
          {{ props.col.label }}
        </q-th>
      </template>

      <template v-slot:header-cell-category_name="props">
        <q-th :props="props">
          {{ props.col.label }}
        </q-th>
      </template>

      <template v-slot:header-cell-parent_category="props">
        <q-th :props="props">
          {{ props.col.label }}
        </q-th>
      </template>

      <template v-slot:body="props">
        <q-tr :props="props">
          <q-td key="category_name" :props="props">
            {{ props.row.category_name }}
          </q-td>

          <q-td key="parent_category" :props="props">
            {{ props.row.parent_category?.category_name }}
          </q-td>
        </q-tr>
      </template>
    </q-table>
  </div>
</template>

<script setup lang="ts">
import { QTableColumn } from 'quasar';
import { useCategoryStore } from 'src/stores/category';
import { ref } from 'vue';

const columns: QTableColumn[] = [
  {
    name: 'category_name',
    label: 'Category Name',
    field: 'category_name',
    align: 'left',
    sortable: true,
  },
  {
    name: 'parent_category',
    label: 'Parent Category',
    field: '',
    align: 'left',
    sortable: true,
  },
];

const categoryStore = useCategoryStore()();
const filter = ref('');
</script>

<style scoped lang="scss">
:deep(.q-field__control) {
  padding-right: 0 !important;
}
</style>
