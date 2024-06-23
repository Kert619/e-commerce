<template>
  <router-view />
</template>

<script setup lang="ts">
import { Role, useAuthStore } from 'stores/auth'

defineOptions({
  async preFetch ({ store, currentRoute, redirect }) {
    const authStore = useAuthStore(store)

    try {
      await authStore.getUser()
    } catch (error) {
    } finally {
      if (!authStore.user) {
        if (currentRoute.meta.role == Role.Admin && currentRoute.path != '/admin/login') redirect({ path: '/admin/login' })
      }

      if (authStore.user) {
        if (currentRoute.meta.role == Role.AdminGuest && authStore.user.role == Role.Admin) redirect({ path: '/admin' })
      }
    }
  }
})
</script>
