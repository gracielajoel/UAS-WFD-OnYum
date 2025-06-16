{{-- resources/views/reservations/confirmation.blade.php --}}
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Dashboard - Reservations</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    :root {
      --color-dark-navy: #000435;
    }
  </style>
</head>
<body class="bg-[var(--color-dark-navy)] text-white font-sans min-h-screen flex flex-col">

    <a href="{{ route('admin.dashboard') }}" 
    class="absolute top-6 left-6 bg-white text-[var(--color-dark-navy)] px-4 py-2 rounded-full font-semibold hover:bg-gray-200 transition z-50 shadow-lg">
    ← Back
  </a>

  <header class="bg-black bg-opacity-80 p-6 shadow-md">
    <h1 class="text-3xl font-bold text-center tracking-wide">Admin Dashboard - Reservations</h1>
  </header>

  <main class="flex-grow container mx-auto px-6 py-10 max-w-7xl">
    @if(session('success'))
      <div class="bg-green-600 text-white px-4 py-3 rounded mb-4">
        {{ session('success') }}
      </div>
    @endif

    @if(session('error'))
      <div class="bg-red-600 text-white px-4 py-3 rounded mb-4">
        {{ session('error') }}
      </div>
    @endif

    <div class="overflow-x-auto rounded-lg shadow-lg border border-gray-700">
      <table class="min-w-full divide-y divide-gray-700">
        <thead class="bg-black bg-opacity-80">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase">Customer</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase">Date</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase">Time</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase">Guests</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase">Type</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase">DP Proof</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase">Table</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase">Status</th>
            <th class="px-6 py-3 text-center text-xs font-semibold text-white uppercase">Action</th>
          </tr>
        </thead>
        <tbody class="bg-[var(--color-dark-navy)] divide-y divide-gray-700">
          @foreach ($reservations as $reservation)
            <tr>
              <td class="px-6 py-4 text-sm">{{ $reservation->user->name }}</td>
              <td class="px-6 py-4 text-sm">{{ \Carbon\Carbon::parse($reservation->date)->format('M d, Y') }}</td>
              <td class="px-6 py-4 text-sm">{{ \Carbon\Carbon::parse($reservation->time)->format('H:i') }}</td>
              <td class="px-6 py-4 text-sm">{{ $reservation->num_person }}</td>
              <td class="px-6 py-4 text-sm">{{ $reservation->reservation_type }}</td>
              <td class="px-6 py-4 text-sm">
                @if($reservation->dp_proof)
                  <a href="{{ asset('storage/dp_proofs/' . $reservation->dp_proof) }}" class="text-blue-400 underline" target="_blank">Lihat Bukti</a>
                @else
                  <span class="text-gray-400 italic">Belum ada</span>
                @endif
              </td>
              <td class="px-6 py-4 text-sm">
                @if ($reservation->status === 'Pending')
                  <form method="POST" action="{{ route('admin.reservations.confirm', $reservation->id) }}">
                    @csrf
                    <select name="table_id" class="text-black px-2 py-1 rounded" required>
                      <option value="">Pilih meja</option>
                      @foreach ($availableTables->where('capacity', '>=', $reservation->num_person) as $table)
                        <option value="{{ $table->id }}">Meja {{ $table->name }} ({{ $table->capacity }} kursi)</option>
                      @endforeach
                    </select>
                    <button type="submit" class="ml-2 bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded">
                      Confirm
                    </button>
                  </form>
                @else
                  {{ $reservation->table?->name ?? '-' }}
                @endif
              </td>
              @php
              $statusColor = match($reservation->status) {
                  'Confirmed' => 'text-green-400',
                  'Rejected' => 'text-orange-400',
                  'Cancelled' => 'text-red-500',
                  'Finished' => 'text-blue-400',
                  default => 'text-yellow-400'
              };
            @endphp
            <td class="px-6 py-4 text-sm font-semibold {{ $statusColor }}">
              {{ $reservation->status }}
            </td>

              <td class="px-6 py-4 text-center text-sm">
                @if ($reservation->status === 'Confirmed')
                  <form class="inline" method="POST" action="{{ route('admin.reservations.finish', $reservation->id) }}">
                    @csrf
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded mr-1">Finish</button>
                  </form>
                  <form class="inline" method="POST" action="{{ route('admin.reservations.cancel', $reservation->id) }}">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">Cancel</button>
                  </form>
                @else
                  <span class="text-gray-400 italic">No Actions</span>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </main>
</body>
</html>
