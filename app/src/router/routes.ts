import { Role } from 'src/stores/auth';
import { RouteRecordRaw } from 'vue-router';

const routes: RouteRecordRaw[] = [
  {
    path: '/admin/login',
    component: () => import('layouts/LoginLayout.vue'),
    meta: { role: Role.AdminGuest },
    children: [
      {
        path: '',
        component: () => import('pages/Auth/AdminLogin.vue'),
      },
    ],
  },
  {
    path: '/admin',
    component: () => import('layouts/MainLayout.vue'),
    meta: { requiresAuth: true, role: Role.Admin },
    children: [
      { path: '', component: () => import('pages/IndexPage.vue') },
      {
        path: 'categories',
        component: () => import('pages/Products/CategoriesPage.vue'),
      },
      {
        path: 'products',
        component: () => import('pages/Products/ProductsPage.vue'),
      },
      {
        path: 'units',
        component: () => import('pages/Attributes/AttributeUnitsPage.vue'),
      },
    ],
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue'),
  },
];

export default routes;
