import { defineStore } from 'pinia';
import { Ref, ref } from 'vue';
import { api } from 'boot/axios';
import { Notify } from 'quasar';

export type AttributeCategoryObject = {
  $id: string | null;
  id: number | null;
  attribute_category_name: string | null;
  priority: number | null;
};

type Filter = {
  attribute_category_name?: string;
};

export const useAttributeCategoryStore = defineStore(
  'attribute-category',
  () => {
    const index: Ref<AttributeCategoryObject[]> = ref([]);
    const created: Ref<Map<string, AttributeCategoryObject>> = ref(new Map());
    const filter: Ref<Filter> = ref({});

    const fetchIndex = async (force = false) => {
      if (index.value.length === 0 || force) {
        const urlParams = new URLSearchParams(
          Object.entries(filter.value).filter((param) => !!param[1])
        );

        return api
          .get(`attribute-categories?${urlParams}`)
          .then((response) => {
            index.value = response.data;
            return response;
          })
          .catch((error) => {
            Notify.create({
              message: error.response?.data.message,
              type: 'negative',
              progress: true,
              position: 'top-right',
            });
            throw error;
          });
      }
    };

    const create = (
      prefill: AttributeCategoryObject = <AttributeCategoryObject>{}
    ) => {
      const id = self.crypto.randomUUID();

      created.value.set(id, {
        ...{
          $id: id,
          attribute_category_name: null,
          priority: null,
        },
        ...prefill,
      });

      return id;
    };

    const store = async (id: string) => {
      const attributeCategory = created.value.get(id);
      if (!attributeCategory) throw new Error('Invalid attribute category key');

      return api
        .post('attribute-categories', attributeCategory)
        .then(async (response) => {
          created.value.delete(id);
          await fetchIndex(true);
          Notify.create({
            message: 'New attribute category created',
            type: 'positive',
            progress: true,
            position: 'top-right',
          });
          return response;
        })
        .catch((error) => {
          Notify.create({
            message: error.response?.data.message,
            type: 'negative',
            progress: true,
            position: 'top-right',
          });
          throw error;
        });
    };

    const update = async (id: number) => {
      const attributeCategory = index.value.find((unit) => unit.id === id);
      if (!attributeCategory) throw new Error('Invalid attribute category id');

      return api
        .put(`attribute-categories/${id}`, attributeCategory)
        .then(async (response) => {
          await fetchIndex(true);
          Notify.create({
            message: 'Attribute category updated',
            type: 'positive',
            progress: true,
            position: 'top-right',
          });
          return response;
        })
        .catch((error) => {
          Notify.create({
            message: error.response?.data.message,
            type: 'negative',
            progress: true,
            position: 'top-right',
          });
          throw error;
        });
    };

    const destroy = async (id: number) => {
      return api
        .delete(`attribute-categories/${id}`)
        .then(async (response) => {
          await fetchIndex(true);
          Notify.create({
            message: 'Attribute category deleted',
            type: 'positive',
            progress: true,
            position: 'top-right',
          });
          return response;
        })
        .catch((error) => {
          Notify.create({
            message: error.response?.data.message,
            type: 'negative',
            progress: true,
            position: 'top-right',
          });
          throw error;
        });
    };

    return {
      index,
      created,
      filter,
      fetchIndex,
      create,
      store,
      update,
      destroy,
    };
  }
);
