<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">

 <title>MobileShop - Repair Shop Management</title>
 <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

 <!-- Fonts -->
 <link rel="preconnect" href="https://fonts.bunny.net">
 <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

 <!-- Styles -->
 @vite(['resources/css/app.css', 'resources/js/app.js'])
 <style>
  html {
   scroll-behavior: smooth;
  }

  .gradient-bg {
   background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
  }

  .mobile-menu {
   max-height: 0;
   overflow: hidden;
   transition: max-height 0.3s ease-out;
  }

  .mobile-menu.active {
   max-height: 500px;
  }
 </style>
</head>

<body class="font-sans">
 <!-- Header -->
 <header class="fixed w-full bg-white shadow-md z-50">
  <nav class="container mx-auto px-6 py-4">
   <div class="flex justify-between items-center">
    <!-- Logo (Left) -->
    <div class="flex items-center">
     <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
      <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
      </svg>
     </div>
     <span class="ml-3 text-2xl font-bold text-blue-600">MobileShop</span>
    </div>

    <!-- Navigation Links (Center) - Desktop -->
    <div class="hidden md:flex space-x-8">
     @auth
      @if (auth()->user()->isAdmin())
       <a href="/admin" class="text-gray-700 hover:text-blue-600 transition">Admin Panel</a>
      @endif
     @endauth
     <a href="#home" class="text-gray-700 hover:text-blue-600 transition">Home</a>
     <a href="#plansSection" class="text-gray-700 hover:text-blue-600 transition">Plans</a>
     <a href="{{ route('track.repair') }}" class="text-gray-700 hover:text-blue-600 transition">Track
      Phone</a>
     <a href="#contact" class="text-gray-700 hover:text-blue-600 transition">Contact</a>
    </div>

    @auth
     <div class="hidden md:flex space-x-4">
      <a href="{{ route('owner.dashboard') }}"
       class="px-6 py-2 text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50 transition">
       Dashboard
      </a>
      <form method="POST" action="{{ route('logout') }}" class="inline">
       @csrf
       <button type="submit"
        class="px-6 py-2 text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50 transition">Logout</button>
      </form>

     </div>
    @endauth
    @guest
     <div class="hidden md:flex space-x-4">
      <a href="/login"
       class="px-6 py-2 text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50 transition">Login</a>
      <a href="/register" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Register</a>
     </div>
    @endguest
    <!-- Auth Links (Right) - Desktop -->

    <!-- Hamburger Menu Button - Mobile -->
    <button id="hamburger" class="md:hidden text-gray-700 focus:outline-none">
     <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
     </svg>
    </button>
   </div>

   <!-- Mobile Menu -->
   <div id="mobile-menu" class="mobile-menu md:hidden">
    <div class="pt-4 pb-3 space-y-3">
     @auth
      @if (auth()->user()->isAdmin())
       <a href="/admin"
        class="block text-gray-700 hover:text-blue-600 hover:bg-gray-50 px-3 py-2 rounded-lg transition">Admin
        Panel</a>
      @endif
     @endauth
     <a href="#home"
      class="block text-gray-700 hover:text-blue-600 hover:bg-gray-50 px-3 py-2 rounded-lg transition">Home</a>
     <a href="#plans"
      class="block text-gray-700 hover:text-blue-600 hover:bg-gray-50 px-3 py-2 rounded-lg transition">Plans</a>
     <a href="{{ route('track.repair') }}"
      class="block text-gray-700 hover:text-blue-600 hover:bg-gray-50 px-3 py-2 rounded-lg transition">Track
      Phone</a>
     <a href="#contact"
      class="block text-gray-700 hover:text-blue-600 hover:bg-gray-50 px-3 py-2 rounded-lg transition">Contact</a>
     <hr class="my-2">
     @auth
      <a href="{{ route('owner.dashboard') }}"
       class="block w-full text-center text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50 px-3 py-2 transition">
       Dashboard
      </a>
      <form method="POST" action="{{ route('logout') }}" class="block">
       @csrf
       <button type="submit"
        class="w-full text-center text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50 px-3 py-2 transition">
        Logout
       </button>
      </form>

     @endauth
     @guest
      <a href="/login"
       class="block text-center text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50 px-3 py-2 transition">Login</a>
      <a href="/register"
       class="block text-center bg-blue-600 text-white rounded-lg hover:bg-blue-700 px-3 py-2 transition">Register</a>
     @endguest
    </div>
   </div>
  </nav>
 </header>

 <script>
  const hamburger = document.getElementById('hamburger');
  const mobileMenu = document.getElementById('mobile-menu');

  hamburger.addEventListener('click', () => {
   mobileMenu.classList.toggle('active');
  });

  // Close mobile menu when clicking on a link
  const mobileLinks = mobileMenu.querySelectorAll('a');
  mobileLinks.forEach(link => {
   link.addEventListener('click', () => {
    mobileMenu.classList.remove('active');
   });
  });
 </script>

 <!-- Hero Section -->
 <section id="home" class="pt-24 gradient-bg text-white">
  <div class="container mx-auto px-6 py-20">
   <div class="flex flex-col md:flex-row items-center">
    <div class="md:w-1/2 mb-10 md:mb-0">
     <h1 class="text-5xl font-bold mb-6">Menaxho Dyqanin Tënd të Celularëve me Lehtësi</h1>
     <p class="text-xl mb-8 text-blue-100">Zgjidh planin perfekt për biznesin tënd dhe fillo të menaxhosh
      inventarin, shitjet dhe klientët e telefonave celularë në mënyrë efikase.</p>
     <a href="#plansSection"
      class="inline-block px-8 py-4 bg-white text-blue-600 rounded-lg font-semibold hover:bg-blue-50 transition shadow-lg">Explore
      Plans</a>
    </div>
    <div class="md:w-1/2 flex justify-center">
     <svg class="w-96 h-96" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
       d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
     </svg>
    </div>
   </div>
  </div>
 </section>

 <!-- Plans Section -->
 <section id="plansSection" class="py-20 bg-gray-50">
  <div class="container mx-auto px-6">
   <div class="text-center mb-16">
    <h2 class="text-4xl font-bold text-gray-800 mb-4">Zgjidh Planin Tënd</h2>
    <p class="text-xl text-gray-600">Zgjidh planin që i përshtatet nevojave të dyqanit tënd të celularëve
    </p>
   </div>

   <div class="grid md:grid-cols-3 gap-8">
    @foreach ($plans as $plan)
     @php
      $isStandard = $plan->slug === 'standard';
     @endphp
     <div
      class="{{ $isStandard ? 'bg-blue-600' : 'bg-white' }} rounded-xl shadow-lg p-8 hover:shadow-2xl transition transform hover:-translate-y-2 {{ $isStandard ? 'relative' : '' }}">
      @if ($isStandard)
       <div
        class="absolute top-0 right-0 bg-yellow-400 text-gray-800 px-4 py-1 rounded-bl-lg rounded-tr-lg font-semibold text-sm">
        Popular
       </div>
      @endif
      <div class="text-center">
       <h3 class="text-2xl font-bold {{ $isStandard ? 'text-white' : 'text-gray-800' }} mb-4">
        {{ ucfirst($plan->name) }}
       </h3>
       <div class="mb-2">
        <span
         class="text-5xl font-bold {{ $isStandard ? 'text-white' : 'text-blue-600' }}">€{{ number_format($plan->price_monthly, 0) }}</span>
        <span class="{{ $isStandard ? 'text-blue-100' : 'text-gray-600' }}">/month</span>
       </div>
       <div class="mb-6">
        <span class="text-lg {{ $isStandard ? 'text-blue-100' : 'text-gray-500' }}">or
         €{{ number_format($plan->price_yearly, 0) }}/year</span>
       </div>
       <ul class="text-left space-y-4 mb-8 {{ $isStandard ? 'text-white' : '' }}">
        <li class="flex items-center">
         <svg class="w-5 h-5 {{ $isStandard ? 'text-yellow-400' : 'text-green-500' }} mr-3" fill="currentColor"
          viewBox="0 0 20 20">
          <path fill-rule="evenodd"
           d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
           clip-rule="evenodd"></path>
         </svg>
         <span>{{ $plan->max_active_repairs }} active repairs</span>
        </li>
        <li class="flex items-center">
         <svg class="w-5 h-5 {{ $isStandard ? 'text-yellow-400' : 'text-green-500' }} mr-3" fill="currentColor"
          viewBox="0 0 20 20">
          <path fill-rule="evenodd"
           d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
           clip-rule="evenodd"></path>
         </svg>
         <span>{{ $plan->max_employees == 0 ? 'No' : $plan->max_employees }}
          employees</span>
        </li>
        <li class="flex items-center">
         <svg class="w-5 h-5 {{ $isStandard ? 'text-yellow-400' : 'text-green-500' }} mr-3" fill="currentColor"
          viewBox="0 0 20 20">
          <path fill-rule="evenodd"
           d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
           clip-rule="evenodd"></path>
         </svg>
         <span>{{ $plan->drag_and_drop ? 'Drag & Drop board' : 'Basic board' }}</span>
        </li>
        <li class="flex items-center">
         <svg class="w-5 h-5 {{ $isStandard ? 'text-yellow-400' : 'text-green-500' }} mr-3" fill="currentColor"
          viewBox="0 0 20 20">
          <path fill-rule="evenodd"
           d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
           clip-rule="evenodd"></path>
         </svg>
         <span>{{ $plan->branding ? 'Custom branding' : 'Standard branding' }}</span>
        </li>
        @if ($plan->exports)
         <li class="flex items-center">
          <svg class="w-5 h-5 {{ $isStandard ? 'text-yellow-400' : 'text-green-500' }} mr-3" fill="currentColor"
           viewBox="0 0 20 20">
           <path fill-rule="evenodd"
            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
            clip-rule="evenodd"></path>
          </svg>
          <span>Export reports</span>
         </li>
        @endif
       </ul>
       <!-- Pay Online Button -->
       @if ($isStandard)
        <a href="{{ route('checkout', $plan->slug) }}"
         class="block w-full py-3 bg-white text-blue-600 rounded-lg font-semibold hover:bg-blue-50 transition text-center mb-3">
         Get Started
        </a>
       @else
        <a href="{{ route('checkout', $plan->slug) }}"
         class="block w-full py-3 border-2 border-blue-600 text-blue-600 rounded-lg font-semibold hover:bg-blue-600 hover:text-white transition text-center mb-3">
         Get Started
        </a>
       @endif

       <!-- Payment Methods Icons -->
       <div class="flex items-center justify-center gap-2 mb-4">
        <!-- PayPal Icon -->
        <div class="flex items-center gap-1 px-2 py-1 {{ $isStandard ? 'bg-white/20' : 'bg-gray-100' }} rounded">
         <svg class="w-4 h-4 {{ $isStandard ? 'text-white' : 'text-[#003087]' }}" viewBox="0 0 24 24"
          fill="currentColor">
          <path
           d="M7.076 21.337H2.47a.641.641 0 0 1-.633-.74L4.944.901C5.026.382 5.474 0 5.998 0h7.46c2.57 0 4.578.543 5.69 1.81 1.01 1.15 1.304 2.42 1.012 4.287-.023.143-.047.288-.077.437-.983 5.05-4.349 6.797-8.647 6.797h-2.19c-.524 0-.968.382-1.05.9l-1.12 7.106zm14.146-14.42a3.35 3.35 0 0 0-.607-.541c-.013.076-.026.175-.041.254-.93 4.778-4.005 7.201-9.138 7.201h-2.19a.563.563 0 0 0-.556.479l-1.187 7.527h-.506l-.24 1.516a.56.56 0 0 0 .554.647h3.882c.46 0 .85-.334.922-.788.06-.26.76-4.852.816-5.09a.932.932 0 0 1 .923-.788h.58c3.76 0 6.705-1.528 7.565-5.946.36-1.847.174-3.388-.777-4.471z" />
         </svg>
         <span class="text-xs {{ $isStandard ? 'text-white' : 'text-gray-600' }}">PayPal</span>
        </div>
        <!-- Card Icon -->
        <div class="flex items-center gap-1 px-2 py-1 {{ $isStandard ? 'bg-white/20' : 'bg-gray-100' }} rounded">
         <svg class="w-4 h-4 {{ $isStandard ? 'text-white' : 'text-gray-600' }}" fill="none" stroke="currentColor"
          viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
           d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
         </svg>
         <span class="text-xs {{ $isStandard ? 'text-white' : 'text-gray-600' }}">Card</span>
        </div>
       </div>

       <!-- Divider -->
       <div class="flex items-center gap-3 mb-4">
        <div class="flex-1 h-px {{ $isStandard ? 'bg-white/30' : 'bg-gray-200' }}"></div>
        <span class="text-xs {{ $isStandard ? 'text-blue-100' : 'text-gray-400' }}">or</span>
        <div class="flex-1 h-px {{ $isStandard ? 'bg-white/30' : 'bg-gray-200' }}"></div>
       </div>

       <!-- Apply for Plan Button (Cash/Bank Transfer) -->
       @if ($isStandard)
        <a href="{{ route('plan.apply', $plan->slug) }}"
         class="group block w-full py-3 border-2 border-white/50 text-white rounded-lg font-semibold hover:bg-white/10 transition text-center">
         <span class="flex items-center justify-center gap-2">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
          Apply for Plan
         </span>
        </a>
        <p class="text-xs text-blue-100 text-center mt-2">Pay via Cash or Bank Transfer</p>
       @else
        <a href="{{ route('plan.apply', $plan->slug) }}"
         class="group block w-full py-3 border-2 border-gray-300 text-gray-600 rounded-lg font-semibold hover:border-gray-400 hover:bg-gray-50 transition text-center">
         <span class="flex items-center justify-center gap-2">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
          Apply for Plan
         </span>
        </a>
        <p class="text-xs text-gray-400 text-center mt-2">Pay via Cash or Bank Transfer</p>
       @endif
      </div>
     </div>
    @endforeach
   </div>
  </div>
 </section>

 <!-- Contact Section -->
 <section id="contact" class="py-20 bg-white">
  <div class="container mx-auto px-6">
   <div class="text-center mb-16">
    <h2 class="text-4xl font-bold text-gray-800 mb-4">Na Kontaktoni</h2>
    <p class="text-xl text-gray-600">Keni pyetje? Do të donim të dëgjonim prej jush</p>
   </div>

   <div class="max-w-2xl mx-auto">
    @if (session('success'))
     <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
      {{ session('success') }}
     </div>
    @endif

    @if ($errors->any())
     <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
      <ul class="list-disc list-inside">
       @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
       @endforeach
      </ul>
     </div>
    @endif

    <div class="bg-gray-50 rounded-xl shadow-lg p-8">
     <form action="{{ route('contact.send') }}" method="POST" class="space-y-6">
      @csrf
      <div>
       <label for="name" class="block text-gray-700 font-semibold mb-2">Emri</label>
       <input type="text" id="name" name="name" value="{{ old('name') }}" required
        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600"
        placeholder="Your name">
      </div>
      <div>
       <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
       <input type="email" id="email" name="email" value="{{ old('email') }}" required
        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600"
        placeholder="your@email.com">
      </div>
      <div>
       <label for="phone" class="block text-gray-700 font-semibold mb-2">Telefoni</label>
       <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600"
        placeholder="+383 44 000 000">
      </div>
      <div>
       <label for="message" class="block text-gray-700 font-semibold mb-2">Mesazhi</label>
       <textarea rows="5" id="message" name="message" required
        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600"
        placeholder="Na tregoni për dyqanin tuaj...">{{ old('message') }}</textarea>
      </div>
      <button type="submit"
       class="w-full py-4 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition shadow-lg">
       Dërgo Mesazhin
      </button>
     </form>
    </div>
   </div>
  </div>
 </section>

 <!-- Footer -->
 <footer class="gradient-bg text-white py-12">
  <div class="container mx-auto px-6">
   <div class="grid md:grid-cols-4 gap-8">
    <div>
     <div class="flex items-center mb-4">
      <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
       <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
         d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z">
        </path>
       </svg>
      </div>
      <span class="ml-2 text-xl font-bold">MobileShop</span>
     </div>
     <p class="text-blue-100">Your trusted partner for mobile shop management</p>
    </div>
    <div>
     <h4 class="font-bold text-lg mb-4">Quick Links</h4>
     <ul class="space-y-2 text-blue-100">
      <li><a href="#home" class="hover:text-white transition">Home</a></li>
      <li><a href="#plans" class="hover:text-white transition">Plans</a></li>
      <li><a href="#contact" class="hover:text-white transition">Contact</a></li>
     </ul>
    </div>
    <div>
     <h4 class="font-bold text-lg mb-4">Support</h4>
     <ul class="space-y-2 text-blue-100">
      <li><a href="#" class="hover:text-white transition">Help Center</a></li>
      <li><a href="#" class="hover:text-white transition">Privacy Policy</a></li>
      <li><a href="#" class="hover:text-white transition">Terms of Service</a></li>
     </ul>
    </div>
    <div>
     <h4 class="font-bold text-lg mb-4">Contact Info</h4>
     <ul class="space-y-2 text-blue-100">
      <li>Email: info@mobileshop.com</li>
      <li>Phone: +1 (555) 123-4567</li>
      <li>Address: 123 Business St.</li>
     </ul>
    </div>
   </div>
   <!-- Payment Methods Section -->
   <div class="border-t border-blue-400 mt-8 pt-8">
    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
     <p class="text-blue-100 text-sm">Secure payments powered by</p>
     <div class="flex items-center gap-4">
      <!-- PayPal -->
      <div class="flex items-center gap-2 bg-white/10 px-4 py-2 rounded-lg">
       <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
        <path
         d="M7.076 21.337H2.47a.641.641 0 0 1-.633-.74L4.944.901C5.026.382 5.474 0 5.998 0h7.46c2.57 0 4.578.543 5.69 1.81 1.01 1.15 1.304 2.42 1.012 4.287-.023.143-.047.288-.077.437-.983 5.05-4.349 6.797-8.647 6.797h-2.19c-.524 0-.968.382-1.05.9l-1.12 7.106zm14.146-14.42a3.35 3.35 0 0 0-.607-.541c-.013.076-.026.175-.041.254-.93 4.778-4.005 7.201-9.138 7.201h-2.19a.563.563 0 0 0-.556.479l-1.187 7.527h-.506l-.24 1.516a.56.56 0 0 0 .554.647h3.882c.46 0 .85-.334.922-.788.06-.26.76-4.852.816-5.09a.932.932 0 0 1 .923-.788h.58c3.76 0 6.705-1.528 7.565-5.946.36-1.847.174-3.388-.777-4.471z" />
       </svg>
       <span class="text-white text-sm font-medium">PayPal</span>
      </div>
      <!-- Visa -->
      <div class="flex items-center gap-2 bg-white/10 px-4 py-2 rounded-lg">
       <!-- License: MIT. Made by Garuda Technology: https://github.com/garudatechnologydevelopers/sketch-icons -->
       <svg class="w-10 h-6" viewBox="0 -11 70 70" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect x="0.5" y="0.5" width="69" height="47" rx="5.5" fill="white" stroke="#D9D9D9" />
        <path fill-rule="evenodd" clip-rule="evenodd"
         d="M21.2505 32.5165H17.0099L13.8299 20.3847C13.679 19.8267 13.3585 19.3333 12.8871 19.1008C11.7106 18.5165 10.4142 18.0514 9 17.8169V17.3498H15.8313C16.7742 17.3498 17.4813 18.0514 17.5991 18.8663L19.2491 27.6173L23.4877 17.3498H27.6104L21.2505 32.5165ZM29.9675 32.5165H25.9626L29.2604 17.3498H33.2653L29.9675 32.5165ZM38.4467 21.5514C38.5646 20.7346 39.2717 20.2675 40.0967 20.2675C41.3931 20.1502 42.8052 20.3848 43.9838 20.9671L44.6909 17.7016C43.5123 17.2345 42.216 17 41.0395 17C37.1524 17 34.3239 19.1008 34.3239 22.0165C34.3239 24.2346 36.3274 25.3992 37.7417 26.1008C39.2717 26.8004 39.861 27.2675 39.7431 27.9671C39.7431 29.0165 38.5646 29.4836 37.3881 29.4836C35.9739 29.4836 34.5596 29.1338 33.2653 28.5494L32.5582 31.8169C33.9724 32.3992 35.5025 32.6338 36.9167 32.6338C41.2752 32.749 43.9838 30.6502 43.9838 27.5C43.9838 23.5329 38.4467 23.3004 38.4467 21.5514ZM58 32.5165L54.82 17.3498H51.4044C50.6972 17.3498 49.9901 17.8169 49.7544 18.5165L43.8659 32.5165H47.9887L48.8116 30.3004H53.8772L54.3486 32.5165H58ZM51.9936 21.4342L53.1701 27.1502H49.8723L51.9936 21.4342Z"
         fill="#172B85" />
       </svg>
       {{-- <span class="text-white text-sm font-medium">Visa</span> --}}
      </div>
      <!-- Mastercard -->
      <div class="flex items-center gap-2 bg-white/10 px-4 py-2 rounded-lg">
       <svg class="w-8 h-5" viewBox="0 0 32 20" fill="none">
        <circle cx="10" cy="10" r="8" fill="#EB001B" />
        <circle cx="22" cy="10" r="8" fill="#F79E1B" />
        <path d="M16 3.5a8 8 0 000 13 8 8 0 000-13z" fill="#FF5F00" />
       </svg>
      </div>
      <!-- Bank Transfer -->
      <div class="flex items-center gap-2 bg-white/10 px-4 py-2 rounded-lg">
       <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
         d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
       </svg>
       <span class="text-white text-sm font-medium">Bank</span>
      </div>
      <!-- Cash -->
      <div class="flex items-center gap-2 bg-white/10 px-4 py-2 rounded-lg">
       <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
         d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
       </svg>
       <span class="text-white text-sm font-medium">Cash</span>
      </div>
     </div>
    </div>
   </div>

   <!-- Copyright -->
   <div class="border-t border-blue-400 mt-6 pt-6 text-center text-blue-100">
    <p>&copy; {{ date('Y') }} MobileShop. All rights reserved.</p>
   </div>
  </div>
 </footer>
</body>

</html>