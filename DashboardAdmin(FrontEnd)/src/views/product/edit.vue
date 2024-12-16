<template>
    <div class="container mt-4">
        <h1>Edit Produk</h1>
        <form @submit.prevent="submitForm">
            <div class="mb-3">
                <label for="nama_produk" class="form-label">Nama Produk</label>
                <!-- Tampilkan nilai produk yang sudah ada, bisa diubah -->
                <div v-if="isEditing.nama_produk">
                    <span>{{ nama_produk }}</span>
                    <button type="button" @click="startEditing('nama_produk')" class="btn btn-sm btn-primary">Edit</button>
                </div>
                <div v-else>
                    <input v-model="nama_produk" id="nama_produk" type="text" class="form-control" required />
                </div>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <!-- Tampilkan nilai harga produk yang sudah ada, bisa diubah -->
                <div v-if="isEditing.harga">
                    <span>Rp{{ harga }}</span>
                    <button type="button" @click="startEditing('harga')" class="btn btn-sm btn-primary">Edit</button>
                </div>
                <div v-else>
                    <input v-model="harga" id="harga" type="number" class="form-control" required />
                </div>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi Produk</label>
                <!-- Tampilkan nilai deskripsi produk yang sudah ada, bisa diubah -->
                <div v-if="isEditing.deskripsi">
                    <span>{{ deskripsi }}</span>
                    <button type="button" @click="startEditing('deskripsi')" class="btn btn-sm btn-primary">Edit</button>
                </div>
                <div v-else>
                    <input v-model="deskripsi" id="deskripsi" type="text" class="form-control" required />
                </div>
            </div>
            <div class="mb-3">
                <label for="stok" class="form-label">Stok Produk</label>
                <!-- Tampilkan nilai stok produk yang sudah ada, bisa diubah -->
                <div v-if="isEditing.stok">
                    <span>{{ stok }}</span>
                    <button type="button" @click="startEditing('stok')" class="btn btn-sm btn-primary">Edit</button>
                </div>
                <div v-else>
                    <input v-model="stok" id="stok" type="number" class="form-control" required />
                </div>
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
        </form>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import api from '../../Api';

const route = useRoute();
const productId = route.params.id;

// Initialize the fields with `ref()` for reactivity
const nama_produk = ref('');  // This should be reactive
const harga = ref('');
const deskripsi = ref('');
const stok = ref('');

// Keep track of whether each field is being edited
const isEditing = ref({
  nama_produk: true,
  harga: false,
  deskripsi: false,
  stok: false
});

// Fetch product data
const fetchProduct = async () => {
    try {
        const response = await api.get(`api/product/${productId}`);
        const product = response.data;
        // Set the fetched data into the reactive variables
        nama_produk.value = product.nama_produk;
        harga.value = product.harga;
        deskripsi.value = product.deskripsi;
        stok.value = product.stok;
    } catch (error) {
        console.error('Error fetching product:', error);
    }
};

// Toggle the editing state of a specific field
const startEditing = (field) => {
    isEditing.value[field] = !isEditing.value[field];  // Toggle between true and false
};

// Submit form
const submitForm = async () => {
    try {
        await api.put(`api/product/${productId}`, {
            nama_produk: nama_produk.value,
            harga: harga.value,
            deskripsi: deskripsi.value,
            stok: stok.value
        });
        window.location.href = '/product';
    } catch (error) {
        console.error('Error updating product:', error);
    }
};

onMounted(() => {
    fetchProduct();
});
</script>
