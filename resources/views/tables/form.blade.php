<!-- resources/views/tables/form.blade.php -->
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{{ $table ? 'Edit' : 'Add' }} Table - OnYum! Restaurant</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    :root { --color-dark-navy: #000435; }
  </style>
</head>
<body class="bg-[var(--color-dark-navy)] text-white font-sans min-h-screen flex flex-col">

<section class="mt-12 bg-black bg-opacity-70 p-8 rounded-xl shadow-lg border border-gray-700 max-w-xl mx-auto">
  <h2 class="text-2xl font-bold text-center mb-6">{{ $table ? 'Edit' : 'Add' }} Table</h2>

  <form action="{{ $table ? route('tables.update', $table->id) : route('tables.store') }}" method="POST" class="space-y-6">
    @csrf
    @if($table) @method('PUT') @endif

    <div>
      <label for="name" class="block mb-2 font-semibold">Table Name</label>
      <input type="text" id="name" name="name" required
        value="{{ old('name', $table->name ?? '') }}"
        class="w-full px-4 py-2 rounded-lg bg-gray-900 text-white border border-gray-600"
        placeholder="e.g. A1" />
    </div>

    <div>
      <label for="capacity" class="block mb-2 font-semibold">Capacity</label>
      <input type="number" id="capacity" name="capacity" min="1" required
        value="{{ old('capacity', $table->capacity ?? '') }}"
        class="w-full px-4 py-2 rounded-lg bg-gray-900 text-white border border-gray-600"
        placeholder="e.g. 4" />
    </div>

    <div>
      <label for="is_empty" class="block mb-2 font-semibold">Is Empty?</label>
      <select id="is_empty" name="is_empty" required
        class="w-full px-4 py-2 rounded-lg bg-gray-900 text-white border border-gray-600">
        <option value="">-- Select Status --</option>
        <option value="1" {{ old('is_empty', $table->is_empty ?? '') == 1 ? 'selected' : '' }}>True</option>
        <option value="0" {{ old('is_empty', $table->is_empty ?? '') == 0 ? 'selected' : '' }}>False</option>
      </select>
    </div>

    <div class="flex justify-end space-x-4">
      <a href="{{ route('tables.index') }}"
        class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-white font-semibold">
        Cancel
      </a>
      <button type="submit"
        class="px-6 py-2 bg-indigo-600 hover:bg-indigo-500 rounded-lg text-white font-semibold">
        {{ $table ? 'Update' : 'Submit' }}
      </button>
    </div>
  </form>
</section>

</body>
</html>
