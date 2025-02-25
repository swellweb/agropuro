import './bootstrap';

import { createApp } from 'vue';
import Login from './components/Login.vue';
import UpdatePassword from './components/UpdatePassword.vue';
import Register from './components/Register.vue';
import Logout from './components/Logout.vue'; // Nuovo componente per il logout
import ProfilePage from './components/ProfilePage.vue';

const app = createApp({});

// Registra il componente globalmente

app.component('login', Login);
app.component('logout', Logout);
app.component('update-password', UpdatePassword);
app.component('register', Register);
app.component('profile-page', ProfilePage);


app.mount('#app');
