<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Register Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
      :root {
        --color-dark-navy: #000435;
      }
    </style>
</head>
<body class="bg-[var(--color-dark-navy)] text-white font-sans min-h-screen flex items-center justify-center p-6">

  <div class="w-full max-w-lg bg-black bg-opacity-80 rounded-xl p-10 shadow-lg">
    <h1 class="text-3xl font-extrabold mb-8 text-center tracking-wide drop-shadow-lg">Register Now</h1>

    <form class="space-y-6" action="{{ route('register') }}" method="POST" novalidate>
      @csrf <!-- Penting! -->

      <!-- Name -->
      <div>
        <label for="name" class="block mb-2 font-semibold text-white">Name</label>
        <input type="text" id="name" name="name" placeholder="John Doe" required
          class="w-full rounded-md bg-[var(--color-dark-navy)] border border-gray-600 px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-white/80" />
      </div>

      <!-- Phone -->
      <div>
        <label for="phone" class="block mb-2 font-semibold text-white">Phone</label>
        <input type="tel" id="phone" name="phone" placeholder="(123) 456-7890" required
          class="w-full rounded-md bg-[var(--color-dark-navy)] border border-gray-600 px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-white/80" />
      </div>

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

      <!-- Confirm Password -->
      <div>
        <label for="password_confirmation" class="block mb-2 font-semibold text-white">Confirm Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="**********" required
          class="w-full rounded-md bg-[var(--color-dark-navy)] border border-gray-600 px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-white/80" />
      </div>

      <!-- Submit Button -->
      <div>
        <button type="submit" 
          class="w-full bg-white text-[var(--color-dark-navy)] font-semibold rounded-xl px-6 py-3 hover:bg-gray-200 transition focus:outline-none focus:ring-4 focus:ring-white/60">
          Register
        </button>
      </div>
    </form>

    <!-- Link ke Login -->
    <p class="mt-6 text-center text-sm">
      Already have an account?
      <a href="{{ route('login') }}"
         class="text-white hover:text-blue-400 transition duration-200 font-semibold">
        Login Now
      </a>
    </p>
  </div>

</body>
</html>
