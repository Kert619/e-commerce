<template>
  <div class="q-pa-sm">
    <div class="row q-gutter-sm">
      <div class="col col-md-4">
        <q-input
          filled
          v-model="filter"
          label="Search Category"
          clearable
          dense
          @keydown.enter="fetchIndex(1, 10)"
          @clear="fetchIndex(1, 10)"
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
          @click="fetchIndex(1, 10)"
        />
      </div>

      <div class="col-auto">
        <q-btn
          label="Create"
          color="positive"
          class="fit"
          unelevated
          no-wrap
          icon="add"
          @click="categoryStore.create"
        />
      </div>
    </div>

    <q-table
      :columns="columns"
      :rows="categoryStore.index"
      row-key="id"
      :rows-per-page-options="[10, 20, 30, 40, 50]"
      v-model:pagination="categoryStore.pagination"
      :loading="loading"
      class="q-mt-sm"
      @request="onRequest"
    >
      <template v-slot:header-cell-id="props">
        <q-th :props="props">
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

      <template #top-row>
        <template v-if="categoryStore.created.size > 0">
          <CategoryRow
            v-for="created in categoryStore.created.values()"
            :key="created.$id?.toString()"
            :category="created"
            @deleted="categoryStore.created.delete(created.$id as string)"
          />
        </template>
      </template>

      <template v-slot:body="props">
        <q-tr :props="props">
          <q-td key="id" :props="props" auto-width>
            {{ props.row.id }}
          </q-td>

          <q-td key="category_name" :props="props">
            {{ props.row.category_name }}
          </q-td>

          <q-td key="parent_category" :props="props">
            {{ props.row.parent_category?.category_name }}
          </q-td>

          <q-td key="action" auto-width>
            <q-btn
              flat
              dense
              round
              icon="mdi-delete-outline"
              color="negative"
            />
          </q-td>
        </q-tr>
      </template>
    </q-table>
  </div>
</template>

<script setup lang="ts">
import { QTableColumn, QTableProps } from 'quasar';
import { useCategoryStore } from 'src/stores/category';
import { onMounted, onUnmounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import CategoryRow from 'components/Categories/CategoryRow.vue';

const columns: QTableColumn[] = [
  {
    name: 'id',
    label: '#Id',
    field: 'id',
    align: 'left',
  },
  {
    name: 'category_name',
    label: 'Category Name',
    field: 'category_name',
    align: 'left',
  },
  {
    name: 'parent_category',
    label: 'Parent Category',
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

type Query = {
  page?: number;
  per_page?: number;
  search?: string;
};

const categoryStore = useCategoryStore()();
const router = useRouter();
const filter = ref(categoryStore.filter.category_name as string);
const loading = ref(false);

onMounted(() => {
  categoryStore.created = new Map();
});

onUnmounted(() => {
  delete categoryStore.filter.category_name;
});

const onRequest: QTableProps['onRequest'] = async ({ pagination }) => {
  await fetchIndex(pagination.page, pagination.rowsPerPage);
};

const fetchIndex = async (page = 1, perPage = 10) => {
  if (loading.value) return;

  loading.value = true;
  categoryStore.filter.category_name = filter.value;
  if (!filter.value) delete categoryStore.filter.category_name;

  categoryStore
    .fetchIndex(page, perPage, true)
    .then(() => {
      handleRoutePush();
    })
    .finally(() => (loading.value = false));
};

//push the pagination and filter in the URL
const handleRoutePush = () => {
  const query: Query = {
    page: categoryStore.pagination?.page,
    per_page: categoryStore.pagination?.rowsPerPage,
  };

  if (filter.value) query.search = filter.value;

  router.push({ query });
};
</script>
