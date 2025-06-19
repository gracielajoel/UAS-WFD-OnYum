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
            <div class="text-2xl font-bold tracking-widest">🍽️ OnYum!</div>
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


    {{-- Hero Section --}}
    <header class="relative flex flex-col items-center justify-center min-h-screen px-6 text-center bg-gradient-to-b from-[var(--color-dark-navy)] via-black to-black">
        <h1 class="text-5xl md:text-7xl font-extrabold mb-4 tracking-wide drop-shadow-lg">OnYum! Restaurant</h1>
        <p class="text-lg md:text-2xl mb-8 max-w-xl drop-shadow-md italic">Experience exquisite dining & effortless reservations</p>
    </header>


    {{-- Feature Section --}}
    <section class="py-16 px-6 max-w-7xl mx-auto" id="features">
        <h2 class="text-center text-4xl font-bold mb-12 tracking-widest text-white drop-shadow-lg">Admin Services</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-10 text-center">
            {{-- Feature 1: Menu Management --}}
            <a href="{{ route('menu.index') }}"
            class="block bg-[#363636] bg-opacity-60 rounded-xl p-8 shadow-lg hover:bg-white hover:text-[var(--color-dark-navy)] transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4 h-14 w-14 text-white transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h10M4 18h10"/>
                </svg>
                <h3 class="text-xl font-semibold mb-2">Menu Management</h3>
                <p class="text-gray-300">Manage restaurant menu items including name, price, and availability.</p>
            </a>

            {{-- Feature 2: Confirm Reservation --}}
            <a href="{{ route('admin.reservations.index') }}"
            class="block bg-[#363636] bg-opacity-60 rounded-xl p-8 shadow-lg hover:bg-white hover:text-[var(--color-dark-navy)] transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4 h-14 w-14 text-white transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 4h10a2 2 0 012 2v10a2 2 0 01-2 2H7a2 2 0 01-2-2V9a2 2 0 012-2z"/>
                </svg>
                <h3 class="text-xl font-semibold mb-2">Confirm Reservation</h3>
                <p class="text-gray-300">Approve or reject customer reservations and assign tables.</p>
            </a>

            {{-- Feature 3: Table Management --}}
            <a href="{{ route('tables.index') }}"
            class="block bg-[#363636] bg-opacity-60 rounded-xl p-8 shadow-lg hover:bg-white hover:text-[var(--color-dark-navy)] transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4 h-14 w-14 text-white transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M10 14h4M4 18h16"/>
                </svg>
                <h3 class="text-xl font-semibold mb-2">Table Management</h3>
                <p class="text-gray-300">Add, edit, or remove tables and monitor their availability status.</p>
            </a>

            {{-- Feature 4: Order Management --}}
            <a href="{{ route('orders.index') }}"
            class="block bg-[#363636] bg-opacity-60 rounded-xl p-8 shadow-lg hover:bg-white hover:text-[var(--color-dark-navy)] transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4 h-14 w-14 text-white transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 6h13M7 13l1.5-6h10m-9 10a1 1 0 11-2 0 1 1 0 012 0zm8 0a1 1 0 11-2 0 1 1 0 012 0z" />
                </svg>

                <h3 class="text-xl font-semibold mb-2">Sales Report</h3>
                <p class="text-gray-300">View daily, monthly, and yearly sales reports; dashboard with data visualization.</p>
            </a>
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