<template>
    <div class="container mt-4">
        <h1>Tambah Pembeli</h1>
        <form @submit.prevent="submitForm">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input v-model="nama" id="nama" type="text" class="form-control" required />
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input v-model="email" id="email" type="email" class="form-control" required />
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input v-model="password" id="password" type="password" class="form-control" required />
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
        </form>
    </div>
</template>

<script setup>
import { ref } from 'vue';
// Mengimpor API dengan relative path
import api from '../../Api';

// Mendefinisikan state untuk form input
const nama = ref('');
const email = ref('');
const password = ref('');

// Method untuk mengirim data pembeli ke API
const submitForm = async () => {
    try {
        await api.post('api/pembeli', {
            nama: nama.value,
            email: email.value,
            password: password.value,
        });
        // Setelah berhasil, arahkan kembali ke halaman daftar pembelis
        window.location.href = '/pembeli';
    } catch (error) {
        console.error('Error adding pembeli:', error);
    }
};
</script>

<style scoped>
/* Styling untuk form */
input[type='text'],
input[type='email'],
input[type='password'] {
    max-width: 400px;
    margin: 0 auto;
}
</style>