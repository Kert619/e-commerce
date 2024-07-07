<template>
  <q-select
    v-model="model"
    :options="categoryOptions"
    use-input
    input-debounce="0"
    @filter="filterFn"
    emit-value
    map-options
  >
    <template #option="scope">
      <q-item
        v-bind="scope.itemProps"
        :disable="disableOption(scope.opt.value)"
      >
        <q-item-section>
          {{ scope.opt.label }}
        </q-item-section>
      </q-item>
    </template>
  </q-select>
</template>

<script setup lang="ts">
import { QSelectOption } from 'quasar';
import { ref } from 'vue';

const props = defineProps<{
  options: QSelectOption<number>[];
  disableOptions?: number[];
}>();

const categoryOptions = ref(props.options);

const model = defineModel<number | null>();

const filterFn = (
  val: string,
  update: (arg0: { (): void; (): void }) => void
) => {
  if (val === '') {
    update(() => {
      categoryOptions.value = props.options;
    });
    return;
  }

  update(() => {
    const needle = val.toLowerCase();
    categoryOptions.value = props.options.filter(
      (v) => v.label.toLowerCase().indexOf(needle) > -1
    );
  });
};

const disableOption = (value: number) => {
  return props.disableOptions && props.disableOptions.includes(value);
};
</script>
