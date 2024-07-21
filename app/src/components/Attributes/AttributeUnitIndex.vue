<template>
  <q-table
    :columns="columns"
    :rows="attributeUnitStore.index"
    row-key="id"
    :rows-per-page-options="[0]"
    :loading="loading"
    class="q-mt-sm"
  >
    <template v-slot:header-cell-id="props">
      <q-th :props="props">
        {{ props.col.label }}
      </q-th>
    </template>

    <template v-slot:header-cell-attribute_unit_name="props">
      <q-th :props="props">
        {{ props.col.label }}
      </q-th>
    </template>

    <template v-slot:header-cell-attribute_unit_short_name="props">
      <q-th :props="props">
        {{ props.col.label }}
      </q-th>
    </template>

    <template #top-row>
      <template v-if="attributeUnitStore.created.size > 0">
        <AttributeUnitRowCreate
          v-for="created in attributeUnitStore.created.values()"
          :key="created.$id?.toString()"
          :attribute-unit="created"
          :options="attributeUnitStore.options"
          :loading="loading"
          @deleted="attributeUnitStore.created.delete(created.$id as string)"
          @stored="handleStored"
        />
      </template>
    </template>

    <template v-slot:body="props">
      <AttributeUnitRowEdit
        v-if="!refresh"
        :body-props="props"
        :options="attributeUnitStore.options"
        :loading="loading"
        :key="props.row.id"
        @deleted="handleDeleted"
        @updated="handleUpdated"
      />
    </template>
  </q-table>

  <!-- place QPageSticky at end of page -->
  <q-page-sticky expand position="top" class="bg-white q-pa-sm">
    <q-toolbar class="row q-gutter-sm">
      <div class="col col-md-4">
        <q-input
          filled
          v-model="filter"
          label="Search Unit"
          clearable
          dense
          @keydown.enter="fetchIndex"
          @clear="fetchIndex"
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
          @click="fetchIndex"
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
          @click="attributeUnitStore.create"
        />
      </div>
    </q-toolbar>
  </q-page-sticky>
</template>

<script setup lang="ts">
import { QTableColumn, useQuasar } from 'quasar';
import { useAttributeUnitStore } from 'src/stores/attribute-unit';
import { nextTick, onMounted, onUnmounted, ref } from 'vue';
import AttributeUnitRowCreate from 'components/Attributes/AttributeUnitRowCreate.vue';
import AttributeUnitRowEdit from 'components/Attributes/AttributeUnitRowEdit.vue';
import { useRouter } from 'vue-router';

const columns: QTableColumn[] = [
  {
    name: 'id',
    label: '#Id',
    field: 'id',
    align: 'left',
  },
  {
    name: 'attribute_unit_name',
    label: 'Attribute Unit Name',
    field: 'attribute_unit_name',
    align: 'left',
  },
  {
    name: 'attribute_unit_short_name',
    label: 'Attribute Unit Short Name',
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
  search?: string;
};

const $q = useQuasar();
const attributeUnitStore = useAttributeUnitStore();
const router = useRouter();
const filter = ref(attributeUnitStore.filter.attribute_unit_name);
const loading = ref(false);
const refresh = ref(false);

onMounted(() => {
  attributeUnitStore.created = new Map();
});

onUnmounted(() => {
  delete attributeUnitStore.filter.attribute_unit_name;
});

const refreshRow = async () => {
  refresh.value = true;
  await nextTick();
  refresh.value = false;
};

const fetchIndex = async () => {
  attributeUnitStore.filter.attribute_unit_name = filter.value;
  await attributeUnitStore.fetchIndex(true);
  handleRoutePush();
};

const handleStored = async (id: string) => {
  loading.value = true;
  attributeUnitStore
    .store(id)
    .then(async () => {
      await refreshRow();
    })
    .finally(() => (loading.value = false));
};

const handleUpdated = async (id: number) => {
  loading.value = true;
  attributeUnitStore
    .update(id)
    .then(async () => {
      await refreshRow();
    })
    .finally(() => (loading.value = false));
};

const handleDeleted = (id: number) => {
  $q.dialog({
    title: 'Confirm',
    message: 'Do you want to remove this unit?',
    cancel: true,
  }).onOk(() => {
    loading.value = true;
    attributeUnitStore.destroy(id).finally(() => (loading.value = false));
  });
};

//push the pagination and filter in the URL
const handleRoutePush = () => {
  const query: Query = {};

  if (filter.value) query.search = filter.value;

  router.push({ query });
};
</script>
