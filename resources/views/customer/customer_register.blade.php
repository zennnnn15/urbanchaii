<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
        body {
            background-image: url('{{ asset("images/background.jpg") }}'); /* Replace 'background.jpg' with your image file */
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
    </style>
</head>
<body class="bg-gray-100 flex flex-col items-center justify-center">
  
    <form id="registrationForm" class="bg-white p-8 rounded shadow-lg w-3/4" method="POST" action="{{ route('try.signup.customer') }}">
        @csrf
        <center>
            <div class="mb-8 ">
                <img src="{{ asset('images/logo.png') }}" alt="Your Logo" class="w-20 h-20">
            </div>
        </center>
        <h1 class="text-2xl font-semibold mb-4 text-center">Customer Registration</h1>

        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-bold mb-2">Name:</label>
            <input type="text" id="name" name="name" class="w-full px-3 py-2 border rounded-lg" placeholder="Name" required>
        </div>
        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-bold mb-2">Email:</label>
            <input type="email" id="email" name="email" class="w-full px-3 py-2 border rounded-lg" placeholder="Email" required>
        </div>
        <div class="mb-4">
            <label for="password" class="block text-gray-700 font-bold mb-2">Password:</label>
            <input type="password" id="password" name="password" class="w-full px-3 py-2 border rounded-lg" placeholder="Password" required>
        </div>
        <div class="mb-4">
            <label for="address" class="block text-gray-700 font-bold mb-2">Address:</label>
            <input type="text" id="address" name="address" class="w-full px-3 py-2 border rounded-lg" placeholder="Address">
        </div>
        <input type="hidden" id="longitude" name="longitude">
        <input type="hidden" id="latitude" name="latitude">
        <div id="map" class="mb-4 border"></div>

        <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg font-semibold hover:bg-blue-700">Register</button>
        <p class="mt-4 text-gray-600 text-center">Have an account? 
            <a href="{{ route('customer.login') }}" class="text-blue-500 hover:underline">Log In</a>
        </p>
    </form>
   
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([15.8252778, 119.9069444], 14); 

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var marker = L.marker([15.8252778, 119.9069444], { draggable: true }).addTo(map);

        marker.on('dragend', function (e) {
            var coordinates = e.target.getLatLng();
            getAddressFromCoordinates(coordinates);
            updateHiddenFields(coordinates);
        });
        
        function updateHiddenFields(coordinates) {
            document.getElementById("longitude").value = coordinates.lng;
            document.getElementById("latitude").value = coordinates.lat;
        }

        function getAddressFromCoordinates(coordinates) {
            fetch('https://nominatim.openstreetmap.org/reverse?format=json&lat=' + coordinates.lat + '&lon=' + coordinates.lng + '&addressdetails=1')
                .then(response => response.json())
                .then(data => {
                    let address = '';
                    if (data.address) {
                        address = `${data.address.road || ''}, ${data.address.neighbourhood || ''}, ${data.address.city || ''}, ${data.address.state || ''}, ${data.address.country || ''}`;
                    }
                    document.getElementById("address").value = address;
                    console.log(address);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        // Handle form submission
       
    </script>
</body>

</html>
