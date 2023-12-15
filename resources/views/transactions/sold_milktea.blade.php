<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sales Report') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-3xl font-semibold mb-6">Total Sales (Status: Done)</h1>
                    <div class="mb-4">
                        <label for="filter" class="text-sm font-semibold text-gray-700">Filter By:</label>
                        <select id="filter" class="ml-2 p-2 border rounded-md">
                            <option value="today">Today</option>
                            <option value="week">Week</option>
                            <option value="month">Month</option>
                        </select>
                        <button id="applyFilterButton" class="p-2 bg-blue-500 text-white rounded-md" onclick="applyFilter()">Apply Filter</button>

                    </div>
                    
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Milktea Size</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Quantity</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Customer</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Time</th>
                            </tr>
                        </thead>
                        <tbody id="sales-table-body">
                            @foreach($totalSales as $transaction)
                                <tr>
                                    <td class="px-6 py-4">{{ $transaction->id }}</td>
                                    <td class="px-6 py-4">{{ $transaction->milktea_size_name}}</td>
                                    <td class="px-6 py-4">{{ $transaction->quantity }}</td>
                                    <td class="px-6 py-4">₱{{ number_format($transaction->total, 2) }}</td>
                                    <td class="px-6 py-4">{{ $transaction->customer_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($transaction->updated_at)->diffForHumans() }}
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td class="px-6 py-4 text-xl font-semibold bg-blue-500 text-white">
                                    Total Sales: ₱{{ number_format($totalAmount, 2) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $totalSales->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function applyFilter() {
            const selectedFilter = document.getElementById('filter').value;
            window.location.href = `/sales/filtered?filter=${selectedFilter}`;
        }
    </script>
    
</x-app-layout>
