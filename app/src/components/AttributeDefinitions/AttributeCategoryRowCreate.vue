<template>
  <q-tr>
    <q-td colspan="2">
      <q-input
        v-model="attributeCategoryRef.attribute_category_name"
        dense
        borderless
        lazy-rules
        :rules="attributeNameRules"
        hide-bottom-space
      />
    </q-td>
    <q-td colspan="2">
      <q-input
        type="number"
        v-model.number="attributeCategoryRef.priority"
        dense
        borderless
        lazy-rules
        :rules="attributeNameRules"
        hide-bottom-space
      />
    </q-td>
    <q-td auto-width>
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
import { toRef } from 'vue';
import { useValidation } from 'src/composables/useValidation';
import { AttributeCategoryObject } from 'src/stores/attribute-category';

const emit = defineEmits<{
  deleted: [id: string];
}>();

const props = defineProps<{
  attributeCategory: AttributeCategoryObject;
  loading?: boolean;
}>();

const attributeCategoryRef = toRef(props.attributeCategory);
const { required } = useValidation();

const attributeNameRules = [(val: string) => required(val)];

const handleDelete = () => {
  emit('deleted', attributeCategoryRef.value.$id as string);
};
</script>
