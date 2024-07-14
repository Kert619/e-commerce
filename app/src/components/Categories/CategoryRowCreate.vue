<template>
  <q-tr>
    <q-td>
      <q-chip label="New" icon="mdi-identifier" :ripple="false" />
    </q-td>
    <q-td>
      <q-input
        v-model="categoryRef.category_name"
        dense
        borderless
        lazy-rules
        :rules="categoryNameRules"
        hide-bottom-space
      />
    </q-td>
    <q-td>
      <SelectOptions
        v-model="categoryRef.parent_category_id"
        :options="options"
        dense
        borderless
        clearable
      />
    </q-td>
    <q-td auto-width>
      <q-btn
        flat
        dense
        round
        icon="mdi-content-save-outline"
        color="positive"
        @click="handleSave"
        :disable="loading || disableSave"
      />
      <q-btn
        flat
        dense
        round
        icon="mdi-delete-outline"
        color="negative"
        @click="handleDelete"
        :disable="loading"
      />
    </q-td>
  </q-tr>
</template>

<script setup lang="ts">
import { QSelectOption } from 'quasar';
import { CategoryObject } from 'src/stores/category';
import { computed, toRef } from 'vue';
import SelectOptions from 'components/UI/SelectOptions.vue';
import { useValidation } from 'src/composables/useValidation';

const emit = defineEmits<{
  stored: [id: string];
  deleted: [id: string];
}>();

const props = defineProps<{
  category: CategoryObject;
  options: QSelectOption<number>[];
  loading: boolean;
}>();

const categoryRef = toRef(props.category);
const { required } = useValidation();

const categoryNameRules = [(val: string) => required(val)];

const disableSave = computed(() => {
  if (!categoryRef.value.category_name) return true;

  return false;
});

const handleDelete = () => {
  emit('deleted', categoryRef.value.$id as string);
};

const handleSave = () => {
  emit('stored', categoryRef.value.$id as string);
};
</script>
