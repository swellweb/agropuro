<template>
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8 my-12">
      <UserInfo :user="user" />
      <div v-if="showcase">
        <Showcase />
      </div>
      <UpdateProfile :user="user" @update-profile="updateProfile" />
      <UpdatePassword :user="user" @update-password="updatePassword" />
      <DeleteAccount :user="user" @delete-account="deleteAccount" />
    </div>
  </template>

  <script>
  import UserInfo from './UserInfo.vue';
  import UpdateProfile from './UpdateProfile.vue';
  import UpdatePassword from './UpdatePassword.vue';
  import DeleteAccount from './DeleteAccount.vue';
  import Showcase from './Showcase.vue';

  export default {
    components: {
      UserInfo,
      UpdateProfile,
      UpdatePassword,
      DeleteAccount,
      Showcase,
    },
    props: {
        user: {
            type: Object,
            required: true,
        },
        showcase: {
            type: Boolean,
            default: false,
        }
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
