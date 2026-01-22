<template>
  <Navbar />
  
  <div class="min-h-screen bg-white py-20 px-4">
    <div class="max-w-6xl mx-auto text-center">
      
      <h2 class="text-4xl font-bold text-gray-900 mb-4">Our Program</h2>
      <p class="text-gray-500 max-w-2xl mx-auto mb-16 text-lg">
        Discover our comprehensive educational programs designed to nurture every aspect of student development.
      </p>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        
        <div v-for="(program, index) in programs" :key="index" 
             class="bg-white rounded-[32px] p-8 border border-gray-100 shadow-xl shadow-gray-100 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 group cursor-pointer">
          
          <div class="w-20 h-20 mx-auto bg-blue-50 text-royal-blue rounded-full flex items-center justify-center mb-6 group-hover:bg-royal-blue group-hover:text-white transition-colors duration-300"
               v-html="program.icon">
          </div>

          <h3 class="text-xl font-bold text-gray-900 mb-3">{{ program.title }}</h3>
          <p class="text-gray-500 text-sm leading-relaxed">
            {{ program.desc }}
          </p>
        </div>

      </div>
    </div>
  </div>
</template>

<script setup>
import Navbar from '../components/Navbar.vue';
import { ref } from 'vue';

// PERBAIKAN: Icon disimpan sebagai String biasa (bukan Component object)
// Kita juga masukkan class="w-9 h-9" langsung di dalam string SVG-nya
const IconSchool = `<svg class="w-9 h-9" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" /></svg>`;

const IconHigh = `<svg class="w-9 h-9" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" /></svg>`;

const IconDigital = `<svg class="w-9 h-9" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" /></svg>`;

const IconSports = `<svg class="w-9 h-9" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.047 8.287 8.287 0 009 9.601a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 00.495-7.468 5.99 5.99 0 00-1.925 3.547 5.975 5.975 0 01-2.133-1.001A3.75 3.75 0 0012 18z" /></svg>`;

const programs = ref([
  { title: 'Primary School', desc: 'Building a strong foundation with a comprehensive curriculum for grades 1-5.', icon: IconSchool },
  { title: 'High School', desc: 'Preparing students for higher education with advanced courses and career guidance.', icon: IconHigh },
  { title: 'Digital Learning', desc: 'Innovative online programs to enhance learning through technology.', icon: IconDigital },
  { title: 'Co-Curricular', desc: 'A wide range of sports, arts, and clubs to develop well-rounded personalities.', icon: IconSports },
]);
</script>