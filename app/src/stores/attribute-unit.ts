import { defineStore } from 'pinia';
import { Ref, ref } from 'vue';
import { api } from 'boot/axios';
import { Notify, QSelectOption } from 'quasar';

export type AttributeUnitObject = {
  $id: string | null;
  id: number | null;
  attribute_unit_name: string | null;
  attribute_unit_short_name: string | null;
};

type Filter = {
  attribute_unit_name?: string;
};

export const useAttributeUnitStore = defineStore('attribute-unit', () => {
  const index: Ref<AttributeUnitObject[]> = ref([]);
  const created: Ref<Map<string, AttributeUnitObject>> = ref(new Map());
  const filter: Ref<Filter> = ref({});
  const options: Ref<QSelectOption<number>[]> = ref([]);

  const fetchIndex = async (force = false) => {
    if (index.value.length === 0 || force) {
      const urlParams = new URLSearchParams(
        Object.entries(filter.value).filter((param) => !!param[1])
      );

      return api
        .get(`attribute-units?${urlParams}`)
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

  const fetchOptions = async (force = false) => {
    if (options.value.length === 0 || force) {
      return api
        .get('attribute-units/options')
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

  const create = (prefill: AttributeUnitObject = <AttributeUnitObject>{}) => {
    const id = self.crypto.randomUUID();

    created.value.set(id, {
      ...{
        $id: id,
        attribute_unit_name: null,
        attribute_unit_short_name: null,
      },
      ...prefill,
    });

    return id;
  };

  const store = async (id: string) => {
    const attributeUnit = created.value.get(id);
    if (!attributeUnit) throw new Error('Invalid attribute unit key');

    return api
      .post('attribute-units', attributeUnit)
      .then(async (response) => {
        created.value.delete(id);
        await Promise.all([fetchIndex(true), fetchOptions(true)]);
        Notify.create({
          message: 'New attribute unit created',
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
    const attributeUnit = index.value.find((unit) => unit.id === id);
    if (!attributeUnit) throw new Error('Invalid attribute unit id');

    return api
      .put(`attribute-units/${id}`, attributeUnit)
      .then(async (response) => {
        await Promise.all([fetchIndex(true), fetchOptions(true)]);
        Notify.create({
          message: 'Attribute unit updated',
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
      .delete(`attribute-units/${id}`)
      .then(async (response) => {
        await Promise.all([fetchIndex(true), fetchOptions(true)]);
        Notify.create({
          message: 'Attribute unit deleted',
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
    created,
    filter,
    fetchIndex,
    fetchOptions,
    create,
    store,
    update,
    destroy,
  };
});
