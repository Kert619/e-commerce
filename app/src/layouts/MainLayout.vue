<template>
  <q-layout view="hHh LpR fFf">
    <q-header bordered class="bg-primary text-white">
      <q-toolbar>
        <q-btn dense flat round icon="menu" @click="toggleLeftDrawer" />

        <q-toolbar-title>
          <q-avatar>
            <img src="https://cdn.quasar.dev/logo-v2/svg/logo-mono-white.svg" />
          </q-avatar>
          E-Commerce
        </q-toolbar-title>

        <q-btn-dropdown
          auto-close
          split
          flat
          :label="authStore.user?.name"
          :loading="loading"
        >
          <q-list dense separator>
            <q-item clickable>
              <q-item-section avatar>
                <q-avatar icon="mdi-account-outline" />
              </q-item-section>

              <q-item-section> Profile </q-item-section>
            </q-item>

            <q-item clickable @click="handleLogout">
              <q-item-section avatar>
                <q-avatar icon="mdi-logout" />
              </q-item-section>

              <q-item-section> Logout </q-item-section>
            </q-item>
          </q-list>
        </q-btn-dropdown>
      </q-toolbar>
    </q-header>

    <q-drawer show-if-above v-model="leftDrawerOpen" side="left" bordered>
      <q-scroll-area class="fit">
        <q-list>
          <!-- PRODUCT MANAGEMENT -->
          <q-expansion-item dense v-model="menu.productManagement">
            <template #header>
              <q-item class="q-pa-none full-width">
                <q-item-section avatar>
                  <q-icon color="primary" name="mdi-database-plus-outline" />
                </q-item-section>

                <q-item-section class="text-primary"
                  >Product Management</q-item-section
                >
              </q-item>
            </template>

            <q-item
              :inset-level="1"
              clickable
              v-ripple
              to="/admin/categories"
              active-class="bg-blue-1"
            >
              <q-item-section avatar>
                <q-icon color="primary" name="mdi-shape-outline" />
              </q-item-section>

              <q-item-section class="text-primary">Categories</q-item-section>
            </q-item>

            <q-item
              :inset-level="1"
              clickable
              v-ripple
              to="/admin/products"
              active-class="bg-blue-1"
            >
              <q-item-section avatar>
                <q-icon color="primary" name="mdi-sitemap-outline" />
              </q-item-section>

              <q-item-section class="text-primary">Products</q-item-section>
            </q-item>
          </q-expansion-item>

          <!-- PRODUCT ATTRIBUTES -->
          <q-expansion-item dense v-model="menu.productAttributes">
            <template #header>
              <q-item class="q-pa-none full-width">
                <q-item-section avatar>
                  <q-icon color="primary" name="mdi-database-plus-outline" />
                </q-item-section>

                <q-item-section class="text-primary"
                  >Product Attributes</q-item-section
                >
              </q-item>
            </template>

            <q-item
              :inset-level="1"
              clickable
              v-ripple
              to="/admin/attributes"
              active-class="bg-blue-1"
            >
              <q-item-section avatar>
                <q-icon color="primary" name="mdi-shape-outline" />
              </q-item-section>

              <q-item-section class="text-primary">Attributes</q-item-section>
            </q-item>

            <q-item
              :inset-level="1"
              clickable
              v-ripple
              to="/admin/units"
              active-class="bg-blue-1"
            >
              <q-item-section avatar>
                <q-icon color="primary" name="mdi-shape-outline" />
              </q-item-section>

              <q-item-section class="text-primary">Units</q-item-section>
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
import { useAuthStore } from 'src/stores/auth';
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';

const authStore = useAuthStore();
const route = useRoute();
const leftDrawerOpen = ref(false);
const menu = ref({
  productManagement: false,
  productAttributes: false,
});
const loading = ref(false);

onMounted(() => {
  menu.value.productManagement =
    route.path == '/admin/categories' || route.path == '/admin/products';

  menu.value.productAttributes =
    route.path == '/admin/attributes' || route.path == '/admin/units';
});

const toggleLeftDrawer = () => (leftDrawerOpen.value = !leftDrawerOpen.value);

const handleLogout = () => {
  loading.value = true;
  authStore.logout().finally(() => {
    loading.value = false;
    window.location.reload();
  });
};
</script>
