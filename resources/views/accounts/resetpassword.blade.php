<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Reset Password</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    :root {
      --color-dark-navy: #000435;
    }
  </style>
</head>
<body class="bg-[var(--color-dark-navy)] text-white font-sans min-h-screen flex items-center justify-center p-6">

  <div class="w-full max-w-lg bg-black bg-opacity-80 rounded-xl p-10 shadow-lg relative">

    <!-- Header dengan judul dan tombol back -->
  <div class="flex items-center justify-between mb-8">
    <a href="{{ Auth::user()->role_id == 1 ? route('admin.dashboard') : route('home') }}" 
      class="bg-white text-[var(--color-dark-navy)] px-4 py-2 rounded-full font-semibold hover:bg-gray-200 transition shadow">
      ← Back
    </a>

    <h1 class="text-3xl font-extrabold tracking-wide drop-shadow-lg">Reset Password</h1>
  </div>


    @if(session('success'))
      <div class="bg-green-600 text-white p-4 rounded mb-4 text-center">
        {{ session('success') }}
      </div>
    @endif
    @if(session('error'))
      <div class="bg-red-600 text-white p-4 rounded mb-4 text-center">
        {{ session('error') }}
      </div>
    @endif

    <form class="space-y-6" action="{{ route('password.update') }}" method="POST" novalidate>
      @csrf

      <!-- Current Password -->
      <div>
        <label for="current_password" class="block mb-2 font-semibold text-white">Current Password</label>
        <input type="password" id="current_password" name="current_password" required
          class="w-full rounded-md bg-[var(--color-dark-navy)] border border-gray-600 px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-white/80" />
      </div>

      <!-- New Password -->
      <div>
        <label for="new_password" class="block mb-2 font-semibold text-white">New Password</label>
        <input type="password" id="new_password" name="new_password" required
          class="w-full rounded-md bg-[var(--color-dark-navy)] border border-gray-600 px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-white/80" />
      </div>

      <!-- Confirm New Password -->
      <div>
        <label for="new_password_confirmation" class="block mb-2 font-semibold text-white">Confirm New Password</label>
        <input type="password" id="new_password_confirmation" name="new_password_confirmation" required
          class="w-full rounded-md bg-[var(--color-dark-navy)] border border-gray-600 px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-white/80" />
      </div>

      <!-- Submit Button -->
      <div>
        <button type="submit" 
          class="w-full bg-white text-[var(--color-dark-navy)] font-semibold rounded-xl px-6 py-3 hover:bg-gray-200 transition">
          Update Password
        </button>
      </div>
    </form>
  </div>

</body>
</html>
