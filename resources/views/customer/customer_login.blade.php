<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login</title>
    <!-- Include Tailwind CSS from CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <style>
              body {
            background-image: url('{{ asset("images/background.jpg") }}'); /* Replace 'background.jpg' with your image file */
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
    </style>
</head>
<body class="bg-black-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-lg w-96">
         <center>
            <div class="mb-8 ">
                <img src="{{ asset('images/logo.png') }}" alt="Your Logo" class="w-20 h-20">
                <h1 class="text-2xl font-semibold mb-4">Customer Login</h1>
            </div>
         </center>
        
        
        <form method="POST" action="{{route('tryCustomerLogin')}}">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
                <input type="email" id="email" name="email" class="w-full px-3 py-2 border rounded-lg" placeholder="Email" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-bold mb-2">Password</label>
                <input type="password" id="password" name="password" class="w-full px-3 py-2 border rounded-lg" placeholder="Password" required>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg font-semibold hover:bg-blue-700">
                Login
            </button>
        </form>

        <p class="mt-4 text-gray-600 text-center">Don't have an account? 
            <a href="{{ route('signup.customer') }}" class="text-blue-500 hover:underline">Sign Up</a>
        </p>
    </div>
</body>
</html>
