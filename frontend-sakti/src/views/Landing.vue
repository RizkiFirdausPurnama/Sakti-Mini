<template>
  <Navbar />
  <div class="min-h-screen bg-orange-50/30 flex items-center justify-center px-6 lg:px-16 overflow-hidden relative">
    
    <div class="absolute top-20 right-0 w-64 h-64 bg-yellow-200 rounded-full blur-3xl opacity-30 -z-10"></div>
    <div class="absolute bottom-0 left-20 w-72 h-72 bg-blue-200 rounded-full blur-3xl opacity-30 -z-10"></div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center w-full max-w-7xl pb-20 pt-10">
      
      <div class="space-y-6 text-center lg:text-left">
        <div class="inline-block px-4 py-1 border border-blue-200 text-royal-blue rounded-full text-xs font-bold bg-white tracking-wide uppercase">
          🎓 A Better Place to Learn
        </div>
        <h1 class="text-5xl lg:text-7xl font-bold text-gray-900 leading-tight">
          Education <span class="text-gray-400 font-normal italic">for</span><br>
          <span class="font-normal">a Bright</span> <span class="text-royal-blue">Future.</span>
        </h1>
        <p class="text-gray-600 text-lg max-w-md mx-auto lg:mx-0 leading-relaxed">
          A modern learning environment where education meets innovation, inspiring every student to succeed.
        </p>

        <div class="pt-8 flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
          
          <router-link to="/login" class="bg-royal-blue text-white px-8 py-4 rounded-xl font-bold text-lg shadow-xl shadow-blue-200 hover:bg-blue-700 hover:-translate-y-1 transition transform flex items-center justify-center gap-2">
            Login Now 
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
            </svg>
          </router-link>

          <router-link to="/register" class="bg-white text-royal-blue border-2 border-royal-blue px-8 py-4 rounded-xl font-bold text-lg hover:bg-blue-50 hover:-translate-y-1 transition transform flex items-center justify-center">
            Register Account
          </router-link>

        </div>
      </div>

      <div class="relative h-[400px] lg:h-[500px] w-full hidden lg:block">
        <div class="absolute top-0 right-10 w-48 h-48 rounded-full overflow-hidden border-4 border-white shadow-2xl z-20 hover:scale-105 transition duration-500">
          <img src="https://images.unsplash.com/photo-1503919545889-aef636e10ad4?auto=format&fit=crop&q=80&w=400" class="w-full h-full object-cover">
        </div>
        
        <div class="absolute top-20 right-52 w-44 h-44 rounded-[40px] overflow-hidden border-4 border-white shadow-2xl z-10 bg-blue-100 hover:scale-105 transition duration-500">
           <img src="https://images.unsplash.com/photo-1491841550275-ad7854e35ca6?auto=format&fit=crop&q=80&w=400" class="w-full h-full object-cover">
        </div>

        <div class="absolute bottom-10 right-20 w-56 h-56 rounded-tr-[80px] rounded-bl-[80px] rounded-tl-3xl rounded-br-3xl overflow-hidden border-4 border-white shadow-2xl z-30 bg-yellow-400 hover:scale-105 transition duration-500">
           <img src="https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&q=80&w=400" class="w-full h-full object-cover">
        </div>

        <div class="absolute top-1/2 left-10 w-12 h-12 bg-royal-blue rounded-full blur-md opacity-60 animate-pulse"></div>
        <div class="absolute bottom-20 right-80 w-8 h-8 bg-accent-yellow rounded-full shadow-lg"></div>
      </div>

    </div>
  </div>
</template>

<script setup>
import Navbar from '../components/Navbar.vue';
</script>