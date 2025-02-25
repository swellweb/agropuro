@extends('layouts.app')

@section('content')

<div class="w-full py-12 flex flex-wrap md:flex-nowrap">
    <div class="w-full md:w-3/4 bg-lightGray p-8 rounded-lg shadow-lg">
        <h1 class="text-5xl font-bold text-center text-darkGreen mb-8">Partecipa al Crowdfunding di Agropuro</h1>
        <p class="text-lg mb-6">
            Agropuro &egrave; un progetto che mira a creare un legame diretto tra i consumatori e gli agricoltori locali, promuovendo un'agricoltura sostenibile, a chilometro zero e garantendo prodotti freschi e genuini. Con il tuo contributo, possiamo costruire una piattaforma innovativa che supporti la crescita dell'economia rurale e riduca l'impatto ambientale.
        </p>

        <div class="flex justify-around flex-wrap">
            <div class="w-full md:w-1/3 bg-white p-6 m-4 rounded-lg shadow-lg">
                <img src="/images/supporto_agricoltori.webp" alt="Supporto agli agricoltori" class="mb-4 rounded-lg">
                <ul class="list-disc pl-8 mb-6">
                    <li class="mb-2">
                        <strong>Supporto agli Agricoltori Locali</strong>: Connettere direttamente i consumatori agli agricoltori significa eliminare gli intermediari, garantire prezzi equi e migliorare la qualit&agrave; della vita dei piccoli produttori.
                    </li>
                    <li class="mb-2">
                        <strong>Sostenibilit&agrave; Ambientale</strong>: Riducendo le distanze di trasporto, contribuiamo a diminuire le emissioni di CO2 e a promuovere pratiche agricole eco-friendly.
                    </li>
                    <li>
                        <strong>Prodotti Genuini e Freschi</strong>: Agropuro punta a garantire prodotti freschi e di qualit&agrave;, coltivati senza l'uso di pesticidi dannosi, direttamente dalla terra alla tavola.
                    </li>
                </ul>
            </div>

            <div class="w-full md:w-1/3 bg-white p-6 m-4 rounded-lg shadow-lg">
                <img src="/images/missione.webp" alt="Missione di Agropuro" class="mb-4 rounded-lg">
                <p class="text-lg mb-6">
                    La nostra missione &egrave; rendere l'agricoltura locale e sostenibile accessibile a tutti, fornendo ai consumatori un modo semplice per acquistare prodotti genuini direttamente dai produttori. Vogliamo costruire un sistema agricolo che favorisca la sostenibilit&agrave; ambientale, l'economia locale e la qualit&agrave; della vita.
                </p>
                <h2 class="text-4xl font-bold text-darkGreen mb-4">La Nostra Visione</h2>
                <p class="text-lg mb-6">
                    Crediamo in un futuro dove le comunit&agrave; possano vivere in sintonia con la natura, sostenendo gli agricoltori locali e consumando prodotti freschi e di qualit&agrave;. Immaginiamo un mondo in cui ogni persona abbia accesso a cibo sano, prodotto con passione e rispetto per l'ambiente.
                </p>
            </div>
        </div>

        <div class="w-full bg-white p-6 m-4 rounded-lg shadow-lg md:flex md:items-center">
            <img src="/images/come_partecipare.webp" alt="Come partecipare al crowdfunding" class="mb-4 rounded-lg md:w-1/3 md:mr-6 md:h-auto">
            <div class="md:w-2/3 flex flex-col justify-center">
                <p class="text-lg mb-6">
                    Unisciti a noi in questa avventura e diventa parte integrante del cambiamento verso un'agricoltura più sostenibile e rispettosa dell'ambiente. Ogni contributo è importante e ci permette di avvicinarci sempre di più alla realizzazione di una piattaforma che mette al centro gli agricoltori locali e i prodotti freschi e genuini. Partecipare al crowdfunding di Agropuro significa dare il proprio supporto a una causa che riguarda tutti: il nostro pianeta e la nostra salute.
                </p>
                <p class="text-lg mb-6">
                    Con il tuo sostegno, possiamo fornire agli agricoltori gli strumenti necessari per migliorare la loro produzione, espandere la loro attività e raggiungere più consumatori che apprezzano la qualità e la trasparenza. Ogni donazione, piccola o grande che sia, contribuirà a costruire una rete solida di persone che credono in un'agricoltura sostenibile e che vogliono fare la differenza per il futuro. Sostieni la nostra iniziativa e aiuta a rendere il cibo sano e locale accessibile a tutti!
                </p>
                <h3 class="text-3xl font-bold text-darkGreen mb-4">Benefici per i Finanziatori</h3>
                <ul class="list-disc pl-8 mb-6">
                    <li class="mb-2">
                        <strong>Accesso Prioritario</strong>: Avrai accesso in anteprima alla piattaforma di Agropuro e potrai ordinare i prodotti locali prima di chiunque altro.
                    </li>
                    <li class="mb-2">
                        <strong>Sconti Esclusivi</strong>: I finanziatori avranno diritto a sconti esclusivi sui prodotti offerti dai nostri agricoltori partner.
                    </li>
                    <li>
                        <strong>Certificato di Supporter</strong>: Riceverai un certificato digitale come riconoscimento del tuo supporto alla sostenibilit&agrave; e all'agricoltura locale.
                    </li>
                </ul>
            </div>
        </div>

        <div class="text-center mt-8">
            <a href="#" class="bg-green-400 text-white font-bold py-4 px-10 rounded-full shadow-lg hover:bg-green-500 transition-all duration-300">Partecipa al Crowdfunding</a>
        </div>

        <h2 class="text-4xl font-bold text-darkGreen mt-12 mb-4">Unisciti alla Rivoluzione Verde</h2>
        <p class="text-lg mb-6">
            Crediamo che il futuro dell'agricoltura sia nelle mani di chi, come te, sceglie di fare la differenza. Aiutaci a realizzare la nostra visione e a portare prodotti freschi e locali sulle tavole di tutte le famiglie. Insieme possiamo creare un cambiamento reale, sostenibile e duraturo.
        </p>
    </div>

    <!-- Sidebar per partecipare al crowdfunding con elementi di gamification -->
    <div class="w-full md:w-1/4 md:ml-8 bg-white p-6 rounded-lg shadow-lg md:block">
        <h2 class="text-3xl font-bold text-darkGreen mb-4">Fai una Donazione</h2>
        <p class="text-lg mb-4">Contribuisci oggi e sostieni il futuro dell'agricoltura sostenibile. Ogni donazione fa la differenza e ti rende parte di un cambiamento positivo e duraturo.</p>
        <div class="bg-green-100 p-4 rounded-lg shadow-inner mb-6">
            <h3 class="text-2xl font-bold text-darkGreen mb-4">Raggiungi i Livelli di Sostenitore!</h3>
            <ul class="list-none mb-4">
                <li class="mb-2">
                    <strong>🌱 Sostenitore della Terra (€10+)</strong>: Aiuta a piantare nuovi alberi e a migliorare la biodiversità.
                </li>
                <li class="mb-2">
                    <strong>🌿 Custode del Verde (€50+)</strong>: Supporta direttamente un agricoltore locale e ottieni uno sconto esclusivo sui prodotti.
                </li>
                <li class="mb-2">
                    <strong>🌳 Ambasciatore della Natura (€100+)</strong>: Diventa un vero ambasciatore, ricevi premi esclusivi e un invito speciale agli eventi Agropuro.
                </li>
            </ul>
            <div class="w-full bg-green-200 h-4 rounded-full mb-4">
                <div class="bg-green-500 h-4 rounded-full" style="width: 65%;"></div>
            </div>
            <p class="text-sm text-darkGreen mb-2">€13.000 raccolti su €20.000 - Siamo vicini al nostro obiettivo!</p>
        </div>

        @include('partials.formdonation')

        <div class="text-center">
            <p class="text-lg font-semibold mb-4">Preferisci donare più tardi?</p>
            <a href="#" class="text-darkGreen font-bold hover:underline">Salva la Pagina e Torna Più Tardi</a>
        </div>
    </div>
</div>

@endsection
