<template>
    <section class="p-6 bg-gray-50 border border-gray-200 rounded-lg shadow-md max-w-full md:max-w-3xl mx-auto">
      <header>
        <h2 class="text-lg font-semibold text-green-700">
          User Information
        </h2>
        <p class="text-sm text-gray-600">
          View your account details below.
        </p>
      </header>
      <div class="mt-6 space-y-4">
        <div class="flex flex-col sm:flex-row justify-start items-start sm:items-center">
          <span class="font-medium text-gray-800">Name:</span>
          <span class="text-gray-600 sm:ml-2">
            {{ user.name }}
          </span>
        </div>

        <div class="flex flex-col sm:flex-row justify-start items-start sm:items-center">
          <span class="font-medium text-gray-800">Email:</span>
          <span class="text-gray-600 sm:ml-2">
            {{ user.email }}
          </span>
        </div>

        <div class="flex flex-col sm:flex-row justify-start items-start sm:items-center">
          <span class="font-medium text-gray-800">Joined:</span>
          <span class="text-gray-600 sm:ml-2">
            {{ joinedDate }}
          </span>
        </div>
      </div>
    </section>
  </template>

  <script>
  export default {
    props: {
      user: {
        type: Object,
        required: true,
      },
    },
    computed: {
      joinedDate() {
        return new Date(this.user.created_at).toLocaleDateString(undefined, {
          year: 'numeric',
          month: 'long',
          day: 'numeric',
        });
      },
    },
  };
  </script>

