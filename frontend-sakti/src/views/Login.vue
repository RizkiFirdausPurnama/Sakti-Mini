<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md border border-gray-100">
      <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800">Welcome Back</h2>
        <p class="text-gray-500 mt-2">Please enter your details</p>
      </div>

      <form @submit.prevent="handleLogin" class="space-y-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input v-model="form.email" type="email" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-royal-blue focus:border-transparent outline-none transition" placeholder="Enter your email" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input v-model="form.password" type="password" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-royal-blue focus:border-transparent outline-none transition" placeholder="••••••••" required>
        </div>

        <div v-if="errorMessage" class="bg-red-50 text-red-600 text-sm p-3 rounded-lg flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
            {{ errorMessage }}
        </div>

        <button :disabled="loading" type="submit" class="w-full bg-royal-blue text-white font-bold py-3 rounded-xl hover:bg-blue-700 transition disabled:opacity-50">
            {{ loading ? 'Signing in...' : 'Sign In' }}
        </button>
      </form>

      <div class="mt-6 text-center text-sm text-gray-500">
        Don't have an account? <router-link to="/" class="text-royal-blue font-semibold">Sign up</router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue';
import { useRouter } from 'vue-router';
import api from '../lib/axios'; // Pastikan file axios.js sudah dibuat di langkah sebelumnya

const router = useRouter();
const loading = ref(false);
const errorMessage = ref('');
const form = reactive({ email: '', password: '' });

const handleLogin = async () => {
    loading.value = true;
    errorMessage.value = '';
    
    try {
        // Panggil API Login Laravel
        const response = await api.post('/login', form);
        
        // Simpan Token & Data User
        localStorage.setItem('token', response.data.data.access_token);
        localStorage.setItem('user', JSON.stringify(response.data.data.user));

        // Redirect ke Dashboard
        router.push('/dashboard');
    } catch (error) {
        // Tangani Error (401 atau 429 Rate Limit)
        if (error.response) {
            errorMessage.value = error.response.data.message || 'Login failed.';
        } else {
            errorMessage.value = 'Network error.';
        }
    } finally {
        loading.value = false;
    }
};
</script>