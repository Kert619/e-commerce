<template>
  <q-tr>
    <q-td auto-width>
      <q-chip label="New" icon="mdi-identifier" :ripple="false" />
    </q-td>
    <q-td>
      <q-input
        v-model="attributeUnitRef.attribute_unit_name"
        dense
        borderless
        lazy-rules
        :rules="attributeNameRules"
        hide-bottom-space
      />
    </q-td>
    <q-td>
      <q-input
        v-model="attributeUnitRef.attribute_unit_short_name"
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
import { AttributeUnitObject } from 'src/stores/attribute-unit';
import { computed, toRef } from 'vue';
import { useValidation } from 'src/composables/useValidation';

const emit = defineEmits<{
  stored: [id: string];
  deleted: [id: string];
}>();

const props = defineProps<{
  attributeUnit: AttributeUnitObject;
  options: QSelectOption<number>[];
  loading: boolean;
}>();

const attributeUnitRef = toRef(props.attributeUnit);
const { required } = useValidation();

const attributeNameRules = [(val: string) => required(val)];

const disableSave = computed(() => {
  if (
    !attributeUnitRef.value.attribute_unit_name ||
    !attributeUnitRef.value.attribute_unit_short_name
  )
    return true;

  return false;
});

const handleDelete = () => {
  emit('deleted', attributeUnitRef.value.$id as string);
};

const handleSave = () => {
  emit('stored', attributeUnitRef.value.$id as string);
};
</script>
