<template>
    <div class="container mt-4">
        <h1>Tambah Produk</h1>
        <form @submit.prevent="submitForm">
            <div class="mb-3">
                <label for="nama_produk" class="form-label">Nama Produk</label>
                <input v-model="nama_produk" id="nama_produk" type="text" class="form-control" required />
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input v-model="harga" id="harga" type="number" class="form-control" required />
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi Produk</label>
                <input v-model="deskripsi" id="deskripsi" type="number" class="form-control" required />
            </div>
            <div class="mb-3">
                <label for="stok" class="form-label">Stok Produk</label>
                <input v-model="stok" id="stok" type="number" class="form-control" required />
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
        </form>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import api from '../../Api';

const nama_produk = ref('');  // Mengganti nama_tiket menjadi nama_produk
const harga = ref('');
const pembeli_id = ref('');
const pembelis = ref([]);

// Fetch data pembeli untuk dropdown
const fetchPembelis = async () => {
    try {
        const response = await api.get('api/pembeli');
        pembelis.value = response.data;
    } catch (error) {
        console.error('Error fetching pembelis:', error);
    }
};

// Submit form untuk produk
const submitForm = async () => {
    try {
        await api.post('api/product', {  // Ganti endpoint ke '/api/product'
            nama_produk: nama_produk.value,  // Ganti nama_tiket menjadi nama_produk
            harga: harga.value,
            pembeli_id: pembeli_id.value,
        });
        window.location.href = '/product';  // Redirect ke daftar produk setelah berhasil
    } catch (error) {
        console.error('Error adding product:', error);
    }
};

onMounted(() => {
    fetchPembelis();
});
</script>
