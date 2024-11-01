<header class="bg-darkGreen text-white shadow-md py-4">
  <div class="container mx-auto px-4 flex justify-between items-center">
    <!-- Logo -->
    <a href="/" class="flex items-center">
      <img src="{{ asset('images/svg/logo.svg') }}" alt="Agropuro Logo" class="h-10">
      <span class="ml-2 font-bold text-xl">Agropuro</span>
    </a>

    <!-- Navigation Menu -->
    <nav class="hidden md:flex space-x-8">
      <a href="/" class="hover:text-beige">Home</a>
      <a href="/mappa-agricoltori" class="hover:text-beige">Mappa degli Agricoltori</a>
      <a href="/products" class="hover:text-beige">Prodotti</a>
      <a href="/how-it-works" class="hover:text-beige">Come Funziona</a>
      <a href="/blog" class="hover:text-beige">Blog</a>
      <a href="/contact" class="hover:text-beige">Contatti</a>
    </nav>

    <!-- Profile & Mobile Menu Button -->
    <div class="flex items-center space-x-4">
    <div class="profile">
        @auth
            <span class="text-white font-semibold">{{ Auth::user()->name }}</span>
            <a href="{{ route('profile.edit') }}" class="ml-4 text-white font-semibold hover:underline">Profilo</a>
            <form method="POST" action="{{ route('logout') }}" class="inline ml-4">
                @csrf
                <button type="submit" class="text-white font-semibold hover:underline">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="text-white font-semibold hover:underline">Login</a>
            <a href="{{ route('register') }}" class="ml-4 text-white font-semibold hover:underline">Registrati</a>
        @endauth
    </div>
      <button id="mobile-menu-button" class="md:hidden focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
        </svg>
      </button>
    </div>
  </div>

  <!-- Mobile Menu -->
  <div id="mobile-menu" class="md:hidden hidden bg-lightGreen py-2">
    <a href="/" class="block py-2 px-4 hover:bg-mintGreen">Home</a>
    <a href="/farmer-map" class="block py-2 px-4 hover:bg-mintGreen">Mappa degli Agricoltori</a>
    <a href="/products" class="block py-2 px-4 hover:bg-mintGreen">Prodotti</a>
    <a href="/how-it-works" class="block py-2 px-4 hover:bg-mintGreen">Come Funziona</a>
    <a href="/blog" class="block py-2 px-4 hover:bg-mintGreen">Blog</a>
    <a href="/contact" class="block py-2 px-4 hover:bg-mintGreen">Contatti</a>


  </div>

</header>

