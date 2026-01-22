<template>
  <Navbar />
  <div class="min-h-screen bg-gray-50 py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
      
      <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Data Mahasiswa</h1>
          <p class="text-gray-500 mt-1">Kelola data akademik mahasiswa Universitas Binus</p>
        </div>
        <router-link :to="{ name: 'mahasiswa.create' }" class="bg-royal-blue text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-blue-200 hover:bg-blue-700 transition flex items-center gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" /></svg>
          Tambah Mahasiswa
        </router-link>
      </div>

      <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
          <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </span>
            <input v-model="params.q" type="text" placeholder="Cari Nama / NIM..." class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-royal-blue outline-none transition">
          </div>

          <select v-model="params.prodi" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-royal-blue outline-none transition bg-white">
            <option value="">Semua Prodi</option>
            <option value="Teknik Informatika">Teknik Informatika</option>
            <option value="Sistem Informasi">Sistem Informasi</option>
            <option value="DKV">DKV</option>
          </select>

          <select v-model="params.status" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-royal-blue outline-none transition bg-white">
            <option value="">Semua Status</option>
            <option value="aktif">Aktif</option>
            <option value="cuti">Cuti</option>
            <option value="lulus">Lulus</option>
            <option value="dropout">Drop Out</option>
          </select>

          <select v-model="params.per_page" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-royal-blue outline-none transition bg-white">
            <option value="5">5 Data / Hal</option>
            <option value="10">10 Data / Hal</option>
            <option value="25">25 Data / Hal</option>
            <option value="50">50 Data / Hal</option>
          </select>
        </div>
      </div>

      <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse">
            <thead>
              <tr class="bg-gray-50 text-gray-600 text-sm uppercase tracking-wider">
                <th class="p-5 font-bold border-b">NIM</th>
                <th class="p-5 font-bold border-b">Mahasiswa</th>
                <th class="p-5 font-bold border-b">Prodi</th>
                <th class="p-5 font-bold border-b">Angkatan</th>
                <th class="p-5 font-bold border-b">Status</th>
                <th class="p-5 font-bold border-b text-center">Aksi</th>
              </tr>
            </thead>
            <tbody class="text-sm text-gray-700 divide-y divide-gray-100">
              <tr v-if="loading" class="animate-pulse">
                <td colspan="6" class="p-8 text-center text-gray-400">Sedang memuat data...</td>
              </tr>
              
              <tr v-else-if="students.length === 0">
                <td colspan="6" class="p-8 text-center text-gray-500 bg-gray-50">
                  Tidak ada data mahasiswa ditemukan.
                </td>
              </tr>

              <tr v-for="student in students" :key="student.id" class="hover:bg-blue-50/50 transition duration-150">
                <td class="p-5 font-mono font-medium text-gray-900">{{ student.nim }}</td>
                <td class="p-5">
                  <div class="font-bold text-gray-900">{{ student.nama }}</div>
                  <div class="text-xs text-gray-400">{{ student.email }}</div>
                </td>
                <td class="p-5">{{ student.prodi }}</td>
                <td class="p-5">{{ student.angkatan }}</td>
                <td class="p-5">
                  <span :class="statusBadgeClass(student.status)" class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide">
                    {{ student.status }}
                  </span>
                </td>
                <td class="p-5 text-center">
                  <div class="flex items-center justify-center gap-2">
                    <router-link :to="{ name: 'mahasiswa.edit', params: { id: student.id } }" class="p-2 text-yellow-600 bg-yellow-100 rounded-lg hover:bg-yellow-200 transition">
                      <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                    </router-link>
                    <button @click="deleteStudent(student.id)" class="p-2 text-red-600 bg-red-100 rounded-lg hover:bg-red-200 transition">
                      <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div v-if="pagination.total > 0" class="bg-gray-50 px-5 py-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
          <span class="text-sm text-gray-500">
            Showing <span class="font-bold">{{ pagination.from }}</span> to <span class="font-bold">{{ pagination.to }}</span> of <span class="font-bold">{{ pagination.total }}</span> results
          </span>
          <div class="flex gap-2">
            <button 
              @click="changePage(pagination.current_page - 1)" 
              :disabled="pagination.current_page === 1"
              class="px-4 py-2 border rounded-lg bg-white hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed text-sm font-medium transition">
              Previous
            </button>
            <button 
              @click="changePage(pagination.current_page + 1)" 
              :disabled="pagination.current_page === pagination.last_page"
              class="px-4 py-2 border rounded-lg bg-white hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed text-sm font-medium transition">
              Next
            </button>
          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<script setup>
import Navbar from '../../components/Navbar.vue';
import { ref, reactive, watch, onMounted } from 'vue';
import api from '../../lib/axios';

const students = ref([]);
const loading = ref(false);
const pagination = ref({});

// State Filters
const params = reactive({
  q: '',
  prodi: '',
  status: '',
  per_page: '10',
  page: 1
});

// Helper: Warna Badge Status
const statusBadgeClass = (status) => {
  switch(status) {
    case 'aktif': return 'bg-green-100 text-green-700';
    case 'cuti': return 'bg-yellow-100 text-yellow-700';
    case 'lulus': return 'bg-blue-100 text-blue-700';
    case 'dropout': return 'bg-red-100 text-red-700';
    default: return 'bg-gray-100 text-gray-700';
  }
};

// Fetch Data dari API
const fetchData = async () => {
  loading.value = true;
  try {
    const response = await api.get('/mahasiswas', { params: params });
    students.value = response.data.data;
    pagination.value = response.data.meta;
  } catch (error) {
    console.error("Gagal ambil data:", error);
  } finally {
    loading.value = false;
  }
};

// Watchers untuk Filter (Auto Reload)
let debounceTimeout;
watch(params, (newVal) => {
  clearTimeout(debounceTimeout);
  debounceTimeout = setTimeout(() => {
    // Reset page ke 1 jika filter berubah (kecuali page itu sendiri)
    fetchData();
  }, 500); // Debounce 500ms
}, { deep: true });

// Pagination Handler
const changePage = (page) => {
  if (page >= 1 && page <= pagination.value.last_page) {
    params.page = page;
    // fetch data akan terpanggil otomatis oleh watcher
  }
};

// Delete Handler
const deleteStudent = async (id) => {
  if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) return;
  
  try {
    await api.delete(`/mahasiswas/${id}`);
    alert('Data berhasil dihapus.');
    fetchData(); // Refresh table
  } catch (error) {
    alert('Gagal menghapus data.');
  }
};

onMounted(() => {
  fetchData();
});
</script>