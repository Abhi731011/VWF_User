<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password - Vaishvik Welfare Foundation</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

  <style>
    .input-field {
      @apply block w-full mt-2 border border-gray-400 rounded-md shadow-sm focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50 p-3 text-base;
    }
    .btn-primary {
      @apply bg-blue-600 text-white w-full py-3 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200 text-lg font-semibold;
    }
    .form-container {
      @apply bg-white p-8 rounded-xl shadow-lg border border-gray-300;
    }
  </style>
</head>
<body class="h-screen">
  <div class="flex flex-col md:flex-row h-full">
    <!-- Info Section -->
    <div class="w-full md:w-1/2 relative bg-gradient-to-br from-green-700 via-green-800 to-gray-900 text-white flex flex-col items-center justify-center p-8 md:p-10">
      <!-- Overlay -->
      <div class="absolute inset-0 bg-black bg-opacity-40"></div>
      <div class="relative z-10 text-center">
        <img src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo" class="w-28 h-28 md:w-40 md:h-40 mx-auto mb-6 drop-shadow-lg">
        <h1 class="text-3xl md:text-5xl font-extrabold leading-tight mb-4 md:mb-6">Vaishvik Welfare Foundation</h1>
        <p class="text-base md:text-lg text-gray-200 max-w-md mx-auto">
          Building a better future through service, dedication, and empowerment.
        </p>
      </div>
    </div>

    <!-- Form Section -->
    <div class="w-full md:w-1/2 bg-white flex flex-col items-center justify-center p-8 md:p-10">
      <img src="{{ asset('assets/images/logo/Logowithname.png') }}" alt="Logo" class="w-28 h-28 md:w-40 md:h-40 mb-4">
      <h2 class="text-lg md:text-2xl text-gray-700 mb-3 font-semibold">Forgot your password?</h2>
      <p class="text-sm md:text-base text-gray-600 mb-4 text-center max-w-md">
        No problem. Just enter your email address below and we will send you a password reset link.
      </p>

      <div class="form-container w-full max-w-md">
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="w-full space-y-6">
          @csrf

          <!-- Email Address -->
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
            <input 
              type="email" 
              id="email" 
              name="email" 
              :value="old('email')" 
              required 
              autofocus
              placeholder="Enter your email"
              class="w-full h-12 md:h-14 px-4 text-base border border-gray-400 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-500"
            >
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
          </div>

          <!-- Submit Button -->
          <div>
            <button type="submit" class="w-full h-12 md:h-14 bg-blue-600 text-white rounded-lg text-md font-semibold shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
              Email Password Reset Link
            </button>
          </div>

          <!-- Back to Login -->
          <div class="text-center">
            <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:text-blue-800 underline">
              Back to Login
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
