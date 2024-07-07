import { defineStore } from 'pinia';
import { Ref, ref } from 'vue';
import { api } from 'boot/axios';
import { Notify, QSelectOption, QTableProps } from 'quasar';

export type CategoryObject = {
  $id: string | null;
  id: number | null;
  category_name: string | null;
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
    const created: Ref<Map<string, CategoryObject>> = ref(new Map());
    const options: Ref<QSelectOption<number>[]> = ref([]);
    const pagination: Ref<QTableProps['pagination']> = ref({
      page: 1,
      rowsPerPage: 10,
    });

    const fetchIndex = async (page = 1, perPage = 10, force = false) => {
      if (index.value.length === 0 || force) {
        const urlParams = new URLSearchParams(
          Object.entries(filter.value).filter((param) => param[1])
        );

        return api
          .get(`categories?${urlParams}`, {
            params: { page, per_page: perPage },
          })
          .then((response) => {
            index.value = response.data.data;
            if (pagination.value) {
              pagination.value.page = response.data.meta.current_page;
              pagination.value.rowsPerPage = response.data.meta.per_page;
              pagination.value.rowsNumber = response.data.meta.total;
            }
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

    const fetchOptions = async (force = false) => {
      if (options.value.length === 0 || force) {
        return api
          .get('categories/options')
          .then((response) => {
            options.value = response.data;
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

    const create = (prefill: CategoryObject = <CategoryObject>{}) => {
      const id = self.crypto.randomUUID();

      created.value.set(id, {
        ...{
          $id: id,
          id: null,
          category_name: null,
          parent_category: null,
          parent_category_id: null,
          sub_categories: [],
        },
        ...prefill,
      });

      return id;
    };

    const store = async (id: string) => {
      const category = created.value.get(id);
      if (!category) throw new Error('Invalid category key');

      return api
        .post('categories', category)
        .then((response) => {
          Notify.create({
            message: 'New category created',
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
        .delete(`categories/${id}`)
        .then((response) => {
          Notify.create({
            message: 'Category deleted',
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
      options,
      pagination,
      created,
      filter,
      fetchIndex,
      fetchOptions,
      create,
      store,
      destroy,
    };
  });
