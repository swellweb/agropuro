<template>
    <section class="p-6 bg-gray-50 border border-gray-200 rounded-lg shadow-md max-w-full md:max-w-3xl mx-auto">
      <header>
        <button
          @click="toggleAccordion"
          class="w-full flex justify-between items-center text-lg font-semibold text-red-600 focus:outline-none"
        >
          <span>Delete Account</span>
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
        class="mt-4 transition-all duration-300 ease-in-out"
      >
        <p class="text-sm text-gray-600">
          Once your account is deleted, all of its resources and data will be permanently deleted.
        </p>
        <form @submit.prevent="submitForm" class="mt-6 space-y-4">
          <div>
            <label for="password" class="block text-sm font-medium text-gray-700">
              Password
            </label>
            <input
              id="password"
              v-model="password"
              type="password"
              class="w-full mt-1 p-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-red-300 focus:border-red-500"
              placeholder="Enter your password"
            />
            <p v-if="errors.password" class="mt-2 text-sm text-red-600">{{ errors.password }}</p>
          </div>

          <div class="flex flex-col sm:flex-row sm:justify-start gap-4">
            <button
              type="button"
              class="text-gray-600 hover:text-gray-800 py-2 px-4 border border-gray-300 rounded-md"
              @click="cancel"
            >
              Cancel
            </button>
            <button
              type="submit"
              class="bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700"
            >
              Delete Account
            </button>
          </div>
        </form>
      </div>
    </section>
  </template>

  <script>
  export default {
    data() {
      return {
        isOpen: false,
        password: "",
        errors: {},
      };
    },
    methods: {
      toggleAccordion() {
        this.isOpen = !this.isOpen;
      },
      submitForm() {
        this.errors = {};

        // mock
        if (!this.password) {
          this.errors.password = "Password is required.";
        } else {
          alert("Account deleted successfully!");
          this.password = "";
          this.isOpen = false;
        }
      },
      cancel() {
        this.password = "";
        this.isOpen = false;
      },
    },
  };
  </script>
