<template>
  <q-layout view="hHh LpR fFf">

    <q-header bordered class="bg-primary text-white">
      <q-toolbar>
        <q-btn dense flat round icon="menu" @click="toggleLeftDrawer" />

        <q-toolbar-title>
          <q-avatar>
            <img src="https://cdn.quasar.dev/logo-v2/svg/logo-mono-white.svg">
          </q-avatar>
          E-Commerce
        </q-toolbar-title>

        <q-btn flat round dense icon="mdi-logout" @click="handleLogout">
          <q-tooltip>Logout</q-tooltip>
        </q-btn>
      </q-toolbar>
    </q-header>

    <q-drawer show-if-above v-model="leftDrawerOpen" side="left" bordered>
      <q-scroll-area class="fit">
        <q-list>
          <!-- DATA ENTRY -->
          <q-expansion-item group="group" dense v-model="dataEntryMenu">
            <template #header="scope">
              <q-item class="q-pa-none full-width">
                <q-item-section avatar>
                  <q-icon :color="scope.expanded ? 'primary' : ''" name="mdi-database-plus-outline" />
                </q-item-section>

                <q-item-section :class="{ 'text-primary': scope.expanded }">Data Entry</q-item-section>
              </q-item>
            </template>

            <q-item :inset-level="1" clickable v-ripple to="/admin/categories" active-class="bg-blue-1">
              <q-item-section avatar>
                <q-icon color="primary" name="mdi-shape-outline" />
              </q-item-section>

              <q-item-section class="text-primary">Categories</q-item-section>
            </q-item>

            <q-item :inset-level="1" clickable v-ripple to="/admin/products" active-class="bg-blue-1">
              <q-item-section avatar>
                <q-icon color="primary" name="mdi-sitemap-outline" />
              </q-item-section>

              <q-item-section class="text-primary">Products</q-item-section>
            </q-item>
          </q-expansion-item>
        </q-list>
      </q-scroll-area>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>

  </q-layout>
</template>

<script setup lang="ts">
import { useQuasar } from 'quasar';
import { useAuthStore } from 'src/stores/auth';
import { onMounted, ref } from 'vue'
import { useRoute } from 'vue-router';

const $q = useQuasar()
const authStore = useAuthStore()
const route = useRoute()
const leftDrawerOpen = ref(false)
const dataEntryMenu = ref(false)

onMounted(() => {
  dataEntryMenu.value = route.path == '/admin/categories' || route.path == '/admin/products'
})

const toggleLeftDrawer = () => leftDrawerOpen.value = !leftDrawerOpen.value

const handleLogout = () => {
  $q.dialog({
    title: 'Confirm',
    message: 'Do you want to logout?',
    cancel: true,
  }).onOk(() => {
    authStore.logout().finally(() => {
      window.location.reload();
    })
  })
}
</script>