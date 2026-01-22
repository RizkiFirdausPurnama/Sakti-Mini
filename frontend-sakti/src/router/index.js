import { createRouter, createWebHistory } from 'vue-router'
import Landing from '../views/Landing.vue'
import Login from '../views/Login.vue'
import Register from '../views/Register.vue'
import Dashboard from '../views/Dashboard.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/', name: 'landing', component: Landing },
    { path: '/login', name: 'login', component: Login },
    { path: '/register', name: 'register', component: Register },
    { path: '/dashboard', name: 'dashboard', component: Dashboard, meta: { requiresAuth: true } },
  ]
})

// --- SCRIPT PENGAMAN (Route Guard) ---
router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token');

  // 1. Kalau mau masuk Dashboard tapi TIDAK punya token -> Tendang ke Login
  if (to.meta.requiresAuth && !token) {
    next('/login');
  } 
  
  // 2. Kalau mau masuk Login/Register ATAU Landing Page ('/') tapi PUNYA token -> Paksa ke Dashboard
  // (Disini logika yang membuat Landing Page tidak bisa dibuka kalau sudah login)
  else if ((to.name === 'login' || to.name === 'register' || to.path === '/') && token) {
    next('/dashboard');
  } 
  
  // 3. Aman, silakan lewat
  else {
    next();
  }
});

export default router