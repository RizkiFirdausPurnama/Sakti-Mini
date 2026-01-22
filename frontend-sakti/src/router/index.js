import { createRouter, createWebHistory } from 'vue-router'
import Landing from '../views/Landing.vue'
import Login from '../views/Login.vue'
import Register from '../views/Register.vue'
import Dashboard from '../views/Dashboard.vue'
// Import Component Mahasiswa
import MahasiswaIndex from '../views/mahasiswa/MahasiswaIndex.vue'
import MahasiswaForm from '../views/mahasiswa/MahasiswaForm.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/', name: 'landing', component: Landing },
    { path: '/login', name: 'login', component: Login },
    { path: '/register', name: 'register', component: Register },
    { path: '/dashboard', name: 'dashboard', component: Dashboard, meta: { requiresAuth: true } },
    
    // --- MODULE MAHASISWA ---
    { 
      path: '/mahasiswa', 
      name: 'mahasiswa.index', 
      component: MahasiswaIndex, 
      meta: { requiresAuth: true } 
    },
    { 
      path: '/mahasiswa/create', 
      name: 'mahasiswa.create', 
      component: MahasiswaForm, 
      meta: { requiresAuth: true } 
    },
    { 
      path: '/mahasiswa/:id/edit', 
      name: 'mahasiswa.edit', 
      component: MahasiswaForm, 
      meta: { requiresAuth: true } 
    },
  ]
})

// ... (Route Guard tetap sama seperti sebelumnya) ...
router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token');
  if (to.meta.requiresAuth && !token) {
    next('/login');
  } else if ((to.name === 'login' || to.name === 'register' || to.path === '/') && token) {
    next('/dashboard');
  } else {
    next();
  }
});

export default router