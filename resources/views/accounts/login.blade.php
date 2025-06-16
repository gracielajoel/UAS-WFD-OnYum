<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
      :root {
        --color-dark-navy: #000435;
      }
    </style>
</head>
<body class="bg-[var(--color-dark-navy)] text-white font-sans min-h-screen flex items-center justify-center p-6">

  <div class="w-full max-w-lg bg-black bg-opacity-80 rounded-xl p-10 shadow-lg relative">
    <h1 class="text-3xl font-extrabold mb-8 text-center tracking-wide drop-shadow-lg">Login to Your Account</h1>

    <!-- Modal Alert -->
    @if ($errors->any())
      <div id="errorModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white text-black rounded-lg p-6 shadow-lg w-80 text-center">
          <h2 class="text-xl font-bold mb-2">Login Gagal</h2>
          <p>{{ $errors->first() }}</p>
          <button onclick="document.getElementById('errorModal').style.display='none'"
            class="mt-4 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
            Tutup
          </button>
        </div>
      </div>
    @endif

    <form class="space-y-6" action="{{ route('login') }}" method="POST" novalidate>
      @csrf

      <!-- Email -->
      <div>
        <label for="email" class="block mb-2 font-semibold text-white">Email</label>
        <input type="email" id="email" name="email" placeholder="john@email.com" required
          class="w-full rounded-md bg-[var(--color-dark-navy)] border border-gray-600 px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-white/80" />
      </div>

      <!-- Password -->
      <div>
        <label for="password" class="block mb-2 font-semibold text-white">Password</label>
        <input type="password" id="password" name="password" placeholder="**********" required
          class="w-full rounded-md bg-[var(--color-dark-navy)] border border-gray-600 px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-white/80" />
      </div>

      <!-- Submit Button -->
      <div>
        <button type="submit" 
          class="w-full bg-white text-[var(--color-dark-navy)] font-semibold rounded-xl px-6 py-3 hover:bg-gray-200 transition focus:outline-none focus:ring-4 focus:ring-white/60">
          Login
        </button>
      </div>
    </form>

    <!-- Link ke Register -->
    <p class="mt-6 text-center text-sm">
      Don't have an account?
      <a href="{{ route('register') }}"
         class="text-white hover:text-blue-400 transition duration-200 font-semibold">
        Register Now
      </a>
    </p>
  </div>

</body>
</html>
