<!-- resources/views/transactions/index.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Customer Orders') }}
        </h2>
    </x-slot>
    <div id="manage-modal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
        <!-- Modal content -->
        <div class="bg-white p-8 rounded-lg shadow-lg">
            <h2 class="text-2xl font-semibold mb-4">Update Status</h2>
    
            <!-- Status update form -->
            <form id="status-update-form">
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700">Select Status</label>
                    <select id="status" name="status" class="mt-1 p-2 border rounded-md w-full">
                        <option value="1">Pending</option>
                        <option value="2">Done</option>
                        <option value="3">Cancelled</option>
                    </select>
                </div>
    
                <div class="flex justify-end">
                    <button type="button" id="close-modal" class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded-md mr-2">Close</button>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update Status</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        function openModal(transactionId) {
            // Show the modal
            document.getElementById('manage-modal').classList.remove('hidden');
    
            // Set the transaction ID in the form action or use it as needed
            document.getElementById('status-update-form').action = '/transactions/' + transactionId;
    
            // Set a click event listener for the form submission
            document.getElementById('status-update-form').addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission
    
                // Get the selected status value from the dropdown
                const status = document.getElementById('status').value;
    
                // Send an AJAX request to update the status
                fetch('/transactions/' + transactionId, {
                    method: 'PATCH', // Assuming you're using PATCH method for updating
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        status: status
                    })
                })
                .then(response => response.json())
                .then(data => {
                    // Handle the response if needed (e.g., close the modal, update UI)
                    console.log(data); // Log the response for debugging
                    document.getElementById('manage-modal').classList.add('hidden'); // Close the modal
                    window.location.reload(); // Refresh the page
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        }
    
        // Close modal function (optional)
        document.getElementById('close-modal').addEventListener('click', function() {
            document.getElementById('manage-modal').classList.add('hidden');
        });
    </script>
    
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-3xl font-semibold mb-6">Current Customer Orders</h1>
                    <div class="mb-4">
                        <input type="text" id="search" placeholder="Search..." class="border border-gray-300 rounded p-2">
                    </div>
                    
                    <table id="transactions-table"  class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Milktea Size</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Quantity</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Mode of Payement</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Customer</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Time</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                            <tr>
                                <td class="px-6 py-4">{{ $transaction->id }}</td>
                                <td class="px-6 py-4">{{ $transaction->milktea_size_name}}</td>
                                <td class="px-6 py-4">{{ $transaction->quantity }}</td>
                                <td class="px-6 py-4">₱{{ number_format($transaction->total, 2) }}</td>
                                <td class="px-6 py-4">
                                    @if($transaction->typeofdelivery == 1)
                                        <button class="bg-yellow-400 rounded px-2 py-1 text-white" onclick="redirectToPage('{{ $transaction->id }}')">Cash on Delivery - Click to View Info</button>
                                    @elseif($transaction->typeofdelivery == 2)
                                        <span class="bg-blue-400 rounded px-2 py-1 text-white">Pick Up</span>
                                    @endif
                                </td>
                                <script>
                                    function redirectToPage(transactionId) {
                                        // Redirect to a new page with the transaction ID
                                        window.location.href = `/transactions/view/${transactionId}`;
                                    }
                                </script>
                                <td class="px-6 py-4">{{ $transaction->customer_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($transaction->updated_at)->diffForHumans() }}
                                </td>
                                
                                <td class="px-6 py-4">
                                    <div class="relative inline-block text-left">
                                        <!-- Button to toggle the dropdown menu -->
                                        <button id="status-toggle-{{ $transaction->id }}" type="button" class="inline-flex justify-center w-full rounded-md border shadow-sm px-4 py-2 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500
                                            @if($transaction->status == 1)
                                                bg-yellow-300 hover:bg-yellow-400 border-yellow-400 text-gray-800
                                            @elseif($transaction->status == 2)
                                                bg-green-300 hover:bg-green-400 border-green-400 text-gray-800
                                            @elseif($transaction->status == 3)
                                                bg-red-300 hover:bg-red-400 border-red-400 text-gray-800
                                            @else
                                                bg-gray-300 hover:bg-gray-400 border-gray-400 text-gray-800
                                            @endif">
                                            @if($transaction->status == 1)
                                                Pending
                                            @elseif($transaction->status == 2)
                                                Done
                                            @elseif($transaction->status == 3)
                                                Cancelled
                                            @else
                                                Unknown
                                            @endif
                                            <!-- Arrow icon indicating the dropdown -->
                                            <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                
                                        <!-- Dropdown menu with status options -->
                                        <div id="status-dropdown-{{ $transaction->id }}" class="hidden origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                                            <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="status-toggle-{{ $transaction->id }}">
                                                <button onclick="updateStatus('{{ $transaction->id }}', 1)" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">Pending</button>
                                                <button onclick="updateStatus('{{ $transaction->id }}', 2)" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">Done</button>
                                                <button onclick="updateStatus('{{ $transaction->id }}', 3)" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">Cancelled</button>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <!-- Inside the loop -->
<td class="px-6 py-4">
    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="openModal('{{ $transaction->id }}')">Update Status</button>
</td>

                            </tr>
                        @endforeach
                        </tbody>
                       
                        
                    </table>
                    <div class="mt-4">
                        {{ $transactions->links() }}
                    </div>
                </div>
               
            </div>
        </div>
    </div>
    <script>
        const searchInput = document.getElementById('search');
        const tableRows = document.querySelectorAll('#transactions-table tbody tr');
    
        searchInput.addEventListener('input', function() {
            const searchValue = searchInput.value.toLowerCase();
    
            tableRows.forEach(row => {
                const columns = row.getElementsByTagName('td');
                let shouldHide = true;
    
                for (const column of columns) {
                    if (column.textContent.toLowerCase().includes(searchValue)) {
                        shouldHide = false;
                        break;
                    }
                }
    
                row.style.display = shouldHide ? 'none' : '';
            });
        });
    </script>
    
  
    
</x-app-layout>
