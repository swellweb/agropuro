<template>
    <div class="login-form-container">
      <form @submit.prevent="handleLogin">
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
        <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600 transition-all duration-300">Accedi</button>
      </form>
    </div>
  </template>

  <script>
  export default {
    name: 'LoginForm',
    data() {
      return {
        form: {
          email: '',
          password: ''
        }
      };
    },
    methods: {
      async handleLogin() {
        try {
          const response = await axios.post('/login', this.form)
          if (response.status === 200) {
            window.location.reload();
          }
        } catch (error) {
          console.error('Errore durante l\'accesso', error);
          alert('Credenziali non valide, riprova.');
        }
      }
    }
  };
  </script>

  <style scoped>
  .login-form-container {
    background-color: #ffffff;
    padding: 2rem;
    border-radius: 0.5rem;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    max-width: 400px;
    margin: 0 auto;
  }
  </style>
