<template>
  <q-page-sticky expand position="top" class="bg-white q-pa-sm">
    <q-toolbar class="row q-gutter-sm">
      <div class="col col-md-4">
        <q-input
          filled
          v-model="filter"
          label="Search Product"
          clearable
          dense
        />
      </div>

      <div class="col-auto">
        <q-btn
          label="Search"
          color="primary"
          class="fit"
          unelevated
          no-wrap
          icon="search"
        />
      </div>

      <div class="col-auto">
        <q-btn
          label="Create"
          color="positive"
          class="fit"
          unelevated
          no-wrap
          icon="add"
        />
      </div>
    </q-toolbar>
  </q-page-sticky>
</template>

<script setup lang="ts">
import { ref } from 'vue';

const filter = ref('');
</script>
