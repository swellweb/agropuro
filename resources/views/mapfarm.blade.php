@extends('layouts.app')

@section('content')
  <!-- Sezione Dettagli Servizi -->
<?php /* <section class="bg-lightGray py-16">
  <div class="container mx-auto px-4">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
      <!-- Connessione Diretta con gli Agricoltori -->
      <div class="bg-white p-8 rounded-lg shadow-xl hover:shadow-2xl transition-shadow duration-300">
        <div class="flex items-center mb-4">
          <img src="/images/icons/farmer.svg" alt="Icona Connessione" class="h-10 w-10 mr-3">
          <h3 class="text-2xl font-bold text-darkGreen">Connessione Diretta con gli Agricoltori</h3>
        </div>
        <p>Con Agropuro hai la possibilità di parlare direttamente con chi coltiva il tuo cibo. Dimentica gli intermediari e scopri il valore della connessione diretta.</p>
      </div>

      <!-- Prodotti Freschi e Sostenibili -->
      <div class="bg-white p-8 rounded-lg shadow-xl hover:shadow-2xl transition-shadow duration-300">
        <div class="flex items-center mb-4">
          <img src="/images/icons/fresh-produce.svg" alt="Icona Prodotti Freschi" class="h-10 w-10 mr-3">
          <h3 class="text-2xl font-bold text-darkGreen">Prodotti Freschi e Sostenibili</h3>
        </div>
        <p>Scegli Agropuro per una spesa che rispetta la stagionalità e la sostenibilità. I nostri agricoltori ti offrono prodotti freschi, a km zero, coltivati con passione.</p>
      </div>

      <!-- Supporto all'Economia Locale -->
      <div class="bg-white p-8 rounded-lg shadow-xl hover:shadow-2xl transition-shadow duration-300">
        <div class="flex items-center mb-4">
          <img src="/images/icons/local-support.svg" alt="Icona Supporto Locale" class="h-10 w-10 mr-3">
          <h3 class="text-2xl font-bold text-darkGreen">Supporto all'Economia Locale</h3>
        </div>
        <p>Ogni acquisto su Agropuro è un investimento nella tua comunità. Supporta gli agricoltori locali e promuovi un'economia più sana e sostenibile.</p>
      </div>
    </div>
  </div>
</section>
*/ ?>
  <!-- Sezione Mappa -->
  <section class="bg-beige py-10">
    <div class="w-full flex">
      <!-- Sezione Mappa -->
      <div class="w-3/4">
        <div class="bg-lightGray rounded-lg shadow-lg p-4 h-full">
          <h2 class="text-2xl font-bold mb-4 text-darkGreen">Trova gli agricoltori vicino a te</h2>
          <div id="map" class="map-container h-[600px] rounded-lg"></div>
        </div>
      </div>

      <!-- Sidebar Filtri -->
      <div class="w-1/4 pl-8">
        <div class="bg-lightGray rounded-lg shadow-lg p-6 h-full">
          <h3 class="text-xl font-bold mb-4 text-darkGreen">Trova gli agricoltori vicino a te</h3>
          <p class="mb-4 text-darkGreen">Usa i filtri qui sotto per affinare la ricerca:</p>
            <!-- Input per Ricerca Indirizzo -->
            <div class="mb-4">
            <label for="address" class="block font-bold mb-2 text-darkGreen">Inserisci il tuo indirizzo</label>
            <input type="text" id="address" name="address" class="w-full p-2 rounded border border-darkGreen" placeholder="Es. Via Roma, Milano">
            <button id="search-button" class="bg-mintGreen text-white font-bold py-2 px-4 rounded hover:bg-darkGreen mt-4 w-full">Ricerca</button>
          </div>
          <button id="clear-map-button" class="bg-mintGreen text-white font-bold py-2 px-4 rounded hover:bg-darkGreen mb-4 w-full">Pulisci la Mappa</button>

          <div class="mb-4">
            <label for="product-type" class="block font-bold mb-2 text-darkGreen">Tipo di Prodotto</label>
            <div class="grid grid-cols-2 gap-4">
              <div class="flex items-center">
                <img src="{{ asset('images/icons/organic.svg') }}" alt="Icona Organico" class="h-8 w-8 mr-2">
                <input type="checkbox" id="organic" class="mr-2">
                <label for="organic" class="text-darkGreen">Organico</label>
              </div>
              <div class="flex items-center">
                <img src="{{ asset('images/icons/artisan.svg') }}" alt="Icona Artigianale" class="h-8 w-8 mr-2">
                <input type="checkbox" id="artisan" class="mr-2">
                <label for="artisan" class="text-darkGreen">Artigianale</label>
              </div>
              <div class="flex items-center">
                <img src="{{ asset('images/icons/agricultural.svg') }}" alt="Icona Agricolo" class="h-8 w-8 mr-2">
                <input type="checkbox" id="agricultural" class="mr-2">
                <label for="agricultural" class="text-darkGreen">Agricolo</label>
              </div>
              <div class="flex items-center">
                <img src="{{ asset('images/icons/delivery.svg') }}" alt="Icona Consegna" class="h-8 w-8 mr-2">
                <input type="checkbox" id="delivery" class="mr-2">
                <label for="delivery" class="text-darkGreen">Consegna Disponibile</label>
              </div>
            </div>
          </div>

          <button class="bg-mintGreen text-darkGreen font-bold py-2 px-4 rounded hover:bg-darkGreen w-full">Torna alla Homepage</button>
          <button class="bg-mintGreen text-darkGreen font-bold py-2 px-4 rounded hover:bg-darkGreen w-full mt-4">Contattaci</button>
             <!-- Descrizione del Sito -->
             <div class="mt-6">
            <h4 class="font-bold text-lg mb-2 text-darkGreen">Agropuro</h4>
            <p class="text-darkGreen">Agropuro è un portale innovativo progettato per avvicinare le persone all'agricoltura locale e agli agricoltori, eliminando la necessità delle grandi distribuzioni.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

   <!-- Sezione Prodotti in Primo Piano Sotto la Mappa -->
   <section class="bg-lightGray py-10">
    <div class="container mx-auto">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
          <img src="{{ asset('images/verdure_fresche.webp') }}" alt="Verdure Fresche" class="h-32 w-full object-cover mb-4">
          <h3 class="text-xl font-bold mb-2 text-darkGreen">Verdure Fresche</h3>
          <p class="text-darkGreen">Verdure fresche coltivate localmente direttamente dalla fattoria alla tua tavola.</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
          <img src="{{ asset('images/frutta_fresca.webp') }}" alt="Frutta Organica" class="h-32 w-full object-cover mb-4">
          <h3 class="text-xl font-bold mb-2 text-darkGreen">Frutta Organica</h3>
          <p class="text-darkGreen">Deliziosa frutta organica coltivata con pratiche agricole sostenibili.</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
          <img src="{{ asset('images/latticini_casario.webp') }}" alt="Prodotti Lattiero-caseari" class="h-32 w-full object-cover mb-4">
          <h3 class="text-xl font-bold mb-2 text-darkGreen">Prodotti Lattiero-caseari</h3>
          <p class="text-darkGreen">Prodotti lattiero-caseari freschi provenienti da fattorie locali con cura.</p>
        </div>
      </div>
    </div>
  </section>




  <!-- Aggiungi Leaflet.js per la Funzionalità della Mappa Gratuita -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  @vite('resources/js/map.js')
@endsection
