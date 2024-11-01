@extends('layouts.app')

@section('content')

<main class="bg-lightGray ">


    <!-- Elementi Grafici del Header -->

    <!-- Sezione Hero con Illustrazione Agricola -->
    <section class="relative w-full h-[600px] overflow-hidden">
        <img src="/images/hero-agriculture.webp" alt="Scena Agricola" class="w-full h-full object-cover">

        <div class="absolute top-0 left-0 w-full h-full flex flex-col items-center justify-center text-center text-white bg-black bg-opacity-40">
            <h2 class="text-5xl font-extrabold mb-4">Prodotti Freschi, Locali</h2>
            <p class="text-lg mb-8">Provenienti direttamente dagli agricoltori, senza intermediari, per garantire qualità e freschezza.</p>
            <a href="/mappa-agricoltori" class="bg-yellow-400 text-darkGreen font-bold py-3 px-8 rounded-full shadow-lg hover:bg-yellow-500 transition-all duration-300">Scopri gli Agricoltori Vicino a Te</a>
        </div>

    </section>
     <!-- Sezione Anteprima dei Farmer -->
   <!-- Sezione Anteprima dei Farmer -->
   <section class="py-16 bg-lightGray">
    <div class="container mx-auto px-4">
      <h2 class="text-4xl font-bold text-darkGreen text-center mb-10">I Nostri Agricoltori</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
        @foreach ($farmers as $farmer)
        <!-- Farmer Card -->
        <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition-shadow duration-300">
          <img src="{{ $farmer->image_url ?? '/images/farmers/default.jpg' }}" alt="{{ $farmer->name }}" class="w-full h-48 object-cover rounded-md mb-4">
          <h3 class="text-2xl font-bold text-darkGreen mb-2">{{ $farmer->name }}</h3>
          <p class="text-darkGray mb-4">Prodotti: {{ $farmer->product }}</p>
          <a href="/farmers/{{ $farmer->id }}" class="bg-green-400 text-white font-bold py-2 px-6 rounded-full hover:bg-green-500 transition-all duration-300">Visita la Vetrina</a>
        </div>
        @endforeach
      </div>
    </div>
  </section>
    <!-- Sezione Prodotti in Primo Piano -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <!-- Box Prodotto -->
                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <img src="/images/tomato.png" alt="Pomodoro" class=" mx-auto mb-4" width="180" height="180">
                    <h3 class="text-2xl font-bold text-darkGreen mb-2">Pomodori Freschi</h3>
                    <p>Coltivati localmente e consegnati freschi direttamente dalla terra alla tua tavola.</p>
                </div>
                <!-- Box Prodotto -->
                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <img src="/images/grape.png" alt="Uva" class=" mx-auto mb-4" width="180" height="180">
                    <h3 class="text-2xl font-bold text-darkGreen mb-2">Uva Succosa</h3>
                    <p>Uva coltivata in vigneti locali, raccolta a mano per garantire qualità.</p>
                </div>
                <!-- Box Prodotto -->
                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                <img src="/images/carrots.png" alt="Uva" class=" mx-auto mb-4" width="180" height="180">
                    <h3 class="text-2xl font-bold text-darkGreen mb-2">Carote Croccanti</h3>
                    <p>Carote fresche e croccanti, coltivate con amore e senza pesticidi.</p>
                </div>
                <!-- Box Prodotto -->
                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                <img src="/images/apple.png" alt="Uva" class=" mx-auto mb-4" width="180" height="180">
                    <h3 class="text-2xl font-bold text-darkGreen mb-2">Mele Croccanti</h3>
                    <p>Mele fresche e mature, coltivate in frutteti sostenibili.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Sezione di Invito alla Partecipazione -->
 <!-- Sezione di Invito alla Partecipazione con Mission e Vision -->
 <section class="bg-lightGray py-16">
    <div class="container mx-auto px-4 flex flex-col md:flex-row items-center">
      <div class="md:w-1/2 mb-8 md:mb-0">
        <img src="/images/crowdfunding.webp" alt="Unisciti a Noi" class="w-full rounded-lg shadow-lg">
      </div>
      <div class="md:w-1/2 md:pl-16">
        <h2 class="text-4xl font-bold text-darkGreen mb-6">Credi nel Nostro Progetto?</h2>
        <p class="text-lg mb-6">Sostieni Agropuro e aiutaci a realizzare una piattaforma che connette le persone all'agricoltura locale. Se credi nella nostra missione di sostenibilità e prodotti freschi, considera di apportare fondi per supportare la nostra crescita.</p>
        <h3 class="text-3xl font-bold text-darkGreen mt-10 mb-4">La Nostra Mission</h3>
        <p class="text-lg mb-6">La nostra missione è creare un legame diretto tra i consumatori e gli agricoltori locali, promuovendo un'agricoltura sostenibile, a chilometro zero e garantendo prodotti freschi e genuini per tutti.</p>
        <h3 class="text-3xl font-bold text-darkGreen mt-10 mb-4">La Nostra Vision</h3>
        <p class="text-lg mb-6">Immaginiamo un futuro in cui ogni comunità abbia accesso diretto ai produttori locali, riducendo l'impatto ambientale e supportando l'economia rurale, attraverso una piattaforma innovativa che rende l'agricoltura sostenibile accessibile a tutti.</p>
        <a href="/crowdfunding" class="bg-green-400 text-white font-bold py-3 px-8 rounded-full hover:bg-green-500 transition-all duration-300">Partecipa al Progetto</a>
      </div>
    </div>
  </section>
</main>

</main>
@endsection
