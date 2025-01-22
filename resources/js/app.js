import './bootstrap';
import { createApp } from 'vue';
import LoginComponent from './components/FormCrowdfunding.vue';
import ProfilePage from './components/ProfilePage.vue';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const app = createApp({});

// Registra il componente globalmente
app.component('form-crowdfunding', LoginComponent);
app.component('profile-page', ProfilePage);

app.mount('#app');
