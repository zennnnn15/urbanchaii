<link
rel="stylesheet"
href="https://unpkg.com/swiper/swiper-bundle.min.css"
/>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<style>



    @import url("https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600&family=Roboto:wght@300;400;500;900&display=swap");

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Open Sans", sans-serif;

}


main {
  position: relative;
  width: calc(min(90rem, 90%));
  margin: 0 auto;
  min-height: 100vh;
  column-gap: 3rem;
  padding-block: min(20vh, 3rem);

}

.bg {
  position: fixed;
  top: -4rem;
  left: -12rem;
  z-index: -1;
  opacity: 0;
}

.bg2 {
  position: fixed;
  bottom: -2rem;
  right: -3rem;
  z-index: -1;
  width: 9.375rem;
  opacity: 0;
}

main > div span {
  text-transform: uppercase;
  letter-spacing: 1.5px;
  font-size: 1rem;
  color: #717171;
}

main > div h1 {
  text-transform: capitalize;
  letter-spacing: 0.8px;
  font-family: "Roboto", sans-serif;
  font-weight: 900;
  font-size: clamp(3.4375rem, 3.25rem + 0.75vw, 4rem);
  background-color: #005baa;
  background-image: linear-gradient(45deg, #005baa, #000000);
  background-size: 100%;
  background-repeat: repeat;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  -moz-background-clip: text;
  -moz-text-fill-color: transparent;
}

main > div hr {
  display: block;
  background: #005baa;
  height: 0.25rem;
  width: 6.25rem;
  border: none;
  margin: 1.125rem 0 1.875rem 0;
}

main > div p {
  line-height: 1.6;
}

main a {
  display: inline-block;
  text-decoration: none;
  text-transform: uppercase;
  color: #ffffff;
  font-weight: 500;
  background: #52ba03;
  border-radius: 3.125rem;
  transition: 0.3s ease-in-out;
}

main > div > a {
  border: 2px solid #7d7171;
  margin-top: 2.188rem;
  padding: 0.625rem 1.875rem;
}

main > div > a:hover {
  border: 0.125rem solid #ff1500;
  color: #ff007b;
}


@media screen and (min-width: 48rem) {
  main {
    display: flex;
    align-items: center;
  }
  .bg,
  .bg2 {
    opacity: 0.1;
  }
}

@media screen and (min-width: 93.75rem) {
  .swiper {
    width: 85%;
  }
}


</style>

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

<main>
     <!-- Add this on the left side of your page, outside of the modal -->
   
     <div class="bg-gray-100 sidebar flex flex-col">
      <div class="px-6">
        <div class="mt-12">
          <p class="font-medium text-xl">My Order 😎</p>
        </div>
       
        <div class="mt-12 p-6 bg-purple-800 custom-rounded font-hairline text-xs">
          <div class="flex justify-between items-center">
            
            <p class="text-white">{{$user->address}}</p>
            <p class="text-yellow-400 cursor-pointer">Edit</p>
          </div>
        
        </div>
        <div v-for="(item, index) in cartItems" class="grid grid-cols-4 gap-1 mb-5" :class="{'mt-12' : index == 0}">
          <div class="h-10 rounded-lg" :style="{ backgroundSize: 'cover', backgroundRepeat: 'no-repeat' , backgroundImage: 'url(\'' + item.image + '\')' }"></div>
         
          <div class="flex justify-end items-center text-gray-600 font-hairline text-xs">
     
          </div>
        </div>
        @foreach($carts as $cart)
         <div class="grid grid-cols-4 gap-1 mb-5">
      
          <div class="col-span-2 grid grid-cols-3 text-xxs font-semibold ">

            <p class="col-span-2 flex justify-center items-center">{{$cart->quantity}} x</p>
            <p class="flex items-center">{{$cart->milktea_size_name}}</p>
          </div>
          <div class="flex justify-end items-center text-gray-600 font-hairline text-xs">
         {{$cart->total}}
          </div>
          <div class="flex justify-end items-center text-gray-600 font-hairline text-xs">
            <button class="remove-btn" data-milktea-id="{{ $cart->milktea_id }}">Remove</button>
        </div>
        </div>
        @endforeach
      </div>


      <div class="flex-grow flex flex-col pl-6 justify-end">
        <div class="flex justify-between items-center border-b-2 pb-2">
          <span>Total:</span>
          <span id="totalPriceDisplay" class="text-xl font-medium pr-6">0.00 Pesos</span>
        </div>
        
        <div class="flex justify-between pt-4 text-xs font-bold">
          <div class="ml-auto">
            @if($carts->isEmpty())
            <span class="bg-yellow-400 p-6 rounded-l-lg flex items-center justify-center text-white opacity-50 cursor-not-allowed">
                Checkout <i class="ml-3 fa fa-arrow-right"></i>
            </span>
        @else
        <form method="GET" action="{{ route('checkoutw') }}">
         <label for="">
          Mode of Payment
         </label>
        <div>
        <label>
          <input type="radio" name="typeofdelivery" value="1" checked>
          Cash on Delivery
        </label>
        <label>
          <input type="radio" name="typeofdelivery" value="2">
          Pick Up
        </label>
          </div>
          <!-- Submit button -->
          <button type="submit" class="bg-yellow-400 p-6 rounded-l-lg flex items-center justify-center text-white hover:bg-yellow-500 transition duration-300">
            Checkout <i class="ml-3 fa fa-arrow-right"></i>
          </button>
        </form>
        
      
        @endif
          </a>
          </div>
        </div>
        
        </div>
    </div>
  </div>

 
  </main>
  
  <body>
    <center>

      <section class="mt-8">
        <div class="container mx-auto">
            <h2 class="text-2xl font-bold mb-4">Current Orders</h2>
            <div class="grid grid-cols-3 gap-4">
                <!-- Loop through ordered items -->
                
                @foreach($orderedItems as $orderedItem)
                <div class="mt-2">
                  <p>Name: {{ $orderedItem->milktea_size_name }}</p>
                  <p>Quantity: {{ $orderedItem->quantity }}</p>
                  @if($orderedItem->status == 1)
                      <span class="inline-block px-2 py-1 bg-yellow-500 text-white rounded-lg">Pending</span>
                  @elseif($orderedItem->status == 2)
                      <span class="inline-block px-2 py-1 bg-green-500 text-white rounded-lg">Done</span>
                  @elseif($orderedItem->status == 3)
                      <span class="inline-block px-2 py-1 bg-red-500 text-white rounded-lg">Cancelled</span>
                  @else
                      <span class="inline-block px-2 py-1 bg-gray-500 text-white rounded-lg">Unknown</span>
                  @endif
              </div>
                
                @endforeach
                
             
               
            </div>
        </div>
    </section>
   
    <section class="mt-8"></section>
    <br>
    <hr>
    <br>
    <section class="mt-8">
      <div class="container mx-auto">
        <h2 class="text-2xl font-bold mb-4">Past Orders</h2>
          <div class="grid grid-cols-3 gap-4">
              <!-- Loop through ordered items -->
              @foreach($doneItems as $orderedItem)
                  <div class="bg-blue shadow-md rounded p-4">
                      <!-- Display ordered item details -->
                      <!-- Example: -->
                      <p>Name: {{ $orderedItem->milktea_size_name }}</p>
                      <p>Quantity: {{ $orderedItem->quantity }}</p>
                      @if($orderedItem->status == 1)
                      <span class="inline-block px-2 py-1 bg-yellow-500 text-white rounded-lg">Pending</span>
                  @elseif($orderedItem->status == 2)
                      <span class="inline-block px-2 py-1 bg-green-500 text-white rounded-lg">Done</span>
                  @elseif($orderedItem->status == 3)
                      <span class="inline-block px-2 py-1 bg-red-500 text-white rounded-lg">Cancelled</span>
                  @else
                      <span class="inline-block px-2 py-1 bg-gray-500 text-white rounded-lg">Unknown</span>
                  @endif
                      
                  </div>
              @endforeach
              
           
             
          </div>
      </div>
  </section>
  <br>
  <br><br>
    <footer class="bg-gray-900">
      <div class="max-w-screen-xl px-4 pt-16 pb-6 mx-auto sm:px-6 lg:px-8 lg:pt-24">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
          <div>
            <div class="flex justify-center text-teal-300 sm:justify-start">
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
            </div>
    
            <p
              class="max-w-md mx-auto mt-6 leading-relaxed text-center text-gray-400 sm:max-w-xs sm:mx-0 sm:text-left"
            >
             A Cup of goodness.
            </p>
    
            <ul class="flex justify-center gap-6 mt-8 md:gap-8 sm:justify-start">
              <li>
                <a
                  href="/"
                  rel="noopener noreferrer"
                  target="_blank"
                  class="text-teal-500 transition hover:text-teal-500/75"
                >
                  <span class="sr-only">Facebook</span>
                  <svg
                    class="w-6 h-6"
                    fill="currentColor"
                    viewBox="0 0 24 24"
                    aria-hidden="true"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                      clip-rule="evenodd"
                    />
                  </svg>
                </a>
              </li>
    
              <li>
                <a
                  href="/"
                  rel="noopener noreferrer"
                  target="_blank"
                  class="text-teal-500 transition hover:text-teal-500/75"
                >
                  <span class="sr-only">Instagram</span>
                  <svg
                    class="w-6 h-6"
                    fill="currentColor"
                    viewBox="0 0 24 24"
                    aria-hidden="true"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                      clip-rule="evenodd"
                    />
                  </svg>
                </a>
              </li>
    
             
    
              
    
            
            </ul>
          </div>
    
          <div
            class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:col-span-2 md:grid-cols-4"
          >
      
    
            <div class="text-center sm:text-left">
              <p class="text-lg font-medium text-white">Contact Us</p>
    
              <ul class="mt-8 space-y-4 text-sm">
                <li>
                  <a
                    class="flex items-center justify-center sm:justify-start gap-1.5 group"
                    href="/"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="w-5 h-5 text-white shrink-0"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                      stroke-width="2"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                      />
                    </svg>
    
                    <span class="text-white transition group-hover:text-white/75">
                      UrbanChai21@gmail.com
                    </span>
                  </a>
                </li>
    
                <li>
                  <a
                    class="flex items-center justify-center sm:justify-start gap-1.5 group"
                    href="/"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="w-5 h-5 text-white shrink-0"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                      stroke-width="2"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                      />
                    </svg>
    
                    <span class="text-white transition group-hover:text-white/75">
                      09053423492
                    </span>
                  </a>
                </li>
    
                <li
                  class="flex items-start justify-center gap-1.5 sm:justify-start"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5 text-white shrink-0"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                    />
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                    />
                  </svg>
    
                  <address class="-mt-0.5 not-italic text-white">
                    143 Mirador St, Cato Infanta Pangasinan
                  </address>
                </li>
              </ul>
            </div>
          </div>
        </div>
    
        <div class="pt-6 mt-12 border-t border-gray-800">
          <div class="text-center sm:flex sm:justify-between sm:text-left">
            <p class="text-sm text-gray-400">
              <span class="block sm:inline">All rights reserved.</span>
    
              <a
                class="inline-block text-teal-500 underline transition hover:text-teal-500/75"
                href="/"
              >
                Terms & Conditions
              </a>
    
              <span>&middot;</span>
    
              <a
                class="inline-block text-teal-500 underline transition hover:text-teal-500/75"
                href="/"
              >
                Privacy Policy
              </a>
            </p>
    
            <p class="mt-4 text-sm text-gray-500 sm:order-first sm:mt-0">
              &copy; Systema Tech 2023
            </p>
          </div>
        </div>
      </div>
    </footer>
    
    </center>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
      // Retrieve all the prices and calculate the total
      const cartItems = {!! json_encode($carts) !!}; // Assuming $carts contains your cart items
      const total = cartItems.reduce((accumulator, cart) => accumulator + parseFloat(cart.total), 0);
      
      // Display the total price
      const totalPriceDisplay = document.getElementById('totalPriceDisplay');
      totalPriceDisplay.textContent = `${total.toFixed(2)} Pesos`; // Display total with 2 decimal places
    </script>

<script>
  // Add event listener to the checkout link
  
  document.getElementById('checkoutBtn').addEventListener('click', function(event) {
      event.preventDefault(); // Prevent the default behavior of the link
      
      // Display SweetAlert confirmation dialog
      Swal.fire({
          title: 'Are you sure?',
          text: "Do you want to proceed to checkout?",
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, checkout!',
          cancelButtonText: 'Cancel'
      }).then((result) => {
          if (result.isConfirmed) {
              // If user confirms, proceed to the checkout page
              window.location.href = "{{ route('checkoutw') }}";
          }
      });
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Add event listeners to all "Remove" buttons
    document.querySelectorAll('.remove-btn').forEach(button => {
        button.addEventListener('click', function() {
            const milkteaId = this.dataset.milkteaId;

            // Display SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to remove this item from the cart?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, remove it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send an AJAX request to remove the item from the cart
                    fetch(`/remove-from-cart/${milkteaId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}', // Add CSRF token for Laravel
                            'Content-Type': 'application/json'
                        },
                    })
                    .then(response => {
                        if (response.ok) {
                            // Reload the page after successful removal
                            location.reload();
                        } else {
                            // Handle errors if necessary
                            console.error('Error removing item from cart');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                }
            });
        });
    });
</script>

  

<style>



body * {
  font-family: 'Poppins', sans-serif;
}



.sidebar {
  flex: 1;
}

.custom-rounded {
  border-radius: 25px;
}

.custom-tr-rounded {
  border-radius:  0 25px 0 0;
}


.timer {
  background: rgba(217, 194, 105, .2);
}

.text-xxs {
  font-size: .7rem;
}
  


</style>


  </body>
  <script>
    // Retrieve all the prices and calculate the total
    const cartItems = {!! json_encode($carts) !!}; // Assuming $carts contains your cart items
    const total = cartItems.reduce((accumulator, cart) => accumulator + parseFloat(cart.total), 0);
  
    // Set the total price in the input field
    const totalPriceInput = document.getElementById('totalPrice');
    totalPriceInput.value = `${total.toFixed(2)}`; // Display total with 2 decimal places
  
    // Add event listener to checkout button
    const checkoutButton = document.getElementById('checkoutButton');
    checkoutButton.addEventListener('click', function() {
      // Perform redirection to the desired route
      window.location.href = "{{ route('send.to.transaction') }}"; // Replace with your checkout route
    });
  </script>
   


<script>
    
    // Get the elements
    const addressElement = document.getElementById('address');
    const editButton = document.getElementById('editAddress');
  
    // Function to toggle between displaying address and input field
    function toggleEditAddress() {
      const currentAddress = addressElement.textContent;
  
      // Create an input element
      const inputElement = document.createElement('input');
      inputElement.type = 'text';
      inputElement.value = currentAddress;
  
      // Replace the address with the input field
      addressElement.replaceWith(inputElement);
  
      // Focus on the input field
      inputElement.focus();
  
      // Update the address when editing is finished
      inputElement.addEventListener('blur', function () {
        const newAddress = inputElement.value;
        addressElement.textContent = newAddress;
  
        // Remove the input field and show the address again
        inputElement.replaceWith(addressElement);
      });
    }
  
    // Add click event listener to the "Edit" button
    editButton.addEventListener('click', toggleEditAddress);
  </script>


