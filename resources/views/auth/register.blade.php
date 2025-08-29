<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Vaishvik Welfare Foundation</title>
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
  <div class="flex h-full">
    <!-- Left side -->
    <div class="w-1/2 relative bg-gradient-to-br from-green-700 via-green-800 to-gray-900 text-white flex flex-col items-center justify-center p-10">
      <!-- Overlay -->
      <div class="absolute inset-0 bg-black bg-opacity-40"></div>
      <div class="relative z-10 text-center">
        <img src="/assets/images/logo/logo.png" alt="Logo" class="w-40 h-40 mx-auto mb-8 drop-shadow-lg">
        <h1 class="text-5xl font-extrabold leading-tight mb-6">Vaishvik Welfare Foundation</h1>
        <p class="text-lg text-gray-200 max-w-md mx-auto">
          Join us in building a better future through service, dedication, and empowerment.
        </p>
      </div>
    </div>

    <!-- Right side -->
    <div class="w-1/2 bg-white flex flex-col items-center justify-center p-10">
      <img src="/assets/images/logo/Logowithname.png" alt="Logo" class="w-40 h-40 mb-1">
      <h2 class="text-2xl text-gray-700 mb-3 font-semibold">Create your account</h2>

      <div class="form-container w-full max-w-md">
        <form method="POST" action="{{ route('register') }}" class="w-full space-y-6">
          @csrf

          <!-- Name -->
          <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
            <input 
              type="text" 
              id="name" 
              name="name" 
              :value="old('name')" 
              required 
              autofocus 
              autocomplete="name"
              placeholder="Enter your name"
              class="w-full h-14 px-4 text-base border border-gray-400 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-500"
            >
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
          </div>

          <!-- Email Address -->
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
            <input 
              type="email" 
              id="email" 
              name="email" 
              :value="old('email')" 
              required 
              autocomplete="username"
              placeholder="Enter your email"
              class="w-full h-14 px-4 text-base border border-gray-400 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-500"
            >
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
          </div>

          <!-- Password -->
          <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
            <input 
              type="password" 
              id="password" 
              name="password" 
              required 
              autocomplete="new-password"
              placeholder="Enter your password"
              class="w-full h-14 px-4 text-base border border-gray-400 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-500"
            >
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
          </div>

          <!-- Confirm Password -->
          <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
            <input 
              type="password" 
              id="password_confirmation" 
              name="password_confirmation" 
              required 
              autocomplete="new-password"
              placeholder="Confirm your password"
              class="w-full h-14 px-4 text-base border border-gray-400 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-500"
            >
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
          </div>

          <!-- Register Button -->
          <div>
            <button type="submit" class="w-full h-14 bg-blue-600 text-white rounded-lg text-lg font-semibold shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
              Register
            </button>
          </div>

          <!-- Already Registered -->
          <div class="text-center">
            <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:text-blue-800 underline">
              Already have an account? Log in
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
