<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Milk Tea Shop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.7/dist/tailwind.min.css">
    

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <style>
        .nav-link:hover {
            text-decoration: underline;
        }

        .milk-tea-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .milk-tea-card:hover {
            transform: scale(1.05);
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>



<body class="bg-gray-100 text-gray-800">
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
    <div id="checkoutModal" class="modal hidden fixed inset-0 bg-black bg-opacity-50 justify-center items-center z-50">
        <div class="modal-content bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-3xl font-semibold mb-4">Add Items to Cart</h2>
            <form id="checkoutForm" method="POST">
                @csrf
                @method('POST')
                @foreach($milkteasizesAvailable as $size)
                    <input class="w-full px-4 py-2 border rounded" type="number" id="milktea_id" name="milktea_id" value="{{$size->id}}" hidden >
                @endforeach
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="quantity">Quantity:</label>
                    <input class="w-full px-4 py-2 border rounded" type="number" id="quantity" name="quantity" required>
                    <input class="w-full px-4 py-2 border rounded" type="number" id="status" name="status" value="1" hidden>
                    <input class="w-full px-4 py-2 border rounded" type="number" id="customer_id" name="customer" value="{{$customer->id}}" hidden>                    
                </div>
         
                
                <label class="block mb-4">
                    <input type="radio" name="comments" value="pick_up" class="mr-2" checked style="display: none;">
               
                </label>
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="totalPrice">Total Price:</label>
                    <input class="w-full px-4 py-2 border rounded" type="text" id="totalPrice" name="totalPrice" readonly>
                </div>
                
                
                <button type="submit"
                    class="bg-indigo-600 text-white px-6 py-3 rounded-full hover:bg-indigo-700 transition duration-300 focus:outline-none">
                    Add To Cart
                </button>
            </form>
            <button id="closeCheckoutModal"
                class="bg-gray-400 text-white px-6 py-3 rounded-full hover:bg-gray-500 transition duration-300 focus:outline-none mt-4">
                Cancel
            </button>
        </div>
    </div>

    <!-- Featured Products Section -->
    <section class="py-12 flex justify-center items-center flex-col">
        <div class="container mx-auto mb-8 flex justify-center items-center w-48 h-48 rounded-full overflow-hidden border-4 border-green-500">
            @if($getMilktea->image)
            <img src="data:image/png;base64,{{ base64_encode($getMilktea->image) }}" alt="Milk Tea Image"
                class="w-64 h-64 object-cover">
            @else
            <div class="w-64 h-64 bg-gray-200 flex items-center justify-center">
                No Image
            </div>
            @endif
        </div>
        <h2 class="text-3xl font-semibold mb-4">{{ $getMilktea->name }}</h2>
        <p class="text-gray-600 mb-8">Available Sizes:</p>

        <div class="container mx-auto flex flex-wrap justify-center items-center">
            @if($milkteasizesAvailable->isNotEmpty())
            @foreach($milkteasizesAvailable as $size)
            <div class="milk-tea-card bg-white rounded-lg shadow-md p-6 mb-6 mx-4 hover:shadow-xl">
                <h3 class="text-xl font-semibold mb-2">{{ $size->name }}</h3>
                <p class="text-gray-600 mb-4">{{ $size->price }} Pesos</p>
                <button onclick="addToCart()"
                class="bg-indigo-600 text-white px-6 py-3 rounded-full hover:bg-indigo-700 transition duration-300 focus:outline-none add-to-cart-btn">
                Buy
            </button>
            
            </div>
            @endforeach
            @else
            <p class="text-gray-600">No available sizes for this milk tea.</p>
            @endif
        </div>
    </section>
    <script>
         function openCheckoutModal() {
            const checkoutModal = document.getElementById('checkoutModal');
            checkoutModal.classList.remove('hidden');
        }

        function closeCheckoutModal() {
            const checkoutModal = document.getElementById('checkoutModal');
            checkoutModal.classList.add('hidden');
        }

        const checkoutForm = document.getElementById('checkoutForm');
        const closeCheckoutModalBtn = document.getElementById('closeCheckoutModal');

        checkoutForm.addEventListener('submit', function (event) {
            event.preventDefault();
            // Handle form submission logic (e.g., send data to server, update database)
            // After successful submission, you can redirect the user or show a success message
            // For now, let's just close the modal for demonstration purposes
            closeCheckoutModal();
            // Reset the form if needed: checkoutForm.reset();
        });

        closeCheckoutModalBtn.addEventListener('click', closeCheckoutModal);

        function addToCart() {
            // Implement your "Add to Cart" logic here
            // For demonstration purposes, let's show the checkout modal after clicking "Add to Cart"
            openCheckoutModal();
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Calculate total price based on quantity and price per unit
            $('#quantity').on('input', function () {
                calculateTotalPrice();
            });
    
            // Calculate total price when checkout option is changed
            $('input[name="comments"]').on('change', function () {
                calculateTotalPrice();
            });
    
            function calculateTotalPrice() {
                var quantity = parseInt($('#quantity').val()) || 0;
                var pricePerUnit = parseFloat({{ $milkteasizesAvailable[0]->price }}); // Replace with the actual price from your backend
    
                var totalPrice = quantity * pricePerUnit;
    
                // Add 40 to totalPrice if checkout option is cash_on_delivery
                if ($('input[name="comments"]:checked').val() === 'cash_on_delivery') {
                    totalPrice += 0;
                }
    
                // Update the total price input field
                $('#totalPrice').val(totalPrice.toFixed(2));
            }
    
            // Handle form submission
            $('#checkoutForm').on('submit', function (event) {
                event.preventDefault();
    
                // Perform form submission logic here
                // You can use AJAX to send the form data to the server if needed
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <!-- Include SweetAlert library (CDN example) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    $(document).ready(function () {
        // Handle form submission using AJAX
        $('#checkoutForm').on('submit', function (event) {
            event.preventDefault();

            // Get form data
            var formData = $(this).serialize();

            $.ajax({
                url: '{{ route('checkout.store') }}', // Use the named route for your controller function
                method: 'POST',
                data: formData,
                success: function (response) {
                    // Show SweetAlert notification on success
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Order Sent',
                    });
                },
                error: function (xhr, status, error) {
                    // Handle error and display the error message
                    var errorMessage = xhr.responseText; // Get the error message from the response
                    console.error(errorMessage); // Log the error message to console (for debugging)
                    // Optionally, display the error message to the user
                    // Example: $('#errorContainer').text(errorMessage);
                }
            });
        });
    });
</script>

    
    
    
</body>
</body>

</html>
