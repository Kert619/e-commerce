<template>
  <router-view />
</template>

<script setup lang="ts">
import { useAuthStore } from 'stores/auth'

defineOptions({
  async preFetch ({ store, currentRoute, redirect }) {
    const authStore = useAuthStore(store)
    await authStore.getUser()

    if (!authStore.user && currentRoute.path != '/admin/login') redirect({ path: '/admin/login' })
    if (authStore.user && currentRoute.path == '/admin/login') redirect({ path: '/admin' })
  }
})
</script>
