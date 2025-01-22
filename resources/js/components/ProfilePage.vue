<template>
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8 my-12">
      <UserInfo :user="user" />
      <UpdateProfile :user="user" @update-profile="updateProfile" />
      <UpdatePassword @update-password="updatePassword" />
      <DeleteAccount @delete-account="deleteAccount" />
    </div>
  </template>

  <script>
  import UserInfo from './UserInfo.vue';
  import UpdateProfile from './UpdateProfile.vue';
  import UpdatePassword from './UpdatePassword.vue';
  import DeleteAccount from './DeleteAccount.vue';

  export default {
    components: {
      UserInfo,
      UpdateProfile,
      UpdatePassword,
      DeleteAccount,
    },
    props: {
        user: {
            type: Object,
            required: true,
        },
    },
    data() {
      return {
      }
    },
    methods: {
      updateProfile(data) {
        console.log('Updating profile with:', data);
      },
      updatePassword(data) {
        console.log('Updating password with:', data);
      },
      deleteAccount() {
        console.log('Deleting account');
      },
    },
  };
  </script>
