<template>
  <Navbar />
  <div class="min-h-screen bg-gray-50 py-10 px-4 flex justify-center">
    <div class="w-full max-w-2xl">
      
      <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">
          {{ isEdit ? 'Edit Data Mahasiswa' : 'Tambah Mahasiswa Baru' }}
        </h1>
        <router-link :to="{ name: 'mahasiswa.index' }" class="text-gray-500 hover:text-gray-700 font-medium">
          &larr; Kembali
        </router-link>
      </div>

      <div class="bg-white p-8 rounded-2xl shadow-xl border border-gray-100">
        <form @submit.prevent="submitForm" class="space-y-6">
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">NIM</label>
              <input v-model="form.nim" type="text" placeholder="Contoh: 2501982222"
                class="w-full px-4 py-3 rounded-lg border outline-none transition"
                :class="errors?.nim ? 'border-red-500 focus:ring-red-200' : 'border-gray-300 focus:ring-royal-blue'"
              >
              <p v-if="errors?.nim" class="text-red-500 text-xs mt-1 font-semibold">⚠️ {{ errors.nim[0] }}</p>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Angkatan</label>
              <input v-model="form.angkatan" type="number" placeholder="2025"
                class="w-full px-4 py-3 rounded-lg border outline-none transition"
                :class="errors?.angkatan ? 'border-red-500 focus:ring-red-200' : 'border-gray-300 focus:ring-royal-blue'"
              >
              <p v-if="errors?.angkatan" class="text-red-500 text-xs mt-1 font-semibold">⚠️ {{ errors.angkatan[0] }}</p>
            </div>

            <div class="md:col-span-2">
              <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
              <input v-model="form.nama" type="text" placeholder="Nama Mahasiswa"
                class="w-full px-4 py-3 rounded-lg border outline-none transition"
                :class="errors?.nama ? 'border-red-500 focus:ring-red-200' : 'border-gray-300 focus:ring-royal-blue'"
              >
              <p v-if="errors?.nama" class="text-red-500 text-xs mt-1 font-semibold">⚠️ {{ errors.nama[0] }}</p>
            </div>

            <div class="md:col-span-2">
              <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
              <input v-model="form.email" type="email" placeholder="email@binus.ac.id"
                class="w-full px-4 py-3 rounded-lg border outline-none transition"
                :class="errors?.email ? 'border-red-500 focus:ring-red-200' : 'border-gray-300 focus:ring-royal-blue'"
              >
              <p v-if="errors?.email" class="text-red-500 text-xs mt-1 font-semibold">⚠️ {{ errors.email[0] }}</p>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Program Studi</label>
              <select v-model="form.prodi" class="w-full px-4 py-3 rounded-lg border outline-none transition bg-white"
                 :class="errors?.prodi ? 'border-red-500 focus:ring-red-200' : 'border-gray-300 focus:ring-royal-blue'">
                <option value="" disabled>Pilih Prodi</option>
                <option value="Teknik Informatika">Teknik Informatika</option>
                <option value="Sistem Informasi">Sistem Informasi</option>
                <option value="DKV">DKV</option>
              </select>
              <p v-if="errors?.prodi" class="text-red-500 text-xs mt-1 font-semibold">⚠️ {{ errors.prodi[0] }}</p>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Status Akademik</label>
              <select v-model="form.status" class="w-full px-4 py-3 rounded-lg border outline-none transition bg-white"
                 :class="errors?.status ? 'border-red-500 focus:ring-red-200' : 'border-gray-300 focus:ring-royal-blue'">
                <option value="aktif">Aktif</option>
                <option value="cuti">Cuti</option>
                <option value="lulus">Lulus</option>
                <option value="dropout">Drop Out</option>
              </select>
              <p v-if="errors?.status" class="text-red-500 text-xs mt-1 font-semibold">⚠️ {{ errors.status[0] }}</p>
            </div>

          </div>

          <div class="pt-6 flex gap-4">
            <router-link :to="{ name: 'mahasiswa.index' }" class="w-1/3 text-center px-6 py-3 border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition">
              Batal
            </router-link>
            <button :disabled="loading" type="submit" class="w-2/3 bg-royal-blue text-white font-bold px-6 py-3 rounded-xl shadow-lg hover:bg-blue-700 transition disabled:opacity-50 flex justify-center gap-2">
              <span v-if="loading" class="animate-spin h-5 w-5 border-2 border-white border-t-transparent rounded-full"></span>
              {{ loading ? 'Menyimpan...' : 'Simpan Data' }}
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import Navbar from '../../components/Navbar.vue';
import { ref, reactive, onMounted, computed } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import api from '../../lib/axios';

const router = useRouter();
const route = useRoute();

// Deteksi Mode Edit berdasarkan ada/tidaknya ID di URL
const isEdit = computed(() => !!route.params.id);
const loading = ref(false);
const errors = ref({}); // Menyimpan error dari Backend

const form = reactive({
  nim: '',
  nama: '',
  email: '',
  prodi: '',
  angkatan: '',
  status: 'aktif'
});

// Ambil data jika mode Edit
onMounted(async () => {
  if (isEdit.value) {
    loading.value = true;
    try {
      const response = await api.get(`/mahasiswas/${route.params.id}`);
      Object.assign(form, response.data.data); // Copy data ke form
    } catch (error) {
      alert('Data tidak ditemukan');
      router.push({ name: 'mahasiswa.index' });
    } finally {
      loading.value = false;
    }
  }
});

const submitForm = async () => {
  loading.value = true;
  errors.value = {}; // Reset error

  try {
    if (isEdit.value) {
      await api.put(`/mahasiswas/${route.params.id}`, form);
    } else {
      await api.post('/mahasiswas', form);
    }
    
    // Redirect Sukses
    alert('Data berhasil disimpan!');
    router.push({ name: 'mahasiswa.index' });

  } catch (error) {
    // Handle Validation Error (422)
    if (error.response && error.response.status === 422) {
      errors.value = error.response.data.errors;
    } else {
      console.error(error);
      alert('Terjadi kesalahan pada server.');
    }
  } finally {
    loading.value = false;
  }
};
</script>