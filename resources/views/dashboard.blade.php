<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-xl mb-4">Welcome, Admin!</h3>
                    <p>You're logged in as an admin. Here, you can manage various aspects of your milk tea shop:</p>
                    <ul class="list-disc pl-6">
                        <div id="piechart" style="width: 100%; height: 500px;"></div>
                    </ul>
                    <h4 class="text-lg font-semibold mt-6 mb-2">Recent Orders</h4>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Order ID</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Customer Name</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Ordered Items</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loop through recent orders and populate the table rows -->
                            @foreach($recentOrders as $order)
                                <tr>
                                    <td class="px-6 py-4">{{ $order->id }}</td>
                                    <td class="px-6 py-4">{{ $order->customer_name }}</td>
                                    <td class="px-6 py-4">{{ $order->milktea_size_name }}</td>
                                    <td class="px-6 py-4">{{ $order->total }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
    
        function drawChart() {
            var totalSalesData = @json($totalSales);
    
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Milktea Size');
            data.addColumn('number', 'Total Sales');
    
          
            // Assuming 'sale.total' is a string, convert it to a number before adding it to the DataTable
totalSalesData.forEach(function(sale) {
    data.addRow([sale.milktea_size_name, parseFloat(sale.total)]);
});

    
            var options = {
                title: 'Total Sales by Milktea Size',
                pieHole: 0.4,
            };
    
            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
            chart.draw(data, options);
        }
    </script>

</x-app-layout>
