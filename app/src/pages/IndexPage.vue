<template>
  <q-page class="row items-center justify-evenly">
    <h1>Hello World</h1>
    <pre>{{ authStore.user }}</pre>
  </q-page>
</template>

<script setup lang="ts">
import { useAuthStore } from 'src/stores/auth'
const authStore = useAuthStore()
</script>
