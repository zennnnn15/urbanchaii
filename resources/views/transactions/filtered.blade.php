<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sales Report') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <h1 class="text-4xl font-semibold mb-8">Total Sales</h1>
                <div class="flex items-center mb-6 space-x-4">
                    <label for="filter" class="text-sm font-semibold text-gray-700">Filter By:</label>
                    <select id="filter" class="px-4 py-2 border border-gray-300 rounded-md">
                        <option value="all" {{ request('filter') == 'all' ? 'selected' : '' }}>All</option>
                        <option value="today" {{ request('filter') == 'today' ? 'selected' : '' }}>Today</option>
                        <option value="week" {{ request('filter') == 'week' ? 'selected' : '' }}>Week</option>
                        <option value="month" {{ request('filter') == 'month' ? 'selected' : '' }}>Month</option>
                    </select>
                    <button id="applyFilterButton" class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200" onclick="applyFilter()">Apply Filter</button>
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
                        @foreach($filteredSales as $transaction)
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
                            <td class="px-6 py-4 text-xl font-semibold bg-blue-500 text-white" colspan="6">
                                Total Sales: ₱{{ number_format($totalSales, 2) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
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
