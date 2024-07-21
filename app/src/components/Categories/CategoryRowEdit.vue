<template>
  <q-tr :props="bodyProps">
    <q-td :props="bodyProps" key="id" auto-width>
      <q-chip
        :label="categoryRef.id?.toString()"
        icon="mdi-identifier"
        :ripple="false"
      />
    </q-td>

    <q-td :props="bodyProps" key="category_name">
      <q-input
        v-model="categoryRef.category_name"
        dense
        borderless
        lazy-rules
        hide-bottom-space
      />
    </q-td>

    <q-td :props="bodyProps" key="parent_category">
      <SelectOptions
        v-model="categoryRef.parent_category_id"
        :options="options"
        dense
        borderless
        clearable
        :disable-options="[categoryRef.id as number]"
      />
    </q-td>

    <q-td :props="bodyProps" key="action" auto-width>
      <q-btn
        flat
        dense
        round
        icon="mdi-content-save-outline"
        color="positive"
        :disable="loading || !isDirty"
        @click="handleUpdated(categoryRef.id as number)"
      />
      <q-btn
        flat
        dense
        round
        icon="mdi-delete-outline"
        color="negative"
        :disable="loading"
        @click="handleDeleted(categoryRef.id as number)"
      />
    </q-td>
  </q-tr>
</template>

<script setup lang="ts">
import { QSelectOption, QTableSlots } from 'quasar';
import { computed, Ref, toRef } from 'vue';
import SelectOptions from 'components/UI/SelectOptions.vue';
import { CategoryObject } from 'src/stores/category';

const emit = defineEmits<{
  updated: [id: number];
  deleted: [id: number];
}>();

const props = defineProps<{
  bodyProps: Parameters<QTableSlots['body']>['0'];
  options: QSelectOption<number>[];
  loading: boolean;
}>();

const categoryRef: Ref<CategoryObject> = toRef(props.bodyProps, 'row');
const original = { ...categoryRef.value };

const isDirty = computed(() => {
  return JSON.stringify(categoryRef.value) !== JSON.stringify(original);
});

const handleUpdated = (id: number) => {
  if (!isDirty.value) return;
  emit('updated', id);
};

const handleDeleted = (id: number) => {
  emit('deleted', id);
};
</script>
