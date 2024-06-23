import { defineStore } from 'pinia';
import { Ref, ref } from 'vue';
import { api } from 'boot/axios';
import { Notify } from 'quasar';

export type CategoryObject = {
  id: number;
  category_name: string;
  parent_category_id: number | null;
  parent_category: CategoryObject | null;
  sub_categories: CategoryObject[];
};

type filter = {
  category_name?: string;
};

export const useCategoryStore = (categoryId = 0) =>
  defineStore(`category/${categoryId}`, () => {
    const filter: Ref<filter> = ref({});
    const index: Ref<CategoryObject[]> = ref([]);

    const fetchIndex = async () => {
      const urlParams = new URLSearchParams(
        Object.entries(filter.value).filter((param) => param[1] !== undefined)
      );

      return api
        .get(`categories?${urlParams}`)
        .then((response) => {
          index.value = response.data.data;
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
      fetchIndex,
    };
  });
