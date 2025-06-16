<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Past Reservations & Orders</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    :root {
      --color-dark-navy: #000435;
    }
  </style>
</head>
<body class="bg-[var(--color-dark-navy)] text-white font-sans min-h-screen flex flex-col">
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

  <header class="bg-black bg-opacity-80 p-6 shadow-md">
    <h1 class="text-3xl font-bold text-center tracking-wide">Your Past Reservations & Orders</h1>
  </header>
@auth
  <main class="flex-grow container mx-auto px-6 py-10 max-w-7xl">
    <div class="overflow-x-auto rounded-lg shadow-lg border border-gray-700">
      <table class="min-w-full divide-y divide-gray-700">
        <thead class="bg-black bg-opacity-80">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white">Order Number</th>
            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white">Date</th>
            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white">Time</th>
            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white">Duration</th>
            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white">Menu Items</th>
            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white">Total Amount</th>
            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white">DP Proof</th>
            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white">Reservation Status</th>
          </tr>
        </thead>
        <tbody class="bg-[var(--color-dark-navy)] divide-y divide-gray-700">
          @php
            // Kelompokkan orderedMenus berdasarkan reservation_id
            $groupedOrders = $orderedMenus->groupBy('reservation_id');
            @endphp

            @foreach ($groupedOrders as $reservationId => $orders)
            @php
                $reservation = $orders->first()->reservation;
                $total = $orders->reduce(function ($carry, $item) {
                    return $carry + ($item->menu->price * $item->quantity);
                }, 0);
            @endphp

            <tr class="hover:bg-black hover:bg-opacity-50 transition">
                {{-- Order Number --}}
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                #OYR{{ $reservationId }}
                </td>

                {{-- Date --}}
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                {{ \Carbon\Carbon::parse($reservation->date)->format('M d, Y') }}
                </td>

                

                {{-- Time --}}
                <td class="px-6 py-4 text-sm text-gray-300">
                {{ \Carbon\Carbon::parse($reservation->time)->format('H:i') }}
                </td>

                {{-- Duration --}}
                <td class="px-6 py-4 text-sm text-gray-300">
                {{ $reservation->duration }} hours
                </td>

                {{-- Menu Items --}}
                <td class="px-6 py-4 text-sm text-gray-300">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($orders as $order)
                    <li>
                        {{ $order->menu->name }} ({{ $order->quantity }}x - Rp{{ number_format($order->menu->price, 0, ',', '.') }})
                        @if ($order->notes)
                        <div class="ml-4 italic text-gray-400">({{ $order->notes }})</div>
                        @endif
                    </li>
                    @endforeach
                </ul>
                </td>

                {{-- Total Amount --}}
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                <strong>Rp{{ number_format($total, 0, ',', '.') }}</strong>
                </td>

                {{-- DP Proof --}}
                <td class="px-6 py-4 text-sm">
                  @if ($reservation->dp_proof)
                  <a href="{{ asset('storage/dp_proofs/' . $reservation->dp_proof) }}"
                    class="underline text-blue-400 hover:text-blue-200 transition-colors duration-200"
                    target="_blank">
                    View Proof
                  </a>

                  @elseif ($reservation->status === 'Confirmed')
                    <form action="{{ route('reservations.uploadProof', $reservation->id) }}" method="POST" enctype="multipart/form-data" class="flex items-center space-x-2">
                      @csrf
                      <input type="file" name="dp_proof" accept="image/*" class="text-sm text-gray-200 bg-gray-800 border border-gray-600 rounded px-2 py-1">
                      <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">
                        Submit
                      </button>
                    </form>
                  @else
                    <span class="text-gray-500 italic">Check again later</span>
                  @endif
                </td>


                {{-- Reservation Status --}}
                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold
                @if($reservation->status === 'Completed') text-green-400
                @elseif($reservation->status === 'Cancelled') text-red-500
                @elseif($reservation->status === 'Pending') text-yellow-400
                @else text-gray-300 @endif">
                {{ $reservation->status }}
                </td>

                
            </tr>
            @endforeach



        </tbody>
      </table>
    </div>
  </main>
@endauth
</body>
</html>


