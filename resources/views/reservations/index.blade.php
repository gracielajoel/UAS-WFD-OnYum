<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Reservasi Meja - OnYum! Restaurant</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
      :root {
        --color-dark-navy: #000435;
      }
      /* Hide scrollbar except on hover (optional, for aesthetics) */
      .scroll-container {
        -webkit-overflow-scrolling: touch;
      }
      /* Responsive wrap below 1440px */
      @media (max-width: 1439px) {
        .no-wrap-lg {
          flex-wrap: wrap !important;
          justify-content: center;
        }
      }
    </style>
</head>
<body class="bg-[var(--color-dark-navy)] text-white font-sans min-h-screen flex items-center justify-center p-6">
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



  <div class="flex flex-nowrap no-wrap-lg gap-6 max-w-full overflow-x-auto scroll-container pb-6">
    <!-- Formulir Reservasi -->
    <div class="flex-shrink-0 w-[672px] bg-black bg-opacity-80 rounded-xl p-10 shadow-lg">
      <h1 class="text-3xl font-extrabold mb-8 text-center tracking-wide drop-shadow-lg">Reservasi Meja</h1>
        @if(session('success'))
            <div class="bg-green-500 text-white p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-500 text-white p-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

      <form id="reservationForm" class="space-y-6" action="{{ route('reservations.store') }}" method="POST">
        @csrf

        <!-- Jumlah Tamu -->
        <div>
          <label for="guests" class="block mb-2 font-semibold text-white">Jumlah Tamu</label>
          <input type="number" id="guests" name="guests" min="1" max="50" placeholder="2" required
            class="w-full rounded-md bg-[var(--color-dark-navy)] border border-gray-600 px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-white/80" />
        </div>


        <!-- Tanggal Reservasi -->
        <div>
          <label for="date" class="block mb-2 font-semibold text-white">Tanggal Reservasi</label>
          <input type="date" id="date" name="date" required
            class="w-full rounded-md bg-[var(--color-dark-navy)] border border-gray-600 px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-white/80" />
        </div>


        <!-- Waktu Mulai -->
        <div>
          <label for="start_time" class="block mb-2 font-semibold text-white">Waktu Mulai</label>
          <input type="time" id="start_time" name="start_time" required
            class="w-full rounded-md bg-[var(--color-dark-navy)] border border-gray-600 px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-white/80" />
        </div>


        <!-- Durasi -->
        <div>
          <label for="duration" class="block mb-2 font-semibold text-white">Durasi (jam)</label>
          <input type="number" id="duration" name="duration" min="1" max="8" placeholder="2" required
            class="w-full rounded-md bg-[var(--color-dark-navy)] border border-gray-600 px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-white/80" />
        </div>


        <!-- Tipe Reservasi -->
        <div>
          <label for="reservation_type" class="block mb-2 font-semibold text-white">Tipe Reservasi</label>
          <select id="reservation_type" name="reservation_type" required
            class="w-full rounded-md bg-[var(--color-dark-navy)] border border-gray-600 px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-white/80">
            <option value="" disabled selected>Pilih tipe</option>
            <option value="regular">Reguler</option>
            <option value="vip">Acara VIP</option>
          </select>
        </div>


        <!-- Tombol Kirim -->
        <div>
          <button type="submit"
            class="w-full bg-white text-[var(--color-dark-navy)] font-semibold rounded-xl px-6 py-3 hover:bg-gray-200 transition focus:outline-none focus:ring-4 focus:ring-white/60">
            Reservasi Meja
          </button>
        </div>
      
    </div>


    <!-- Bagian Menu -->
<div class="flex-shrink-0 w-[650px] bg-black bg-opacity-80 rounded-xl p-6 shadow-lg overflow-y-scroll max-h-[1020px]">
  <h2 class="text-2xl font-bold mb-4 text-center">Menu</h2>
  <div class="space-y-4">
    @foreach ($availableMenus as $menu)
    <div class="flex flex-col items-center">
        <img src="{{ asset('storage/' . $menu->image_url) }}" alt="{{ $menu->name }}" class="w-48 h-32 object-cover rounded-md mb-2" />
        <span class="text-white">{{ $menu->name }}</span>
        
        <input
        type="text"
        name="notes[{{ $menu->id }}]"
        placeholder="Catatan (opsional)"
        class="mt-3 w-full rounded-md bg-[var(--color-dark-navy)] border border-gray-600 px-3 py-2 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-white/80"
    />

        <!-- Tombol Jumlah -->
        <div class="flex items-center space-x-2 mt-2">
        <button class="bg-white text-[var(--color-dark-navy)] rounded-full w-8 h-8 flex items-center justify-center"
            onclick="updateQuantity('{{ Str::slug($menu->name) }}', -1)" type="button">-</button>
        <span id="{{ Str::slug($menu->name) }}" class="text-white">0</span>
        <button class="bg-white text-[var(--color-dark-navy)] rounded-full w-8 h-8 flex items-center justify-center"
            onclick="updateQuantity('{{ Str::slug($menu->name) }}', 1)" type="button">+</button>
        </div>
    </div>
    @endforeach

  </div>
  </form>
</div>
      </div>
    </div>
  </div>


  <script>
    // Fungsi untuk memperbarui jumlah item menu
    function updateQuantity(item, change) {
        const quantityElement = document.getElementById(item);
        if (!quantityElement) return;
        let currentQuantity = parseInt(quantityElement.innerText);
        currentQuantity = Math.max(0, currentQuantity + change);
        quantityElement.innerText = currentQuantity;
        }



    // Menangani pengiriman formulir
    document.getElementById('reservationForm').addEventListener('submit', function(event) {
    // event.preventDefault(); // ← Hapus baris ini agar form terkirim
    const formData = new FormData(this);

    document.querySelectorAll('span[id]').forEach(span => {
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = `${span.id}_quantity`;
    input.value = span.innerText;
    this.appendChild(input);
    });

});


  </script>


</body>
</html>