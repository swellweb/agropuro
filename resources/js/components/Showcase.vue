<template>
    <div class="p-6 bg-gray-50 rounded-lg min-h-screen">
      <!-- Titolo e pulsante principale -->
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-green-700">La tua Vetrina</h1>
        <button @click="showForm = !showForm" class="bg-green-500 hover:bg-green-600 text-white text-lg font-semibold px-6 py-3 rounded-lg shadow-md transition duration-200">
          {{ showForm ? 'Chiudi Form' : 'Aggiungi Prodotto' }}
        </button>
      </div>

      <!-- Form per aggiungere prodotto -->
      <form v-if="showForm" @submit.prevent="aggiungiProdotto" class="bg-white p-6 rounded-lg shadow-lg border border-gray-200">
        <div class="space-y-6">
          <!-- Nome -->
          <div>
            <label class="block text-lg font-semibold text-gray-700 mb-2">Nome del Prodotto</label>
            <input v-model="form.nome" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-gray-800" placeholder="Es. Mela Golden" required maxlength="255" />
          </div>

          <!-- Tipo -->
          <div>
            <label class="block text-lg font-semibold text-gray-700 mb-2">Tipo di Prodotto</label>
            <select v-model="form.tipo" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-gray-800" required>
              <option value="" disabled>Seleziona un tipo</option>
              <option v-for="tipo in tipi" :key="tipo" :value="tipo">{{ tipo }}</option>
            </select>
          </div>

          <!-- Prezzo e Quantità -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-lg font-semibold text-gray-700 mb-2">Prezzo (€)</label>
              <input v-model="form.prezzo" type="number" step="0.01" min="0" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-gray-800" placeholder="Es. 2.50" />
            </div>
            <div>
              <label class="block text-lg font-semibold text-gray-700 mb-2">Quantità</label>
              <input v-model="form.quantita_disponibile" type="number" min="0" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-gray-800" placeholder="Es. 10" required />
            </div>
          </div>

          <!-- Unità di misura -->
          <div>
            <label class="block text-lg font-semibold text-gray-700 mb-2">Unità di Misura</label>
            <select v-model="form.unita_misura" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-gray-800" required>
              <option value="kg">Kg</option>
              <option value="litri">Litri</option>
              <option value="pezzi">Pezzi</option>
            </select>
          </div>

          <!-- Immagine -->
          <div>
            <label class="block text-lg font-semibold text-gray-700 mb-2">Immagine del Prodotto</label>
            <input type="file" @change="onFileChange($event, 'immagine')" accept="image/*" class="w-full p-3 border border-gray-300 rounded-lg text-gray-800" />
            <p class="text-sm text-gray-500 mt-1">Massimo 2MB (opzionale)</p>
          </div>

          <!-- Video (solo mensile/gold) -->
          <div v-if="subscription !== 'base'">
            <label class="block text-lg font-semibold text-gray-700 mb-2">Video del Prodotto</label>
            <input type="file" @change="onFileChange($event, 'video')" accept="video/mp4" class="w-full p-3 border border-gray-300 rounded-lg text-gray-800" />
            <p class="text-sm text-gray-500 mt-1">Massimo 10MB, solo MP4 (opzionale)</p>
          </div>

          <!-- Galleria (solo gold) -->
          <div v-if="subscription === 'gold'">
            <label class="block text-lg font-semibold text-gray-700 mb-2">Galleria di Immagini</label>
            <input type="file" multiple @change="onFileChange($event, 'galleria')" accept="image/*" class="w-full p-3 border border-gray-300 rounded-lg text-gray-800" />
            <p class="text-sm text-gray-500 mt-1">Massimo 2MB per immagine (opzionale)</p>
          </div>

          <!-- Descrizione -->
          <div>
            <label class="block text-lg font-semibold text-gray-700 mb-2">Descrizione</label>
            <textarea v-model="form.descrizione" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-gray-800" placeholder="Descrivi il tuo prodotto" rows="4"></textarea>
          </div>

          <!-- Tag -->
          <div>
            <label class="block text-lg font-semibold text-gray-700 mb-2">Tag</label>
            <input v-model="tagInput" @keyup.enter="addTag" @keyup.space="addTag" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-gray-800" placeholder="Aggiungi tag (Invio o Spazio)" />
            <div class="mt-2 flex flex-wrap gap-2">
              <span v-for="(tag, index) in form.tag" :key="index" class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                {{ tag }} <button @click="removeTag(index)" class="ml-2 text-red-600 hover:text-red-800">x</button>
              </span>
            </div>
          </div>

          <!-- Stagionalità e Certificazioni -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-lg font-semibold text-gray-700 mb-2">Stagionalità</label>
              <input v-model="form.stagionalita" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-gray-800" placeholder="Es. Primavera" />
            </div>
            <div>
              <label class="block text-lg font-semibold text-gray-700 mb-2">Certificazioni</label>
              <input v-model="form.certificazioni" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-gray-800" placeholder="Es. Bio, DOP" />
            </div>
          </div>
        </div>

        <!-- Pulsante di invio -->
        <button type="submit" class="mt-6 w-full bg-blue-500 hover:bg-blue-600 text-white text-lg font-semibold px-6 py-3 rounded-lg shadow-md transition duration-200">
          Salva Prodotto
        </button>
      </form>

      <!-- Lista prodotti -->
      <div v-if="products.length" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mt-6">
        <div v-for="product in products" :key="product.id" class="bg-white p-4 rounded-lg shadow-md border border-gray-200">
          <img :src="product.immagine" class="w-full h-48 object-cover rounded-t-lg" />
          <div class="p-4">
            <h2 class="text-xl font-semibold text-gray-800">{{ product.nome }}</h2>
            <p class="text-gray-600">{{ product.tipo }} - {{ product.quantita_disponibile }} {{ product.unita_misura }}</p>
            <p v-if="product.prezzo" class="text-green-600 font-bold">{{ product.prezzo }} €</p>
          </div>
        </div>
      </div>
      <p v-else class="text-gray-500 text-center mt-6">Nessun prodotto nella tua vetrina. Aggiungine uno!</p>
    </div>
  </template>

  <script>
  import axios from 'axios';

  export default {
    name: 'Vetrina',
    data() {
      return {
        products: [],
        showForm: false,
        subscription: '',
        form: {
          nome: '',
          descrizione: '',
          tipo: '',
          prezzo: '',
          quantita_disponibile: '',
          unita_misura: 'kg',
          immagine: null,
          video: null,
          galleria: [],
          tag: [],
          stagionalita: '',
          certificazioni: '',
        },
        tagInput: '',
        tipi: [
          'Frutta', 'Verdura', 'Lattiero-Caseari', 'Cereali', 'Legumi',
          'Prodotti Trasformati','Miele e Derivati', 'Bevande', 'Vino'
        ],
      };
    },
    mounted() {
      this.loadProducts();
      this.loadUserInfo();
    },
    methods: {
      async loadProducts() {
        try {
          const response = await axios.get('/api/showcase', {
            headers: { Authorization: `Bearer ${localStorage.getItem('token')}` },
          });
          this.products = response.data;
        } catch (error) {
          console.error('Errore caricamento prodotti:', error);
        }
      },
      async loadUserInfo() {
        try {
          const response = await axios.get('/api/user', {
            headers: { Authorization: `Bearer ${localStorage.getItem('token')}` },
          });
          this.subscription = response.data.subscription;
        } catch (error) {
          console.error('Errore caricamento info utente:', error);
          this.subscription = 'base';
        }
      },
      onFileChange(event, field) {
        if (field === 'galleria') {
          this.form[field] = Array.from(event.target.files);
        } else {
          this.form[field] = event.target.files[0];
        }
      },
      addTag() {
        if (this.tagInput.trim()) {
          this.form.tag.push(this.tagInput.trim());
          this.tagInput = '';
        }
      },
      removeTag(index) {
        this.form.tag.splice(index, 1);
      },
      async aggiungiProdotto() {
        const formData = new FormData();
        for (const key in this.form) {
          if (key === 'tag') {
            formData.append('tag', JSON.stringify(this.form.tag));
          } else if (key === 'galleria') {
            this.form.galleria.forEach((file, index) => {
              formData.append(`galleria[${index}]`, file);
            });
          } else if (this.form[key] !== null && this.form[key] !== '') {
            formData.append(key, this.form[key]);
          }
        }

        try {
          const response = await axios.post('/api/showcase', formData, {
            headers: {
              Authorization: `Bearer ${localStorage.getItem('token')}`,
              'Content-Type': 'multipart/form-data',
            },
          });
          this.products.push(response.data);
          this.showForm = false;
          this.form = {
            nome: '', descrizione: '', tipo: '', prezzo: '', quantita_disponibile: '',
            unita_misura: 'kg', immagine: null, video: null, galleria: [], tag: [],
            stagionalita: '', certificazioni: '',
          };
        } catch (error) {
          console.error('Errore aggiunta prodotto:', error.response?.data || error.message);
        }
      },
    },
  };
  </script>
