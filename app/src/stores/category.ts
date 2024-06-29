import { defineStore } from 'pinia';
import { Ref, ref } from 'vue';
import { api } from 'boot/axios';
import { Notify, QTableProps } from 'quasar';
import { Meta } from 'src/types/meta';

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
    const indexMeta: Ref<Meta> = ref(<Meta>{});
    const created: Ref<Map<string, CategoryObject>> = ref(new Map());
    const pagination: Ref<QTableProps['pagination']> = ref({
      page: 1,
      rowsPerPage: 10,
    });

    const fetchIndex = async (page = 1, perPage = 10, force = false) => {
      if (index.value.length === 0 || force) {
        const urlParams = new URLSearchParams(
          Object.entries(filter.value).filter((param) => param[1] !== undefined)
        );

        return api
          .get(`categories?${urlParams}`, {
            params: { page, per_page: perPage },
          })
          .then((response) => {
            index.value = response.data.data;
            indexMeta.value = response.data.meta;
            updatePaginationMeta();
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

    const updatePaginationMeta = () => {
      if (!pagination.value || index.value.length === 0) return;
      pagination.value.page = indexMeta.value.current_page;
      pagination.value.rowsPerPage = indexMeta.value.per_page;
      pagination.value.rowsNumber = indexMeta.value.total;
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

    return {
      index,
      indexMeta,
      pagination,
      created,
      filter,
      fetchIndex,
      create,
    };
  });
