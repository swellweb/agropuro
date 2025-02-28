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
                <div class="md:col-span-2">
                    <tag-manager v-model="form.tag" />
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
            <div v-for="product in products" :key="product.id" class="bg-white p-4 rounded-lg shadow-md border border-gray-200 relative group" @click="editProduct(product)">
                <img :src="product.immagine" class="w-full h-48 object-cover rounded-t-lg" />
                <div class="p-4">
                    <h2 class="text-xl font-semibold text-gray-800">{{ product.nome }}</h2>
                    <p class="text-gray-600">{{ product.tipo }} - {{ product.quantita_disponibile }} {{ product.unita_misura }}</p>
                    <p v-if="product.prezzo" class="text-green-600 font-bold">{{ product.prezzo }} €</p>
                    <p v-if="product.tags && product.tags.length" class="text-gray-500 text-sm mt-1">
                        Tag: {{ product.tags.map(tag => tag.name).join(', ') }}
                      </p>
                    <!-- Pulsante X visibile all'hover -->
                    <button @click.stop="confirmDelete(product.id)" class="absolute top-2 right-2 bg-red-500 text-white w-6 h-6 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                                X
                                            </button>
                </div>
            </div>
        </div>
        <p v-else class="text-gray-500 text-center mt-6">Nessun prodotto nella tua vetrina. Aggiungine uno!</p>
        <!-- Modale di conferma eliminazione -->
        <div v-if="showDeleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-lg font-semibold mb-4">Conferma Eliminazione</h3>
                <p>Sei sicuro di voler rimuovere questo prodotto?</p>
                <div class="mt-4 flex justify-end gap-4">
                    <button @click="showDeleteModal = false" class="bg-gray-300 text-gray-800 px-4 py-2 rounded">Annulla</button>
                    <button @click="deleteProduct" class="bg-red-500 text-white px-4 py-2 rounded">Elimina</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import TagManager from "./TagManager.vue";
import axios, { getCsrfCookie } from '../bootstrap';

export default {
    name: 'Showcase',
    components: {
        TagManager,
    },
    data() {
        return {
            products: [],
            showForm: false,
            editMode: false,
            editingProductId: null,
            showDeleteModal: false,
            deletingProductId: null,
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
                'Prodotti Trasformati', 'Miele e Derivati', 'Bevande', 'Vino'
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
                await getCsrfCookie();
                const response = await axios.get('/api/showcase');
                this.products = response.data;
            } catch (error) {
                console.error('Errore caricamento prodotti:', error);
            }
        },
        async loadUserInfo() {
            try {
                await getCsrfCookie();
                const response = await axios.get('/api/user');
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

        editProduct(productData) {
            const product  = {...productData};
            this.editMode = true;
            this.showForm = true;
            this.editingProductId = product.id;
            this.form = {
                nome: product.nome,
                descrizione: product.descrizione || '',
                tipo: product.tipo,
                prezzo: product.prezzo || '',
                quantita_disponibile: product.quantita_disponibile,
                unita_misura: product.unita_misura,
                immagine: null, // Non possiamo pre-caricare il file, ma manteniamo il valore corrente nel backend
                video: null,
                galleria: [],
                galleria: [],
                tag: Array.isArray(productData.tags) ? productData.tags.map(tag => tag.name) : [],
                stagionalita: product.stagionalita || '',
                certificazioni: product.certificazioni || '',
            };
        },

        resetForm() {
            this.form = {
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
            };
        },
        async aggiungiProdotto() {
            const formData = new FormData();
            for (const key in this.form) {
                if (key === 'tag') {
                    console.log('Tag prima di inviare:', this.form.tag);
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
                await getCsrfCookie();
                const response = await axios.post('/api/showcase', formData);
                this.products.push(response.data);
                this.showForm = false;
                this.resetForm();
            } catch (error) {
                console.error('Errore aggiunta prodotto:', error.response ? response.data : error.message);
            }
        },

        async modificaProdotto() {
            const formData = new FormData();
            for (const key in this.form) {
                if (key === 'tag') {
                    console.log('Tag prima di inviare:', this.form.tag);
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
                await getCsrfCookie();
                const response = await axios.put(`/api/showcase/${this.editingProductId}`, formData);
                const index = this.products.findIndex(p => p.id === this.editingProductId);
                this.products.splice(index, 1, response.data);
                this.showForm = false;
                this.editMode = false;
                this.resetForm();
            } catch (error) {
                console.error('Errore modifica prodotto:', error.response ? response.data : error.message);
            }
        },
        confirmDelete(id) {
            this.deletingProductId = id;
            this.showDeleteModal = true;
        },
        async deleteProduct() {
            try {
                await getCsrfCookie();
                debugger
                await axios.delete(`/api/showcase/${this.deletingProductId}`);
                this.products = this.products.filter(p => p.id !== this.deletingProductId);
                this.showDeleteModal = false;
                this.deletingProductId = null;
            } catch (error) {
                console.error('Errore eliminazione prodotto:', error.response ? repsonse.data : error.message);
            }
        },

    },
};
</script>
