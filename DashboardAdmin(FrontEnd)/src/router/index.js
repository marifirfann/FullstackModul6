import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/Home.vue';
import PembelisIndex from '../views/pembeli/index.vue';
import PembelisCreate from '../views/pembeli/create.vue';
import PembelisEdit from '../views/pembeli/edit.vue';
import ProductsIndex from '../views/product/index.vue'; // Update to product folder
import ProductsCreate from '../views/product/create.vue'; // Update to product folder
import ProductsEdit from '../views/product/edit.vue'; // Update to product folder

const routes = [
    { path: '/', name: 'home', component: Home },

    // Rute Pembeli
    { path: '/pembeli', name: 'PembelisIndex', component: PembelisIndex },
    { path: '/pembeli/create', name: 'PembelisCreate', component: PembelisCreate },
    { path: '/pembeli/edit/:id', name: 'PembelisEdit', component: PembelisEdit, props: true },

    // Rute Produk (Tiket diganti menjadi Produk)
    { path: '/product', name: 'ProductsIndex', component: ProductsIndex }, 
    { path: '/product/create', name: 'ProductsCreate', component: ProductsCreate }, 
    { path: '/product/edit/:id', name: 'ProductsEdit', component: ProductsEdit, props: true }, 
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
