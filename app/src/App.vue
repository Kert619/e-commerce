<template>
  <router-view />
</template>

<script setup lang="ts">
import { Role, useAuthStore } from 'stores/auth'

defineOptions({
  async preFetch ({ store, currentRoute, redirect }) {
    const authStore = useAuthStore(store)

    await authStore.getUser()

    if (!authStore.user) {
      if (currentRoute.meta.role == Role.Admin && currentRoute.path != '/admin/login') redirect({ path: '/admin/login' })
    }

    if (authStore.user) {
      if (currentRoute.meta.role == Role.AdminGuest) redirect({ path: '/admin' })
    }
  }
})
</script>
