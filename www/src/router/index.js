import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      redirect: '/login'
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('../views/staff/Login.vue'),
      beforeEnter: async (to) => {
        const auth = useAuthStore();
        if (!auth.admin && auth.token) {
          auth.returnUrl = to.fullPath;
          return '/staff/dashboard';
        } else if (auth.admin && auth.token) {
          auth.returnUrl = to.fullPath;
          return '/admin/dashboard';
        }
      },
    },
    {
      path: '/admin',
      name: 'AdminLayout',
      component: () => import('../layouts/AdminLayout.vue'),
      beforeEnter: async (to) => {
        const auth = useAuthStore();
        if (!auth.admin && auth.token) {
          auth.returnUrl = to.fullPath;
          return '/staff/dashboard';
        } else if (!auth.admin && !auth.token) {
          auth.returnUrl = to.fullPath;
          return '/login';
        }
      },
      children: [
        {
          path: 'dashboard',
          name: 'AdminDashboard',
          component: () => import('../views/admin/Dashboard.vue'),
        },
      ],
    },
    {
      path: '/staff',
      name: 'StaffLayout',
      component: () => import('../layouts/StaffLayout.vue'),
      beforeEnter: async (to) => {
        const auth = useAuthStore();
        if (auth.admin && auth.token) {
          auth.returnUrl = to.fullPath;
          return '/admin/dashboard';
        } else if (!auth.admin && !auth.token) {
          auth.returnUrl = to.fullPath;
          return '/login';
        }
      },
      children: [
        {
          path: 'dashboard',
          show: 'Dashboard',
          name: 'StaffDashboard',
          component: () => import('../views/staff/Dashboard.vue'),
        },
        {
          path: 'attendance',
          show: 'Attendance',
          name: 'StaffAttendance',
          component: () => import('../views/staff/Attendance.vue'),
        },
      ],
    },
  ]
})

router.beforeEach(async (to) => {
  // redirect to login page if not logged in and trying to access a restricted page
  const publicPages = ['/login', '/admin/login'];
  const authRequired = !publicPages.includes(to.path);
  const auth = useAuthStore();

  if (authRequired && !auth.token) {
    auth.returnUrl = to.fullPath;
    return '/login';
  }
});

export default router
