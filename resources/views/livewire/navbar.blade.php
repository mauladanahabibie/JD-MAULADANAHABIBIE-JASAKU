 <header class="fixed w-full top-0 z-50">
     <nav class="bg-white shadow-lg">
         <div class=" mx-auto px-4 sm:px-6 lg:px-36">
             <div class="flex justify-between items-center h-16">
                 <div class="flex items-center">
                     <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="w-6 h-6 md:w-10 md:h-10 mr-2">
                     <span class="text-xl md:text-3xl font-bold font-poppins">JasaKu</span>
                 </div>
                 <div class="hidden md:block">
                     <ul class="ml-10 flex items-center space-x-4">
                         <li> <a href="{{ route('home') }}"
                                 class="text-gray-800 hover:text-tertiary px-3 py-2 rounded-md text-base font-medium transition">Beranda</a>
                         </li>
                         <li> <a href="{{ route('layanan') }}"
                                 class="text-gray-800 hover:text-tertiary px-3 py-2 rounded-md text-base font-medium transition">Layanan</a>
                         </li>
                         <li> <a href="{{ route('home') }}#about"
                                 class="text-gray-800 hover:text-tertiary px-3 py-2 rounded-md text-base font-medium transition">Tentang</a>
                         </li>
                         <li> <a href="#contact"
                                 class="text-gray-800 hover:text-tertiary px-3 py-2 rounded-md text-base font-medium transition">Kontak</a>
                         </li>
                     </ul>
                 </div>
                 <div class="hidden md:block">
                     @if (Auth::check())
                         @if (Auth::user()->status === 'customer')
                             <a href="{{ url('/dashboard') }}"
                                 class="bg-tertiary text-white px-4 py-2 rounded-md text-base font-medium hover:bg-tertiary/80 transition">
                                 {{ Auth::user()->name }}
                             </a>
                         @elseif (Auth::user()->status === 'mitra' || Auth::user()->status === 'admin')
                             <a href="{{ url('/mitra') }}"
                                 class="bg-tertiary text-white px-4 py-2 rounded-md text-base font-medium hover:bg-tertiary/80 transition">
                                 {{ Auth::user()->name }}
                             </a>
                         @endif
                     @else
                         <a href="{{ url('/dashboard') }}"
                             class="bg-tertiary text-white px-4 py-2 rounded-md text-base font-medium hover:bg-tertiary/80 transition">
                             Masuk
                         </a>
                     @endif
                 </div>
                 <div class="md:hidden">
                     <button class="text-gray-800 hover:text-tertiary focus:outline-none" id="mobile-menu-toggle">
                         <i class="fas fa-bars text-xl"></i>
                     </button>
                 </div>
             </div>
         </div>
     </nav>
     <div class="mobile-menu hidden">
         <ul class="bg-white w-full p-4">
             <li> <a href="{{ route('home') }}"
                     class="block text-gray-800 hover:text-tertiary py-2 rounded-md text-base font-medium transition">Beranda</a>
             </li>
             <li> <a href="{{ route('layanan') }}"
                     class="block text-gray-800 hover:text-tertiary py-2 rounded-md text-base font-medium transition">Layanan</a>
             </li>
             <li> <a href="{{ route('home') }}#about"
                     class="block text-gray-800 hover:text-tertiary py-2 rounded-md text-base font-medium transition">Tentang</a>
             </li>
             <li> <a href="{{ route('home') }}#contact"
                     class="block text-gray-800 hover:text-tertiary py-2 rounded-md text-base font-medium transition">Kontak</a>
             </li>
             <li class="mt-3">
                 @if (Auth::check())
                     @if (Auth::user()->status === 'customer')
                         <a href="{{ url('/dashboard') }}"
                             class="bg-tertiary text-white px-4 py-2 rounded-md text-base font-medium hover:bg-tertiary/80 transition">
                             {{ Auth::user()->name }}
                         </a>
                     @elseif (Auth::user()->status === 'mitra' || Auth::user()->status === 'admin')
                         <a href="{{ url('/mitra') }}"
                             class="bg-tertiary text-white px-4 py-2 rounded-md text-base font-medium hover:bg-tertiary/80 transition">
                             {{ Auth::user()->name }}
                         </a>
                     @endif
                 @else
                     <a href="{{ url('/dashboard') }}"
                         class="bg-tertiary text-white px-4 py-2 rounded-md text-base font-medium hover:bg-tertiary/80 transition">
                         Masuk
                     </a>
                 @endif
             </li>
         </ul>
     </div>
 </header>
