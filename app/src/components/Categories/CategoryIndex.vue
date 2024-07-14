<template>
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
        <CategoryRowCreate
          v-for="created in categoryStore.created.values()"
          :key="created.$id?.toString()"
          :category="created"
          :options="categoryStore.options"
          :loading="loading"
          @deleted="categoryStore.created.delete(created.$id as string)"
          @stored="handleStored"
        />
      </template>
    </template>

    <template v-slot:body="props">
      <CategoryRowEdit
        v-if="!refresh"
        :body-props="props"
        :options="categoryStore.options"
        :loading="loading"
        :key="props.row.id"
        @deleted="handleDeleted"
        @updated="handleUpdated"
      />
    </template>
  </q-table>

  <q-page-sticky expand position="top" class="bg-white q-pa-sm">
    <q-toolbar class="row q-gutter-sm">
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
    </q-toolbar>
  </q-page-sticky>
</template>

<script setup lang="ts">
import { QTableColumn, QTableProps, useQuasar } from 'quasar';
import { useCategoryStore } from 'src/stores/category';
import { nextTick, onMounted, onUnmounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import CategoryRowCreate from 'components/Categories/CategoryRowCreate.vue';
import CategoryRowEdit from 'components/Categories/CategoryRowEdit.vue';

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

const $q = useQuasar();
const categoryStore = useCategoryStore()();
const router = useRouter();
const filter = ref(categoryStore.filter.category_name as string);
const loading = ref(false);
const refresh = ref(false);

onMounted(async () => {
  categoryStore.created = new Map();
});

onUnmounted(() => {
  delete categoryStore.filter.category_name;
});

const refreshRow = async () => {
  refresh.value = true;
  await nextTick();
  refresh.value = false;
};

const onRequest: QTableProps['onRequest'] = async ({ pagination }) => {
  await fetchIndex(pagination.page, pagination.rowsPerPage);
};

const fetchIndex = async (page = 1, perPage = 10) => {
  if (loading.value) return;

  loading.value = true;

  categoryStore.filter.category_name = filter.value;

  categoryStore
    .fetchIndex(page, perPage, true)
    .then(() => {
      handleRoutePush();
    })
    .finally(() => (loading.value = false));
};

const handleStored = async (id: string) => {
  loading.value = true;
  categoryStore.store(id).finally(() => (loading.value = false));
};

const handleUpdated = async (id: number) => {
  loading.value = true;
  categoryStore
    .update(id)
    .then(async () => {
      await refreshRow();
    })
    .finally(() => (loading.value = false));
};

const handleDeleted = (id: number) => {
  $q.dialog({
    title: 'Confirm',
    message: 'Do you want to remove this category?',
    cancel: true,
  }).onOk(() => {
    loading.value = true;
    categoryStore.destroy(id).finally(() => (loading.value = false));
  });
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
