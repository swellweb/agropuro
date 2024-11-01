<template>
    <div class="register-form-container">
      <form @submit.prevent="handleRegister">
        <div class="mb-4">
          <label for="name" class="block text-lg font-bold mb-2">Nome Completo</label>
          <input
            type="text"
            id="name"
            v-model="form.name"
            class="w-full p-2 border rounded-lg"
            placeholder="Es. Mario Rossi"
            required
          />
        </div>
        <div class="mb-4">
          <label for="email" class="block text-lg font-bold mb-2">Email</label>
          <input
            type="email"
            id="email"
            v-model="form.email"
            class="w-full p-2 border rounded-lg"
            placeholder="Es. mario.rossi@email.com"
            required
          />
        </div>
        <div class="mb-4">
          <label for="password" class="block text-lg font-bold mb-2">Password</label>
          <input
            type="password"
            id="password"
            v-model="form.password"
            class="w-full p-2 border rounded-lg"
            placeholder="La tua password"
            required
          />
        </div>
        <div class="mb-4">
          <label for="password_confirmation" class="block text-lg font-bold mb-2">Conferma Password</label>
          <input
            type="password"
            id="password_confirmation"
            v-model="form.password_confirmation"
            class="w-full p-2 border rounded-lg"
            placeholder="Conferma la tua password"
            required
          />
        </div>
        <button type="submit" class="bg-green-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-green-600 transition-all duration-300" :disabled="loading">
          <span v-if="loading">Registrazione in corso...</span>
          <span v-else>Registrati</span>
        </button>
      </form>
      <p class="mt-4 text-center">
        Hai già un account? <a href="#" @click.prevent="$emit('showLogin')" class="text-blue-500 hover:underline">Accedi qui</a>
      </p>
    </div>
  </template>

  <script>
import axios from 'axios';

  export default {
    name: 'RegisterForm',
    props: {
      email: {
        type: String,
        default: ''
      }
    },
    data() {
      return {
        form: {
          name: '',
          email: this.email,
          password: '',
          password_confirmation: ''
        },
        loading: false
      };
    },
    methods: {
     async  handleRegister() {
        // Controlla se tutti i campi sono compilati
        if (!this.form.name || !this.form.email || !this.form.password || !this.form.password_confirmation) {
          alert('Per favore, compila tutti i campi.');
          return;
        }

        // Controlla se la password è forte
        if (!this.isStrongPassword(this.form.password)) {
          alert('La password deve contenere almeno 8 caratteri, inclusi lettere maiuscole, numeri e simboli.');
          return;
        }

        // Controlla se la password di conferma corrisponde
        if (this.form.password !== this.form.password_confirmation) {
          alert('La password di conferma non corrisponde.');
          return;
        }

        this.loading = true;
        // Effettua la registrazione tramite Inertia
        try {
            const response = await axios.post('/register',this.form )
            if (response.status === 201) {
                window.location.href = '/dashboard'; // Reindirizza l'utente alla dashboard
            }

            }
            catch (error) {
                if (error.response && error.response.status === 422) {
                console.error('Errore di validazione:', error.response.data.errors);
                alert('Errore durante la registrazione. Controlla i dati inseriti e riprova.');
                }
            console.error('Errore durante la registrazione', error);
            alert('Errore durante la registrazione, riprova.');
        }
      },
      isStrongPassword(password) {
        // Controlla se la password è forte: almeno 8 caratteri, una lettera maiuscola, un numero e un simbolo
        const strongPasswordRegex = /^(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{8,})/;
        return strongPasswordRegex.test(password);
      }
    }
  };
  </script>

  <style scoped>
  .register-form-container {
    background-color: #ffffff;
    padding: 2rem;
    border-radius: 0.5rem;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    max-width: 400px;
    margin: 0 auto;
  }
  </style>
