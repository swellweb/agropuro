import './bootstrap';
import { createApp } from 'vue';
import LoginComponent from './components/FormCrowdfunding.vue';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const app = createApp({});

// Registra il componente globalmente
app.component('form-crowdfunding', LoginComponent);

app.mount('#app');
