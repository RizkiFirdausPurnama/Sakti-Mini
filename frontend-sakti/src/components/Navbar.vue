<template>
  <nav class="flex justify-between items-center px-8 py-5 bg-white shadow-sm sticky top-0 z-50">
    
    <div class="flex items-center gap-2">
      <div class="w-8 h-8 bg-royal-blue rounded-full flex items-center justify-center text-white font-bold">S</div>
      <router-link :to="isLoggedIn ? '/dashboard' : '/'" class="text-xl font-bold text-gray-800">
        Sprolt
      </router-link>
    </div>

    <div v-if="isLoggedIn" class="hidden md:flex gap-8 text-gray-600 font-medium">
      <router-link to="/dashboard" class="hover:text-royal-blue transition">Dashboard</router-link>
      <a href="#" class="hover:text-royal-blue transition">Gallery</a>
      <a href="#" class="hover:text-royal-blue transition">Blogs</a>
    </div>
    <div v-else class="hidden md:block"></div> 

    <div class="flex items-center gap-4">
      
      <template v-if="!isLoggedIn">
        <router-link to="/login" class="text-royal-blue font-semibold hover:underline">Login</router-link>
        <router-link to="/register" class="bg-royal-blue text-white px-5 py-2 rounded-full font-medium hover:bg-blue-700 transition shadow-md shadow-blue-200">
          Register
        </router-link>
      </template>

      <template v-else>
        <div class="relative">
          <button @click="toggleDropdown" class="flex items-center gap-3 focus:outline-none group">
            <div class="text-right hidden sm:block">
              <p class="text-xs text-gray-400">Welcome,</p>
              <p class="text-gray-700 font-bold text-sm group-hover:text-royal-blue transition">{{ userName }}</p>
            </div>
            
            <div class="w-10 h-10 bg-royal-blue rounded-full flex items-center justify-center text-white font-bold text-lg shadow-md border-2 border-white ring-2 ring-transparent group-hover:ring-blue-100 transition">
              {{ getInitials(userName) }}
            </div>
            
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 group-hover:text-royal-blue transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>

          <div v-if="isOpen" class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden py-2 transform transition-all origin-top-right z-50">
            
            <div class="px-5 py-3 border-b border-gray-50 bg-gray-50/50">
              <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Signed in as</p>
              <p class="text-sm font-bold text-gray-800 truncate">{{ userName }}</p>
            </div>

            <div class="py-2">
              <a href="#" class="flex items-center gap-3 px-5 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-royal-blue transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                Detail Profil
              </a>
              <a href="#" class="flex items-center gap-3 px-5 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-royal-blue transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                Settings
              </a>
            </div>

            <div class="border-t border-gray-100 mt-1 pt-1">
              <button @click="handleLogout" class="w-full text-left flex items-center gap-3 px-5 py-3 text-sm text-red-500 hover:bg-red-50 font-medium transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                Logout Account
              </button>
            </div>

          </div>
        </div>
      </template>

    </div>
  </nav>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import api from '../lib/axios';

const router = useRouter();
const isLoggedIn = ref(false);
const userName = ref('');
const isOpen = ref(false);

const getInitials = (name) => {
  if (!name) return 'U';
  return name.charAt(0).toUpperCase();
};

const toggleDropdown = () => {
  isOpen.value = !isOpen.value;
};

onMounted(() => {
  const token = localStorage.getItem('token');
  const user = localStorage.getItem('user');
  
  if (token && user) {
    isLoggedIn.value = true;
    userName.value = JSON.parse(user).name;
  }
});

const handleLogout = async () => {
  try {
    await api.post('/logout'); 
  } catch (e) {
    console.log("Logout error", e);
  } finally {
    localStorage.clear();
    isLoggedIn.value = false;
    router.push('/login');
    setTimeout(() => window.location.reload(), 100);
  }
};
</script>