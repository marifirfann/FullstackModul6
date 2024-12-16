<template>
    <div class="container mt-4">
        <h1>Edit Pembeli</h1>
        <form @submit.prevent="submitForm">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <!-- Binding the placeholder to display the value fetched from API -->
                <input v-model="nama" id="nama" type="text" class="form-control" :placeholder="nama || 'Masukkan Nama'" required />
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <!-- Binding the placeholder to display the value fetched from API -->
                <input v-model="email" id="email" type="email" class="form-control" :placeholder="email || 'Masukkan Email'" required />
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <!-- Binding the placeholder with a default message -->
                <input v-model="password" id="password" type="password" class="form-control" :placeholder="'Kosongkan jika tidak ingin mengubah'" />
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
        </form>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import api from '../../Api';

const nama = ref('');
const email = ref('');
const password = ref('');

const route = useRoute();
const pembeliId = route.params.id;

const fetchPembeli = async () => {
    try {
        const response = await api.get(`api/pembeli/${pembeliId}`);
        const pembeli = response.data;
        nama.value = pembeli.nama;
        email.value = pembeli.email;
    } catch (error) {
        console.error('Error fetching pembeli:', error);
    }
};

const submitForm = async () => {
    try {
        await api.put(`api/pembeli/${pembeliId}`, {
            nama: nama.value,
            email: email.value,
            password: password.value || undefined,
        });
        window.location.href = '/pembeli';
    } catch (error) {
        console.error('Error updating pembeli:', error);
    }
};

onMounted(() => {
    fetchPembeli();
});
</script>

<style scoped>
input[type='text'],
input[type='email'],
input[type='password'] {
    max-width: 400px;
    margin: 0 auto;
}
</style>
