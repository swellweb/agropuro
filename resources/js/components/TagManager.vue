<template>
    <div class="relative">
      <!-- Input per i tag -->
      <label class="block text-lg font-semibold text-gray-700 mb-2">Tag (max 5)</label>
      <input
        v-model="tagInput"
        @input="searchTags"
        @keydown.enter.prevent="addTag"
        @keydown.backspace="removeLastTag"
        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-gray-800"
        placeholder="Digita un tag e premi Invio o Spazio"
        :disabled="tags.length >= 5"
      />

      <!-- Lista tag inseriti -->
      <div class="mt-2 flex flex-wrap gap-2">
        <span
          v-for="(tag, index) in tags"
          :key="index"
          class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm flex items-center"
        >
          {{ tag }}
          <button @click="removeTag(index)" class="ml-2 text-red-600 hover:text-red-800">x</button>
        </span>
      </div>

      <!-- Suggerimenti -->
      <ul v-if="suggestions.length && tagInput" class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-48 overflow-y-auto">
        <li
          v-for="suggestion in suggestions"
          :key="suggestion.name"
          @click="addTagFromSuggestion(suggestion.name)"
          class="p-2 hover:bg-green-100 cursor-pointer flex justify-between text-gray-800"
        >
          <span>#{{ suggestion.name }}</span>
          <span class="text-gray-500 text-sm">{{ suggestion.usage_count }} utenti</span>
        </li>
      </ul>
    </div>
  </template>

  <script>
  import axios, { getCsrfCookie } from '../bootstrap';
  import debounce from 'lodash/debounce';

  export default {
    name: 'TagManager',
    props: {
      modelValue: {
        type: Array,
        default: () => [],
      },
    },
    data() {
      return {
        tagInput: '',
        tags: [...this.modelValue],
        suggestions: [],
      };
    },
    emits: ['update:modelValue'],
    watch: {
      modelValue(newTags) {
        this.tags = [...newTags];
      },
    },
    methods: {
      addTag() {
        const tag = this.tagInput.trim().toLowerCase();
        if (tag && !this.tags.includes(tag) && this.tags.length < 5) {
          this.tags.push(tag);
          this.tagInput = '';
          this.suggestions = [];
          this.$emit('update:modelValue', this.tags); // Emissione diretta
        }
      },
      addTagFromSuggestion(tag) {
        if (!this.tags.includes(tag) && this.tags.length < 5) {
          this.tags.push(tag);
          this.tagInput = '';
          this.suggestions = [];
          this.$emit('update:modelValue', this.tags); // Emissione diretta
        }
      },
      removeTag(index) {
        this.tags.splice(index, 1);
        this.$emit('update:modelValue', this.tags); // Emissione diretta
      },
      removeLastTag() {
        if (!this.tagInput && this.tags.length > 0) {
          this.tags.pop();
          this.$emit('update:modelValue', this.tags); // Emissione diretta
        }
      },
      searchTags: debounce(async function () {
        const query = this.tagInput.trim().toLowerCase();
        if (!query) {
          this.suggestions = [];
          return;
        }

        try {
          await getCsrfCookie();
          const response = await axios.get('/api/showcase/tags', {
            params: { query }
          });
          this.suggestions = response.data.filter(suggestion => !this.tags.includes(suggestion.name));
        } catch (error) {
          console.error('Errore ricerca tag:', error);
        }
      }, 300),
    },
  };
  </script>
