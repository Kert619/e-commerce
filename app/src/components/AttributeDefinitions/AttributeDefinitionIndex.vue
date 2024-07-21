<template>
  <q-table
    :columns="columns"
    :rows="[]"
    row-key="id"
    :rows-per-page-options="[0]"
    :loading="loading"
    class="q-mt-sm"
  >
    <template v-slot:header-cell-name="props">
      <q-th :props="props">
        {{ props.col.label }}
      </q-th>
    </template>

    <template v-slot:header-cell-short_name="props">
      <q-th :props="props">
        {{ props.col.label }}
      </q-th>
    </template>

    <template v-slot:header-cell-unit="props">
      <q-th :props="props">
        {{ props.col.label }}
      </q-th>
    </template>

    <template v-slot:header-cell-priority="props">
      <q-th :props="props">
        {{ props.col.label }}
      </q-th>
    </template>

    <template #bottom-row>
      <q-tr no-hover>
        <q-td colspan="5">
          <q-btn
            label="Create"
            color="positive"
            unelevated
            no-wrap
            icon="add"
            @click="attributeCategoryStore.create"
        /></q-td>
      </q-tr>

      <!-- ATTRIBUTE CATEGORY CREATED -->
      <template v-if="attributeCategoryStore.created.size > 0">
        <AttributeCategoryRowCreate
          v-for="created in attributeCategoryStore.created.values()"
          :attribute-category="created"
          :key="`category-created-${created.$id?.toString()}`"
          @deleted="
            attributeCategoryStore.created.delete(created.$id as string)
          "
        />
      </template>
    </template>
  </q-table>
  <!-- place QPageSticky at end of page -->
  <q-page-sticky expand position="top" class="bg-white q-pa-sm">
    <q-toolbar class="row q-gutter-sm">
      <div class="col col-md-4">
        <q-input
          filled
          v-model="filter"
          label="Search Attribute"
          clearable
          dense
        />
      </div>

      <div class="col-auto">
        <q-btn
          label="Search"
          color="primary"
          class="fit"
          unelevated
          no-wrap
          icon="search"
        />
      </div>
    </q-toolbar>
  </q-page-sticky>
</template>

<script setup lang="ts">
import { QTableColumn } from 'quasar';
import { useAttributeCategoryStore } from 'src/stores/attribute-category';
import { onMounted, ref } from 'vue';
import AttributeCategoryRowCreate from 'components/AttributeDefinitions/AttributeCategoryRowCreate.vue';

const columns: QTableColumn[] = [
  {
    name: 'name',
    label: 'Name',
    field: '',
    align: 'left',
  },
  {
    name: 'short_name',
    label: 'Short Name',
    field: '',
    align: 'left',
  },
  {
    name: 'unit',
    label: 'Unit',
    field: '',
    align: 'left',
  },
  {
    name: 'priority',
    label: 'Priority',
    field: '',
    align: 'left',
  },
  {
    name: 'action',
    label: '',
    field: '',
    align: 'left',
  },
];

const attributeCategoryStore = useAttributeCategoryStore();
const filter = ref('');
const loading = ref(false);

onMounted(() => {
  attributeCategoryStore.created = new Map();
});
</script>
