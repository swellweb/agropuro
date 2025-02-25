<template>
    <div  id="popup" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50">
      <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md relative">
        <button @click="close" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">&times;</button>
        <slot></slot>
      </div>
    </div>
  </template>

  <script>
  export default {
    data(){
        return{
            show: false
        }

    },
    emits: ['close'],
    methods: {
      close() {
        this.$emit('close');
      },
      openPopup(){
        this.show = true
      }
    },
  }
  </script>

  <style scoped>
  .fixed {
    z-index: 50;
  }

  .inset-0 {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
  }

  .flex {
    display: flex;
  }

  .items-center {
    align-items: center;
  }

  .justify-center {
    justify-content: center;
  }

  .bg-gray-800 {
    background-color: rgba(31, 41, 55, 0.8);
  }

  .bg-opacity-50 {
    opacity: 1;
  }

  .bg-white {
    background-color: #ffffff;
  }

  .p-8 {
    padding: 2rem;
  }

  .rounded-lg {
    border-radius: 0.5rem;
  }

  .shadow-lg {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
  }

  .w-full {
    width: 100%;
  }

  .max-w-md {
    max-width: 28rem;
  }

  .absolute {
    position: absolute;
  }

  .top-2 {
    top: 0.5rem;
  }

  .right-2 {
    right: 0.5rem;
  }

  .text-gray-500 {
    color: #6b7280;
  }

  .hover\:text-gray-700:hover {
    color: #374151;
  }
  </style>
