<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md border border-gray-100">
      <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800">Create Account</h2>
        <p class="text-gray-500 mt-2">Join us for a bright future</p>
      </div>

      <form @submit.prevent="handleRegister" class="space-y-5">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
            <input v-model="form.name" type="text" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-royal-blue outline-none" placeholder="John Doe" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input v-model="form.email" type="email" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-royal-blue outline-none" placeholder="name@example.com" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input v-model="form.password" type="password" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-royal-blue outline-none" placeholder="Min 8 characters" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
            <input v-model="form.password_confirmation" type="password" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-royal-blue outline-none" placeholder="Repeat password" required>
        </div>

        <div v-if="errorMessage" class="bg-red-50 text-red-600 text-sm p-3 rounded-lg">
            {{ errorMessage }}
        </div>

        <button :disabled="loading" type="submit" class="w-full bg-royal-blue text-white font-bold py-3 rounded-xl hover:bg-blue-700 transition disabled:opacity-50">
            {{ loading ? 'Creating Account...' : 'Register Now' }}
        </button>
      </form>

      <div class="mt-6 text-center text-sm text-gray-500">
        Already have an account? <router-link to="/login" class="text-royal-blue font-semibold">Sign In</router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue';
import { useRouter } from 'vue-router';
import api from '../lib/axios';

const router = useRouter();
const loading = ref(false);
const errorMessage = ref('');
const form = reactive({
    name: '',
    email: '',
    password: '',
    password_confirmation: ''
});

const handleRegister = async () => {
    loading.value = true;
    errorMessage.value = '';
    
    try {
        const response = await api.post('/register', form);
        // Sukses register langsung redirect ke login
        alert('Registration successful! Please login.');
        router.push('/login');
    } catch (error) {
        if (error.response && error.response.data.message) {
           errorMessage.value = error.response.data.message;
        } else {
           errorMessage.value = 'Registration failed. Please check your inputs.';
        }
    } finally {
        loading.value = false;
    }
};
</script>