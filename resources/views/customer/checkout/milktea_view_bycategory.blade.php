
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Milk Tea Shop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.7/dist/tailwind.min.css">
</head>
<body class="bg-black text-white">
    <!-- Navigation Bar -->
    <nav class="bg-black p-4">
        <div class="container mx-auto flex justify-between items-center">
            <style>
                #logo {
                    height: 70px; /* Set the desired height for your logo */
                }
            </style>
            <div class="space-x-2 flex items-center">
                <a class="text-white" href="#">
                    <img id="logo" src="{{ asset('images/logo.png') }}" alt="Logo">
                </a>
                <span class="text-white font-bold text-2xl">Urban Chai</span>
            </div>
            
            <ul class="flex space-x-4">
                @auth('customer')
                    <!-- Display the username -->
                    <li class="text-white">{{ auth('customer')->user()->name }}</li>
                    <a href="{{route('customer.menu') }}" class="text-white hover:text-gray-300" id="">Menu</a>
      <a href="{{route('cart.show') }}" class="text-white hover:text-gray-300" id="">My Orders</a>
                    
                    <!-- Add Logout link for authenticated customers -->
                    <li>
                        <form method="POST" action="{{route('customer.logout')}}">
                            @csrf
                            <button type="submit" class="text-white hover:text-gray-300">Logout</button>
                        </form>
                    </li>
                @else
                    <!-- Add Login link for guests -->
                    <li><a href="{{ route('customer.login') }}" class="text-white hover:text-gray-300">Login</a></li>
                @endauth
            </ul>
        </div>
      </nav>

    <!-- Hero Section -->
    <header class="bg-green-100 py-16">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl text-black font-bold">Welcome to Urban Chai</h1>
            <p class="text-lg text-black mt-4">Explore our delicious milk tea flavors.</p>
            <a href="#" class="bg-black text-white px-6 py-2 rounded-full mt-6 inline-block hover:bg-green-600 transition duration-300">Order Now</a>
        </div>
    </header>

    <!-- Featured Products Section -->
    <section class="py-12">
        <div class="container mx-auto">
            <h2 class="text-3xl text-white font-bold text-center">MilkTea in this Category</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mt-6">
                @forelse ($milktea as $item)
                    <div class="bg-white p-6 rounded-lg shadow-md flex flex-col justify-between transition duration-300 transform hover:scale-105">
                        <div class="flex items-center justify-center mb-4">
                            @if($item->image)
                                <img src="data:image/png;base64,{{ base64_encode($item->image) }}" alt="Milk Tea Image" class="w-16 h-16 object-cover rounded-full">
                            @else
                                <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center">
                                    No Image
                                </div>
                            @endif
                        </div>
                        <div class="text-center">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $item->name }}</h3>
                            <p class="text-gray-600 text-sm mb-4">{{ $item->description }}</p>
                           
                        </div>
                        <a href="{{ route('cart.add', ['id' => $item->id]) }}" class="flex items-center justify-center bg-indigo-600 text-white px-6 py-2 rounded-full mt-4 hover:bg-indigo-700 transition duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            See Sizes Available
                        </a>
                    </div>
                @empty
                    <div class="text-center text-gray-600 col-span-3">
                        No milk teas found in this category.
                    </div>
                @endforelse
            </div>
            
            
            
            
              

               
            </div>
        </div>
    </section>


</body>
</html>
