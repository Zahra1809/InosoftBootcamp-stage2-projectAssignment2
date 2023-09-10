import { createApp } from 'vue';
import ComponentKeranjang from './components/ComponentKeranjang.vue';

const app = createApp({
  // Konfigurasi Vue.js jika diperlukan
});

app.component('component-keranjang', ComponentKeranjang);

app.mount('#app');
