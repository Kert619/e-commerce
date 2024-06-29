<template>
  <q-tr>
    <q-td>
      <q-chip label="New" icon="mdi-plus" :ripple="false" />
    </q-td>
    <q-td>
      <q-input v-model="categoryRef.category_name" dense borderless />
    </q-td>
    <q-td>
      <q-input v-model="categoryRef.category_name" dense borderless />
    </q-td>
    <q-td auto-width>
      <q-btn
        flat
        dense
        round
        icon="mdi-delete-outline"
        color="negative"
        @click="handleDelete"
      />
    </q-td>
  </q-tr>
</template>

<script setup lang="ts">
import { CategoryObject } from 'src/stores/category';
import { toRef } from 'vue';

const emit = defineEmits<{
  deleted: [id: string];
}>();

const props = defineProps<{
  category: CategoryObject;
}>();

const categoryRef = toRef(props.category);

const handleDelete = () => {
  emit('deleted', categoryRef.value.$id as string);
};
</script>
