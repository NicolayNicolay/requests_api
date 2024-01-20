import {createRouter, createWebHistory, RouteRecordRaw} from "vue-router";

const routes: Array<RouteRecordRaw> = [
  {
    name: 'HomePage',
    path: '/',
    meta: {
      requiresAuth: true,
    },
    redirect: '/admin',
  },
  {
    name: 'ApplicationPage',
    path: '/admin',
    meta: {
      requiresAuth: true,
    },
    component: () => import('@/views/Pages/ApplicationFormPage.vue')
  },
  {
    name: 'ApplicationListPage',
    path: '/admin/list',
    meta: {
      requiresAuth: true,
    },
    component: () => import('@/views/Pages/ApplicationListPage.vue')
  },
  {
    name: 'EditApplicationForm',
    path: '/admin/moderate/:id',
    meta: {
      requiresAuth: true,
    },
    component: () => import('@/views/Pages/ApplicationModerateForm.vue')
  },
  {
    name: 'Login',
    path: '/login',
    meta: {
      onlyGuests: true,
    },
    component: () => import('@/views/Auth/LoginPage.vue')
  },
  {
    name: 'Registration',
    path: '/register',
    meta: {
      onlyGuests: true,
    },
    component: () => import('@/views/Auth/RegisterPage.vue')
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router
