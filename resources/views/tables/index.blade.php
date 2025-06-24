<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Table Availability - OnYum! Restaurant</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    :root { --color-dark-navy: #000435; }
  </style>
</head>
<body class="bg-[var(--color-dark-navy)] text-white font-sans min-h-screen flex flex-col">

  <a href="{{ route('admin.dashboard') }}" 
    class="absolute top-6 left-6 bg-white text-[var(--color-dark-navy)] px-4 py-2 rounded-full font-semibold hover:bg-gray-200 transition z-50 shadow-lg">
    ← Back
  </a>
  
<header class="bg-black bg-opacity-80 p-6 shadow-md">
  <h1 class="text-3xl font-bold text-center tracking-wide">Restaurant Table Availability</h1>
</header>

<main class="flex-grow container mx-auto px-6 py-10 max-w-7xl">

  <div class="mb-8 text-right">
    <a href="{{ route('tables.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 rounded-lg text-white font-semibold">
      + Add Table
    </a>
  </div>

  <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-8">
    @foreach ($listTables as $table)
      <div class="bg-black bg-opacity-70 rounded-xl p-6 flex flex-col items-center shadow-lg border border-gray-700">
        <div class="text-white font-bold text-xl mb-2">{{ $table->name }}</div>
        <div class="mb-2 text-gray-400 text-sm">Capacity: {{ $table->capacity }}</div>
        <div class="flex items-center space-x-3 mb-4">
          <span class="w-5 h-5 rounded-full" style="background-color: {{ $table->is_empty ? '#22c55e' : '#ef4444' }};"></span>
          <span class="font-semibold">{{ $table->is_empty ? 'Available' : 'Reserved' }}</span>
        </div>
        <div class="flex space-x-2">
          <a href="{{ route('tables.edit', $table->id) }}" class="px-3 py-1 bg-blue-600 hover:bg-blue-500 rounded text-sm">Edit</a>
          <form action="{{ route('tables.destroy', $table->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
            @csrf @method('DELETE')
            <button type="submit" class="px-3 py-1 bg-red-600 hover:bg-red-500 rounded text-sm">Delete</button>
          </form>
        </div>
      </div>
    @endforeach
  </div>

</main>
</body>
</html>
