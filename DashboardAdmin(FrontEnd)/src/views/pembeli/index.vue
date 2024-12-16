<template>
  <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <!-- Card -->
    <div class="flex flex-col">
      <div class="-m-1.5 overflow-x-auto">
        <div class="p-1.5 min-w-full inline-block align-middle">
          <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
            <!-- Header -->
            <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200">
              <div>
                <h2 class="text-xl font-semibold text-gray-800">Users</h2>
                <p class="text-sm text-gray-600">Add users, edit and more.</p>
              </div>
              <div>
                <div class="inline-flex gap-x-2">
                  <button @click="openAddModal"
                    class="py-2 px-3 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50">
                    Add user
                  </button>
                </div>
              </div>
            </div>
            <!-- End Header -->

            <!-- Table -->
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="ps-6 py-3 text-start">Id</th>
                  <th class="px-6 py-3 text-start">Nama</th>
                  <th class="px-6 py-3 text-start">Email</th>
                  <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <tr v-if="posts.length === 0">
                  <td colspan="5" class="text-center py-3">
                    <div class="alert alert-danger mb-0 text-gray-500">Data Belum Tersedia!</div>
                  </td>
                </tr>
                <tr v-else v-for="(post, index) in posts" :key="post.id">
                  <td class="px-6 py-3">{{ index + 1 }}</td>
                  <td class="px-6 py-3">{{ post.nama }}</td>
                  <td class="px-6 py-3">{{ post.email }}</td>
                  <td class="text-center px-6 py-3 font-light">
                    <button @click="openEditModal(post)"
                      class="py-2 px-4 bg-gray-800 text-white rounded shadow-md hover:bg-gray-700 mr-2">
                      Edit
                    </button>
                    <button @click="deletePembeli(post.id)"
                      class="py-2 px-4 bg-red-600 text-white rounded shadow-md hover:bg-red-500">
                      Hapus
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Tambah Pengguna -->
    <div v-if="isModalOpen" class="modal fade show" style="display: block;" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content bg-white rounded-lg shadow-lg">
      <div class="modal-header bg-white text-white">
        <h5 class="modal-title text-gray-600">{{ isEditMode ? 'Edit' : 'Tambah' }} Pengguna</h5>
        <button type="button" class="btn-close" @click="closeModal"></button>
      </div>
      <div class="modal-body">
        <form @submit.prevent="submitForm">
          <!-- Input Nama -->
          <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input v-model="editedPembeli.nama" type="text" class="form-control" required />
          </div>

          <!-- Input Email -->
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input v-model="editedPembeli.email" type="email" class="form-control" required />
          </div>

          <!-- Input Password hanya tampil di tambah pengguna -->
          <div class="mb-3" v-if="!isEditMode">
            <label for="password" class="form-label">Password</label>
            <input v-model="editedPembeli.password" type="password" class="form-control" required />
          </div>

          <button type="submit" class="btn btn-success w-full py-2 mt-3 bg-gray-800 hover:bg-gray-700">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import api from '../../Api'; // Pastikan import api sesuai dengan struktur proyek Anda

const posts = ref([]);
const isModalOpen = ref(false);
const editedPembeli = ref({
  id: null,  // Pastikan id ada untuk pembeli yang akan diedit
  nama: '',
  email: '',
  password: ''  // Tambahkan properti password
});
const isEditMode = ref(false); // Mode untuk edit atau tambah pembeli

// Fungsi untuk membuka modal untuk menambah pembeli
const openAddModal = () => {
  editedPembeli.value = { nama: '', email: '', password: '' }; // Kosongkan form, termasuk password
  isEditMode.value = false; // Menandakan mode tambah
  isModalOpen.value = true;
};

// Ambil data pembeli
const fetchPembelis = async () => {
  try {
    const response = await api.get('api/pembeli'); // Pastikan endpoint sesuai
    posts.value = response.data; // Ambil data pembeli, termasuk tiket
  } catch (error) {
    console.error('Error fetching pembelis:', error);
  }
};

// Hapus pembeli
const deletePembeli = async (id) => {
  if (confirm('Apakah Anda yakin ingin menghapus pembeli ini?')) {
    try {
      await api.delete(`api/pembeli/${id}`); // Endpoint sesuai dengan ID pembeli
      fetchPembelis(); // Refresh daftar pembeli
    } catch (error) {
      console.error('Error deleting pembeli:', error);
    }
  }
};

// Fungsi untuk membuka modal edit pembeli
const openEditModal = (pembeli) => {
  editedPembeli.value = { ...pembeli }; // Salin data pembeli ke form
  isEditMode.value = true; // Mode edit
  isModalOpen.value = true;
};

// Tutup modal
const closeModal = () => {
  isModalOpen.value = false;
};

// Kirim form untuk tambah/edit pembeli
const submitForm = async () => {
  try {
    let response;
    if (isEditMode.value) {
      // Update pembeli jika dalam mode edit
      response = await api.put(`api/pembeli/${editedPembeli.value.id}`, editedPembeli.value);
    } else {
      // Tambah pembeli jika dalam mode tambah
      response = await api.post('api/pembeli', editedPembeli.value);
    }

    console.log('Response:', response.data);  // Menampilkan respons API di console untuk debugging

    closeModal(); // Tutup modal setelah submit
    fetchPembelis(); // Refresh daftar pembeli
  } catch (error) {
    console.error('Error saving pembeli:', error.response || error);  // Menampilkan error lebih rinci
    alert('Gagal menyimpan data. Cek konsol untuk detail error.');
  }
};


onMounted(() => {
  fetchPembelis(); // Ambil data pembeli saat komponen di-mount
});
</script>

<style scoped>
table th,
table td {
  text-align: left;
}

.modal-backdrop {
  display: none;
}
</style>
