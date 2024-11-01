<template>
    <div class="bg-lightGray p-4 rounded-lg shadow-inner mb-6" id="donation-form">
      <form @submit.prevent="handleSubmit">
        <div class="mb-4">
          <label for="amount" class="block text-lg font-bold mb-2">Importo della Donazione (€)</label>
          <input
            type="number"
            id="amount"
            v-model="form.amount"
            class="w-full p-2 border rounded-lg"
            placeholder="Es. 50"
            required
          />
        </div>
        <div class="mb-4">
          <label for="email-cf" class="block text-lg font-bold mb-2">La Tua Email</label>
          <input
            type="email"
            id="email-cf"
            v-model="form.email_cf"
            class="w-full p-2 border rounded-lg"
            placeholder="Es. mario.rossi@email.com"
            required
          />
        </div>
        <div class="mb-4" v-if="form.name_cf">
          <label for="name" class="block text-lg font-bold mb-2">Il Tuo Nome</label>
          <input
            type="text"
            id="name"
            v-model="form.name_cf"
            class="w-full p-2 border rounded-lg"
            placeholder="Es. Mario Rossi"
            required
          />
        </div>
        <p class="text-center text-sm text-darkGreen">Ogni contributo è un passo verso un futuro migliore per la nostra terra.</p>
      </form>
      <div v-if="isLoggedIn">
        <button @click="handleDonation" class="w-full bg-green-400 text-white font-bold py-4 px-10 rounded-full shadow-lg hover:bg-green-500 transition-all duration-300 mt-4">Dona Adesso</button>
      </div>
      <div v-else >
      <button @click="handleContinue" class="w-full bg-green-400 text-white font-bold py-4 px-10 rounded-full shadow-lg hover:bg-green-500 transition-all duration-300 mt-4">Continua</button>
      </div>
      <popup v-if="popupVisible && !isLoggedIn" @close="popupVisible = false">
        <template v-slot>
            <div v-if="exist">
               <login-form />
            </div>
            <div v-else>
                <register-form :email="form.email_cf"/>
            </div>
        </template>
      </popup>
    </div>
  </template>

  <script>
  import LoginForm from './LoginForm.vue';
import Popup from './Popup.vue';
  import RegisterForm from './RegisterForm.vue';

  export default {
    components: {
      LoginForm,
      RegisterForm,
      Popup
    },
    data() {
      return {
        form: {
          amount: '',
          email_cf: '',
          name_cf: '',
        },
        popupVisible: false,
        popupComponent: 'LoginForm',
        exist: false,
      }
    },
    created() {
      // Controlla se l'utente è loggato e imposta i dati del form usando le props
      if (this.isLoggedIn) {
        this.form.email_cf = this.user.email;
        this.form.name_cf = this.user.name;
      }
    },
    props: {
      isLoggedIn: {
        type: Boolean,
        required: true
      },
      user: {
        type: Object,
        default: () => ({})
      }
    },
    methods: {
      handleContinue() {
          // Controlla se l'email esiste nel database
          axios.post('/api/check-email', { email: this.form.email_cf })
            .then(response => {
              if (response.data.exists) {
                this.exist = true
              } else {
                this.exist = false
              }
              this.popupVisible = true;
            })
            .catch(error => {
              console.error('Errore durante la verifica dell\'email:', error);
            });
      },
      handleDonation(){
        // Logica per gestire l'invio della donazione
        console.log('Donazione inviata:', this.form);
        // Puoi aggiungere qui la chiamata API per inviare i dati al server
      },
      showRegisterForm() {
        // Logica per mostrare il modulo di registrazione
        console.log('Mostra il modulo di registrazione');
        this.popupComponent = 'RegisterForm';
      }
    }
  }
  </script>

  <style scoped>
  #donation-form {
    background-color: #f7f7f7;
  }
  </style>
