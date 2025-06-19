<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Menu Management</title>
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
    <h1 class="text-3xl font-bold text-center tracking-wide">Admin Menu Management</h1>
  </header>

  <main class="flex-grow container mx-auto max-w-7xl px-6 py-10">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
      <!-- Table Section -->
      <section class="md:col-span-2 overflow-x-auto rounded-lg shadow-lg border border-gray-700">
        <table class="min-w-full divide-y divide-gray-700">
          <thead class="bg-black bg-opacity-80">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-white">Menu Name</th>
              <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-white">Price</th>
              <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-white">Type</th>
              <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-white">Available</th>
              <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-white">Image</th>
              <th class="px-6 py-3 text-center text-xs font-semibold uppercase text-white">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-[var(--color-dark-navy)] divide-y divide-gray-700">
            @foreach ($listMenu as $item)
              <tr class="hover:bg-black hover:bg-opacity-50 transition">
                <td class="px-6 py-4 text-sm font-medium text-white">{{ $item->name }}</td>
                <td class="px-6 py-4 text-sm text-gray-300">{{ number_format($item->price, 2) }}</td>
                <td class="px-6 py-4 text-sm text-gray-300">{{ $item->category }}</td>
                <td class="px-6 py-4 text-sm text-gray-300">{{ $item->is_available ? 'Yes' : 'No' }}</td>
                <td class="px-6 py-4 text-sm text-gray-300">
                  @if($item->image_url)
                    <img src="{{ asset('storage/' . $item->image_url) }}" alt="Image" class="w-16 h-16 object-cover rounded" />
                  @else
                    <span class="italic text-gray-500">No Image</span>
                  @endif
                </td>
                <td class="px-6 py-4 text-center text-sm font-medium space-x-2">
                  <a href="{{ route('menu.edit', $item->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-md">Edit</a>
                  <form action="{{ route('menu.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md">Delete</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </section>

      <!-- Form Section -->
      <!-- ... bagian awal tetap sama -->

<section class="bg-black bg-opacity-80 rounded-xl p-8 shadow-lg">
  <h2 class="text-2xl font-bold mb-6 text-center">
    {{ isset($editing) ? 'Edit Menu Item' : 'Add New Menu Item' }}
  </h2>

  <form
    action="{{ isset($editing) ? route('menu.update', $editing->id) : route('menu.store') }}"
    method="POST"
    enctype="multipart/form-data"
    class="space-y-6"
  >
    @csrf
    @if(isset($editing)) @method('PUT') @endif

    <!-- Name -->
    <div>
      <label for="name" class="block mb-2 font-semibold">Name</label>
      <input type="text" id="name" name="name" required
        value="{{ old('name', $editing->name ?? '') }}"
        class="w-full rounded-md bg-[var(--color-dark-navy)] border border-gray-600 px-4 py-2 text-white" />
    </div>

    <!-- Category -->
    <div>
      <label for="category" class="block mb-2 font-semibold">Category</label>
      <select id="category" name="category" required
        class="w-full rounded-md bg-[var(--color-dark-navy)] border border-gray-600 px-4 py-2 text-white">
        <option value="">Select type</option>
        <option value="Personal" {{ old('category', $editing->category ?? '') == 'Personal' ? 'selected' : '' }}>Personal</option>
        <option value="Sharing" {{ old('category', $editing->category ?? '') == 'Sharing' ? 'selected' : '' }}>Sharing</option>
      </select>
    </div>

    <!-- Price -->
    <div>
      <label for="price" class="block mb-2 font-semibold">Price</label>
      <input type="number" id="price" name="price" step="0.01" required
        value="{{ old('price', $editing->price ?? '') }}"
        class="w-full rounded-md bg-[var(--color-dark-navy)] border border-gray-600 px-4 py-2 text-white" />
    </div>

    <!-- Availability -->
    <div>
      <label for="is_available" class="block mb-2 font-semibold">Availability</label>
      <select id="is_available" name="is_available" required
        class="w-full rounded-md bg-[var(--color-dark-navy)] border border-gray-600 px-4 py-2 text-white">
        <option value="">Select status</option>
        <option value="1" {{ old('is_available', $editing->is_available ?? '') == 1 ? 'selected' : '' }}>Available</option>
        <option value="0" {{ old('is_available', $editing->is_available ?? '') == 0 ? 'selected' : '' }}>Not Available</option>
      </select>
    </div>

    <!-- Image -->
    <div>
      <label for="image_url" class="block mb-2 font-semibold">Image</label>
      <input type="file" name="image_url" id="image_url" accept="image/*" class="block w-full text-white" />
      @if(isset($editing) && $editing->image_url)
        <div class="mt-2">
          <img src="{{ asset('storage/' . $editing->image_url) }}" class="w-24 h-24 rounded object-cover" />
        </div>
      @endif
    </div>

    <!-- Buttons -->
    <div class="flex gap-4">
      <button type="submit"
        class="flex-1 bg-white text-[var(--color-dark-navy)] font-semibold rounded-xl px-6 py-3 hover:bg-gray-200 transition">
        {{ isset($editing) ? 'Update' : 'Save' }} Menu Item
      </button>


        <a href="{{ route('menu.index') }}"
          class="flex-1 text-center bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-xl px-6 py-3 transition">
          Cancel
        </a>

    </div>
  </form>
</section>

    </div>
  </main>

</body>
</html>
