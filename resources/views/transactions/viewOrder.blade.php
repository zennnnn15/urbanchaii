<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Order') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-3xl font-semibold mb-6">Order Details</h1>
                    <!-- Display order details -->
                    <p><strong>Order ID:</strong> {{ $transactions->id }}</p>
                    <p><strong>Milk Tea Size:</strong> {{ $transactions->milktea_size_name }}</p>
                    <p><strong>Customer Name:</strong> {{ $transactions->customer_name }}</p>
                    <p><strong>Quantity:</strong> {{ $transactions->quantity }}</p>
                    <p><strong>Total:</strong> ₱{{ number_format($transactions->total, 2) }}</p>
                    <p><strong>Delivery Type:</strong>
                        @if($transactions->typeofdelivery == 1)
                            Cash on Delivery
                        @elseif($transactions->typeofdelivery == 2)
                            Pick Up
                        @endif
                    </p>
                    <p><strong>Status:</strong>
                        @if($transactions->status == 1)
                            Pending
                        @elseif($transactions->status == 2)
                            Done
                        @elseif($transactions->status == 3)
                            Cancelled
                        @endif
                    </p>
                    <p><strong>Address:</strong> {{ $transactions->address }}</p>
                    <p><strong>Created At:</strong> {{ $transactions->created_at }}</p>
                    <p><strong>Updated At:</strong> {{ $transactions->updated_at }}</p>
                    
                    <!-- Map section -->
                    <div id="map" style="height: 400px; width: 100%; margin-top: 20px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Leaflet.js and OpenStreetMap -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <script>
        // Initialize and display the map
        var map = L.map('map').setView([{{ $transactions->latitude }}, {{ $transactions->longitude }}], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Add a marker to show the exact location
        L.marker([{{ $transactions->latitude }}, {{ $transactions->longitude }}])
            .addTo(map)
            .bindPopup('Order Location')
            .openPopup();
    </script>
</x-app-layout>
