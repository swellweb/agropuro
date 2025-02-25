<template>
    <section class="p-4 bg-gray-50 border border-gray-200 rounded-lg shadow-md max-w-md mx-auto">
        <button
            @click="logout"
            class="w-full bg-red-700 text-white py-2 px-4 rounded-md hover:bg-red-800"
        >
            Logout
        </button>
    </section>
</template>

<script>
import axios, { getCsrfCookie } from '../bootstrap';

export default {
    methods: {
        async logout() {
            try {
                // Richiedi il cookie CSRF prima di inviare la richiesta
                await getCsrfCookie();

                // Invia la richiesta per effettuare il logout
                await axios.post('/api/logout');

                // Reindirizza all'url di login dopo il logout
                window.location.href = '/login';
            } catch (error) {
                console.error('Errore durante il logout:', error);
                alert('Si è verificato un errore durante il logout. Riprova.');
            }
        },
    },
};
</script>

<style scoped>
/* Aggiungi eventuali stili personalizzati qui */
</style>
