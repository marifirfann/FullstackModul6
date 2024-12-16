<template>
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <!-- Card -->
        <div class="flex flex-col">
            <div class="-m-1.5 overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                        <!-- Header -->
                        <div
                            class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-800">Daftar Produk</h2>
                                <p class="text-sm text-gray-600">Tambah, edit, dan hapus produk dengan mudah.</p>
                            </div>
                            <div>
                                <button @click="openAddModal"
                                    class="py-2 px-3 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50">
                                    Tambah Produk
                                </button>
                            </div>
                        </div>
                        <!-- End Header -->

                        <!-- Table -->
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="ps-6 py-3 text-start">No</th>
                                    <th class="px-6 py-3 text-start">Nama Produk</th>
                                    <th class="px-6 py-3 text-start">Harga</th>
                                    <th class="px-6 py-3 text-start">Deskripsi</th>
                                    <th class="px-6 py-3 text-center">Stok</th>
                                    <th class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="products.length === 0">
                                    <td colspan="6" class="text-center py-3">
                                        <div class="alert alert-danger mb-0 text-gray-500">Data Belum Tersedia!</div>
                                    </td>
                                </tr>
                                <tr v-else v-for="(product, index) in products" :key="product.id">
                                    <td class="px-6 py-3">{{ index + 1 }}</td>
                                    <td class="px-6 py-3">{{ product.nama_produk }}</td>
                                    <td class="px-6 py-3">Rp{{ product.harga }}</td>
                                    <td class="px-6 py-3">{{ product.deskripsi }}</td>
                                    <td class="px-6 py-3 text-center">{{ product.stok }}</td>
                                    <td class="text-center px-6 py-3 font-light">
                                        <button @click="openEditModal(product)"
                                            class="py-2 px-4 bg-gray-800 text-white rounded shadow-md hover:bg-gray-700 mr-2">
                                            Edit
                                        </button>
                                        <button @click="deleteProduct(product.id)"
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

        <!-- Modal Edit/Tambah Produk -->
        <div v-if="isModalOpen" class="modal fade show" style="display: block;" tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content bg-white rounded-lg shadow-lg">
                    <div class="modal-header bg-white text-white">
                        <h5 class="modal-title text-gray-600">{{ isEditMode ? 'Edit Produk' : 'Tambah Produk' }}</h5>
                        <button type="button" class="btn-close" @click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="submitForm">
                            <!-- Input Nama Produk -->
                            <div class="mb-3">
                                <label for="nama_produk" class="form-label">Nama Produk</label>
                                <input v-model="editedProduct.nama_produk" id="nama_produk" type="text"
                                    class="form-control" required />
                            </div>

                            <!-- Input Harga Produk -->
                            <div class="mb-3">
                                <label for="harga" class="form-label">Harga</label>
                                <input v-model="editedProduct.harga" id="harga" type="number" class="form-control"
                                    required />
                            </div>

                            <!-- Input Deskripsi Produk -->
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi Produk</label>
                                <input v-model="editedProduct.deskripsi" id="deskripsi" type="text" class="form-control"
                                    required />
                            </div>

                            <!-- Input Stok Produk -->
                            <div class="mb-3">
                                <label for="stok" class="form-label">Stok Produk</label>
                                <input v-model="editedProduct.stok" id="stok" type="number" class="form-control"
                                    required />
                            </div>

                            <button type="submit" class="btn btn-success w-full py-2 mt-3 bg-gray-800">
                                {{ isEditMode ? 'Simpan Perubahan' : 'Tambah Produk' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import api from '../../Api';

const products = ref([]);
const isModalOpen = ref(false);
const editedProduct = ref({
    nama_produk: '',
    harga: '',
    deskripsi: '',
    stok: ''
});
const isEditMode = ref(false);

const openAddModal = () => {
    editedProduct.value = { nama_produk: '', harga: '', deskripsi: '', stok: '' };
    isEditMode.value = false;
    isModalOpen.value = true;
};

const fetchProducts = async () => {
    try {
        const response = await api.get('api/product');
        products.value = response.data.data;
    } catch (error) {
        console.error('Error fetching products:', error);
    }
};

const deleteProduct = async (id) => {
    if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
        try {
            await api.delete(`api/product/${id}`);
            fetchProducts();
        } catch (error) {
            console.error('Error deleting product:', error);
        }
    }
};

const openEditModal = (product) => {
    editedProduct.value = { ...product };
    isEditMode.value = true;
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
};

const submitForm = async () => {
    try {
        if (isEditMode.value) {
            await api.put(`api/product/${editedProduct.value.id}`, editedProduct.value);
        } else {
            await api.post('api/product', editedProduct.value);
        }
        closeModal();
        fetchProducts();
    } catch (error) {
        console.error('Error saving product:', error);
    }
};

onMounted(() => {
    fetchProducts();
});
</script>

<style scoped>
table th,
table td {
    text-align: center;
}

.modal-backdrop {
    display: none;
}
</style>