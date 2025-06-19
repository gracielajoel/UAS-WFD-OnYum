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
        <div class="max-w-7xl mx-auto flex justify-between items-center">
    {{-- Logo --}}
    <div class="flex items-center gap-6">
        <div class="text-2xl font-bold tracking-widest">🍽️ OnYum!</div>

        @auth
        {{-- Tombol My Reservation History --}}
        <a href="{{ route('reservations.history') }}"
           class="text-sm sm:text-base bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">
            My Reservation History
        </a>
        @endauth
    </div>
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

                        
                        <a href="{{ route('password.form') }}"
                        class="text-sm sm:text-base bg-yellow-500 hover:bg-yellow-600 text-black px-4 py-2 rounded transition">
                        Change Password
                        </a>
                    

                    </div>
                @else
                    <a href="{{ route('login') }}"
                    class="bg-white text-[var(--color-dark-navy)] font-semibold px-4 py-2 rounded hover:bg-gray-200 transition">
                    Login
                    </a>
                @endauth

            </div>
        </div>
    </nav>

    {{-- Spacer untuk menghindari navbar menutup konten --}}
    <div class="h-20"></div>

    @if (session('error'))
        <div 
            id="errorModal"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
        >
            <div class="bg-red-500 text-white rounded-lg shadow-lg p-6 max-w-md w-full text-center relative">
                <h2 class="text-xl font-semibold mb-4">Oops!</h2>
                <p>{{ session('error') }}</p>
                <button 
                    onclick="document.getElementById('errorModal').style.display='none'" 
                    class="mt-6 bg-white text-red-600 font-semibold px-4 py-2 rounded hover:bg-gray-100"
                >
                    Close
                </button>
            </div>
        </div>
    @endif


    {{-- Container utama --}}
    <div class="max-w-7xl mx-auto px-4 md:px-8 py-10">
        @yield('content')
    </div>

    {{-- Hero Section --}}
    <header class="relative flex flex-col items-center justify-center min-h-screen px-6 text-center bg-gradient-to-b from-[var(--color-dark-navy)] via-black to-black">
        <h1 class="text-5xl md:text-7xl font-extrabold mb-4 tracking-wide drop-shadow-lg">OnYum! Restaurant</h1>
        <p class="text-lg md:text-2xl mb-8 max-w-xl drop-shadow-md italic">Experience exquisite dining & effortless reservations</p>

        {{-- Reserve Now Button --}}
        <a href="{{ Auth::check() ? route('reservations.index') : route('login') }}"
           class="inline-block bg-white text-[var(--color-dark-navy)] font-semibold px-8 py-4 rounded-xl shadow-lg hover:bg-gray-200 transition">
            Reserve Now
        </a>
    </header>

    {{-- Feature Section --}}
    <section class="py-16 px-6 max-w-7xl mx-auto" id="features">
        <h2 class="text-center text-4xl font-bold mb-12 tracking-widest text-white drop-shadow-lg">Our Services</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 text-center">
            {{-- Feature 1: Table Reservation --}}
            <a href="{{ Auth::check() ? route('reservations.index') : route('login') }}"
               class="block bg-black bg-opacity-60 rounded-xl p-8 shadow-lg hover:bg-white hover:text-[var(--color-dark-navy)] transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4 h-14 w-14 text-white transition" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M7 7v13M17 7v13M9 7v13M5 7v13m2-20h10a2 2 0 012 2v1H5V3a2 2 0 012-2z" />
                </svg>
                <h3 class="text-xl font-semibold mb-2">Table Reservation</h3>
                <p class="text-gray-300">Book your table online quickly and easily for a delightful dining experience.</p>
            </a>

            {{-- Feature 2: VIP Event Booking --}}
            <a href="{{ Auth::check() ? route('reservations.index') : route('login') }}"
               class="block bg-black bg-opacity-60 rounded-xl p-8 shadow-lg hover:bg-white hover:text-[var(--color-dark-navy)] transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4 h-14 w-14 text-white transition" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A2 2 0 013 15.382V4a2 2 0 012-2h14a2 2 0 012 2v11.382a2 2 0 01-1.553 1.894L15 20m-6 0v-6h6v6" />
                </svg>
                <h3 class="text-xl font-semibold mb-2">VIP Event Booking</h3>
                <p class="text-gray-300">Reserve exclusive spaces for special events with personalized service.</p>
            </a>

            {{-- Feature 3: Digital Menu --}}
            <a href="{{ route('menu.showmenu') }}"
            class="block bg-black bg-opacity-60 rounded-xl p-8 shadow-lg hover:bg-white hover:text-[var(--color-dark-navy)] transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4 h-14 w-14 text-white transition" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-3.314 0-6 1.79-6 4s2.686 4 6 4 6-1.79 6-4-2.686-4-6-4z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v4m0 8v4m-8-8h4m8 0h4" />
                </svg>
                <h3 class="text-xl font-semibold mb-2">Digital Menu</h3>
                <p class="text-gray-300">Explore our full menu digitally from your device with detailed descriptions.</p>
            </a>

        </div>
    </section>

<!-- Popular Menu Items Section -->
<section class="bg-black bg-opacity-80 py-16 px-6 max-w-7xl mx-auto rounded-xl shadow-lg">
    <h2 class="text-center text-4xl font-bold mb-10 tracking-widest text-white drop-shadow-lg">Popular Menu Items</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
        @foreach($popularMenus as $menu)
            <div class="bg-white bg-opacity-10 rounded-xl overflow-hidden shadow-md hover:scale-105 transition transform">
                <img src="{{ asset('storage/' . $menu->image_url) }}" alt="{{ $menu->name }}" class="w-full h-48 object-cover" />
                <div class="p-4 text-center">
                    <h3 class="text-lg font-semibold text-white mb-1">{{ $menu->name }}</h3>
                    <p class="text-gray-300">Rp{{ number_format($menu->price, 2) }}</p>
                </div>
            </div>
        @endforeach
    </div>
    <div class="text-center mt-6">
        <a href="{{ route('menu.showmenu') }}" class="text-sm text-gray-300 hover:underline">View more..</a>
    </div>
</section>

<!-- Footer -->
<footer class="bg-black bg-opacity-90 mt-16 py-10 px-6 text-gray-300 max-w-7xl mx-auto rounded-xl shadow-inner">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-left">
        <div>
            <h4 class="font-semibold text-white mb-3 text-lg">Address</h4>
            <p>Jl. Manyar Kertosuro,<br />Surabaya, 67816</p>
        </div>
        <div>
            <h4 class="font-semibold text-white mb-3 text-lg">Contact</h4>
            <p>Phone: (123) 456-7890<br />Email: onyumrestaurant@email.com</p>
        </div>
        <div>
            <h4 class="font-semibold text-white mb-3 text-lg">Opening Hours</h4>
            <p>Mon - Fri: 11:00 AM - 10:00 PM<br />Sat - Sun: 10:00 AM - 11:00 PM</p>
        </div>
    </div>
    <p class="text-center text-gray-500 mt-8 text-sm">&copy; 2025 OnYum! Restaurant. All Rights Reserved.</p>
</footer>

</body>
</html>