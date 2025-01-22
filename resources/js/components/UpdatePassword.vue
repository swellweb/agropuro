<template>
    <section class="p-6 bg-gray-50 border border-gray-200 rounded-lg shadow-md max-w-full md:max-w-3xl mx-auto">
      <header>
        <button
          @click="toggleAccordion"
          class="w-full text-left flex justify-between items-center text-lg font-semibold text-green-700 focus:outline-none"
        >
          <span>Update Password</span>
          <svg
            :class="{'transform rotate-180': isOpen}"
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
        <form @submit.prevent="submitForm">
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
        </form>
      </div>
    </section>
  </template>

  <script>
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
      };
    },
    methods: {
      toggleAccordion() {
        this.isOpen = !this.isOpen;
      },
      submitForm() {
        this.errors = {};
        this.successMessage = "";

        // mock
        if (this.form.newPassword !== this.form.confirmPassword) {
          this.errors.confirmPassword = "Passwords do not match.";
        } else {
          this.successMessage = "Password updated successfully!";
          this.form = {
            currentPassword: "",
            newPassword: "",
            confirmPassword: "",
          };
        }
      },
    },
  };
  </script>
