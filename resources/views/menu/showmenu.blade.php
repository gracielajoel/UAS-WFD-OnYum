<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    @vite('resources/css/app.css')
    <title>OnYum! Restaurant - Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --color-dark-navy: #000435;
        }
    </style>
</head>
<body class="bg-[var(--color-dark-navy)] text-white font-sans">
    {{-- NAVBAR --}}
    <nav class="bg-black bg-opacity-70 text-white px-6 py-4 shadow-md fixed top-0 left-0 right-0 z-50">
      <div class="max-w-7xl mx-auto flex justify-between items-center flex-wrap gap-2">
        <!-- Branding dan Back -->
        <div class="flex items-center gap-4">
          <div class="text-2xl font-bold tracking-widest">🍽️ OnYum!</div>
          <a href="{{ route('home') }}" 
              class="bg-white text-[var(--color-dark-navy)] px-4 py-1 rounded-full font-semibold hover:bg-gray-200 transition shadow">
              ← Back
          </a>
        </div>

        <!-- Menu Kanan -->
        <div>
            @auth
                <div class="flex items-center gap-4">
                    <span class="text-sm sm:text-base">Welcome, {{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded transition text-sm">
                            Logout
                        </button>
                    </form>
                </div>
            @endauth
        </div>
      </div>
    </nav>


    {{-- Spacer untuk menghindari navbar menutup konten --}}
    <div class="h-20"></div>

    {{-- Section Judul --}}
    <section class="text-center mb-12">
        <h1 class="text-5xl font-bold text-white drop-shadow-lg tracking-widest">All Menu</h1>
        <p class="text-gray-300 mt-4 italic">Discover our complete selection of delicious dishes</p>
    </section>

    {{-- Section Semua Menu --}}
    {{-- Section Semua Menu --}}
<section class="px-4 sm:px-6 lg:px-16">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
        @forelse($menus as $menu)
            <div class="bg-white bg-opacity-10 rounded-xl overflow-hidden shadow-lg hover:scale-105 transition transform">
                <img src="{{ asset('storage/' . $menu->image_url) }}" alt="{{ $menu->name }}" class="w-full h-48 object-cover" />
                <div class="p-4 text-center">
                    <h3 class="text-xl font-semibold text-white mb-2">{{ $menu->name }}</h3>
                    <p class="text-gray-300 mb-1">Category: {{ $menu->category }}</p>
                    <p class="text-gray-300">Rp{{ number_format($menu->price, 2) }}</p>
                </div>
            </div>
        @empty
            <p class="col-span-full text-center text-gray-300">No menu items available at the moment.</p>
        @endforelse
    </div>
</section>

</body>
</html>