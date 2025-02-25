<template>
    <section class="p-6 bg-gray-50 border border-gray-200 rounded-lg shadow-md max-w-full md:max-w-3xl mx-auto">
      <header>
        <button
          @click="toggleAccordion"
          class="w-full text-left flex justify-between items-center text-lg font-semibold text-green-700 focus:outline-none"
        >
          <span>Update Password</span>
          <svg
            :class="{ 'transform rotate-180': isOpen }"
            class="h-5 w-5 transition-transform duration-200"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path
              fill-rule="evenodd"
              d="M5.293 9.293a1 1 0 011.414 0L10 12.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
              clip-rule="evenodd"
            />
          </svg>
        </button>
      </header>
      <div
        v-show="isOpen"
        class="mt-4"
        style="overflow: hidden; transition: max-height 0.3s ease;"
      >
        <form @submit.prevent="updatePassword">
          <div class="mt-4">
            <label for="currentPassword" class="block text-sm font-medium text-gray-700">
              Current Password
            </label>
            <input
              id="currentPassword"
              v-model="form.currentPassword"
              type="password"
              class="w-full mt-1 p-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-300 focus:border-green-500"
            />
            <p v-if="errors.currentPassword" class="mt-2 text-sm text-red-600">{{ errors.currentPassword }}</p>
          </div>
          <div class="mt-4">
            <label for="newPassword" class="block text-sm font-medium text-gray-700">
              New Password
            </label>
            <input
              id="newPassword"
              v-model="form.newPassword"
              type="password"
              class="w-full mt-1 p-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-300 focus:border-green-500"
            />
            <p v-if="errors.newPassword" class="mt-2 text-sm text-red-600">{{ errors.newPassword }}</p>
          </div>
          <div class="mt-4">
            <label for="confirmPassword" class="block text-sm font-medium text-gray-700">
              Confirm Password
            </label>
            <input
              id="confirmPassword"
              v-model="form.confirmPassword"
              type="password"
              class="w-full mt-1 p-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-300 focus:border-green-500"
            />
            <p v-if="errors.confirmPassword" class="mt-2 text-sm text-red-600">{{ errors.confirmPassword }}</p>
          </div>
          <button
            type="submit"
            class="mt-6 bg-green-700 text-white py-2 px-4 rounded-md hover:bg-green-800"
          >
            Save
          </button>
          <p v-if="successMessage" class="mt-2 text-sm text-green-600">{{ successMessage }}</p>
          <p v-if="errorMessage" class="mt-2 text-sm text-red-600">{{ errorMessage }}</p>
        </form>
      </div>
    </section>
  </template>

  <script>
  import axios, { getCsrfCookie } from "../bootstrap";

  export default {
    data() {
      return {
        isOpen: false,
        form: {
          currentPassword: "",
          newPassword: "",
          confirmPassword: "",
        },
        errors: {},
        successMessage: "",
        errorMessage: "", // Nuovo campo per gestire messaggi di errore generici
      };
    },
    methods: {
      toggleAccordion() {
        this.isOpen = !this.isOpen;
      },
      async updatePassword() {
        this.errors = {};
        this.successMessage = "";
        this.errorMessage = ""; // Resetta eventuali errori precedenti

        try {
          // Richiedi il token CSRF da Sanctum
          await getCsrfCookie();

          // Effettua la richiesta per aggiornare la password
          const response = await axios.post("/api/update-password", {
            old_password: this.form.currentPassword,
            new_password: this.form.newPassword,
            new_password_confirmation: this.form.confirmPassword,
          });

          // Gestisci la risposta di successo
          this.successMessage = response.data.message || "Password aggiornata con successo!";
          this.form = { currentPassword: "", newPassword: "", confirmPassword: "" }; // Pulisci il form
        } catch (error) {
          // Gestisci gli errori della richiesta
          if (error.response && error.response.data) {
            if (error.response.status === 422) {
              // Errori di validazione (formato password)
              this.errors = error.response.data.errors || {};
            } else if (error.response.status === 403) {
              // Password attuale non corretta
              this.errors.currentPassword = "La password attuale non è corretta.";
            } else {
              // Altri errori
              this.errorMessage = "Si è verificato un errore. Riprova.";
            }
          } else {
            // Errore generico del server
            this.errorMessage = "Errore del server. Riprova più tardi.";
          }
        }
      },
    },
  };
  </script>
