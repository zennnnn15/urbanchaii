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
    <nav class="bg-green-500 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="#" class="text-white text-2xl font-bold">Urban Chai</a>
            <ul class="flex space-x-4">
                <li><a href="#" class="text-white hover:text-green-300">Home</a></li>
                <li><a href="#" class="text-white hover:text-green-300">Menu</a></li>
                <li><a href="#" class="text-white hover:text-green-300">About Us</a></li>
                <li><a href="#" class="text-white hover:text-green-300">Contact</a></li>
                <li><a href="#" class="text-white hover:text-green-300">My Orders</a></li>

            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="bg-green-100 py-16">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl text-black font-bold">Welcome to Milk Tea Shop</h1>
            <p class="text-lg text-black mt-4">Explore our delicious milk tea flavors.</p>
            <a href="#" class="bg-black text-white px-6 py-2 rounded-full mt-6 inline-block hover:bg-green-600 transition duration-300">Order Now</a>
        </div>
    </header>

    <!-- Featured Products Section -->
    <section class="py-12">
        <div class="container mx-auto">
            <h2 class="text-3xl text-white font-bold text-center">Category</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 mt-6">
                @foreach($milkteaCategory as $milktea)
                <div class="bg-green-200 p-6 rounded-lg shadow-md">
                    <img src="{{ asset('images/cake.png') }}" alt="Milk Tea 1" class="w-full h-40 object-cover rounded-md">
                    <h3 class="text-xl text-black font-semibold mt-4">{{$milktea->name}}</h3>
                    <p class="text-gray-600 mt-2">{{$milktea->description}}</p>
                    <div class="mt-4 flex justify-between items-center">
                        <a href="{{ route('customer.categoryShow', ['id' => $milktea->id]) }}" class="bg-black text-white px-4 py-2 rounded-full hover:bg-green-600 transition duration-300">
                            Check Category
                        </a>
                    </div>
                </div>
            @endforeach
            
              

               
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="bg-green-500 text-black py-12">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold">Contact Us</h2>
            <p class="mt-4">Have questions or feedback? Feel free to reach out to us.</p>
            <a href="#" class="bg-black text-green-500 px-6 py-2 rounded-full mt-6 inline-block hover:bg-green-400 transition duration-300">Contact Us</a>
        </div>
    </section>
</body>
</html>
