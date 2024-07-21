<template>
  <q-tr :props="bodyProps">
    <q-td :props="bodyProps" key="id" auto-width>
      <q-chip
        :label="attributeUnitRef.id?.toString()"
        icon="mdi-identifier"
        :ripple="false"
      />
    </q-td>

    <q-td :props="bodyProps" key="attribute_unit_name">
      <q-input
        v-model="attributeUnitRef.attribute_unit_name"
        dense
        borderless
        lazy-rules
        hide-bottom-space
      />
    </q-td>

    <q-td :props="bodyProps" key="attribute_unit_short_name">
      <q-input
        v-model="attributeUnitRef.attribute_unit_short_name"
        dense
        borderless
        lazy-rules
        hide-bottom-space
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
        @click="handleUpdated(attributeUnitRef.id as number)"
      />
      <q-btn
        flat
        dense
        round
        icon="mdi-delete-outline"
        color="negative"
        :disable="loading"
        @click="handleDeleted(attributeUnitRef.id as number)"
      />
    </q-td>
  </q-tr>
</template>

<script setup lang="ts">
import { QSelectOption, QTableSlots } from 'quasar';
import { computed, Ref, toRef } from 'vue';
import { AttributeUnitObject } from 'src/stores/attribute-unit';

const emit = defineEmits<{
  updated: [id: number];
  deleted: [id: number];
}>();

const props = defineProps<{
  bodyProps: Parameters<QTableSlots['body']>['0'];
  options: QSelectOption<number>[];
  loading: boolean;
}>();

const attributeUnitRef: Ref<AttributeUnitObject> = toRef(
  props.bodyProps,
  'row'
);
const original = { ...attributeUnitRef.value };

const isDirty = computed(() => {
  return JSON.stringify(attributeUnitRef.value) !== JSON.stringify(original);
});

const handleUpdated = (id: number) => {
  if (!isDirty.value) return;
  emit('updated', id);
};

const handleDeleted = (id: number) => {
  emit('deleted', id);
};
</script>
