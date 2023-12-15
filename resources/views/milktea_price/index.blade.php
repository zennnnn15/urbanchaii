<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Milktea Sizes') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="bg-green-200 text-green-800 p-4 mb-4 rounded-md">
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="bg-green-200 text-green-800 p-4 mb-4 rounded-md">
                {{ session('error') }}
            </div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4 flex justify-between items-center">
                        <h1 class="text-3xl font-semibold mb-6">Milk Tea Sizes List</h1>
                        <input type="text" id="search" placeholder="Search..." class="border border-gray-300 rounded p-2">
                    </div>
                    <div class="mb-4">
                        <a href="{{ route('milkteaInSize.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Add New
                        </a>
                    </div>
                    <table id="milktea-sizes-table" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Price
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Last Modefied
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody id="milktea-sizes-body" class="bg-white divide-y divide-gray-200">
                            <!-- Table content will be dynamically generated here -->
                        </tbody>
                    </table>
                    
                    <!-- Pagination links -->
                    {{-- <div class="mt-4">
                        {{ $milkteaSizes->links() }}
                    </div> --}}
                </div>
            </div>
        </div>
     
    </div>
    <script>
const searchInput = document.getElementById('search');
const tableBody = document.getElementById('milktea-sizes-body');
const tableHeader = document.querySelector('#milktea-sizes-table thead tr');
const months = [
        'January', 'February', 'March', 'April', 'May', 'June', 'July',
        'August', 'September', 'October', 'November', 'December'
    ];
// Original data from the server-side
const milkteaSizesData = @json($milkteaSizes);

function renderTable(data) {
    tableBody.innerHTML = '';
    data.forEach(milkteaSize => {
     
        const updatedAt = new Date(milkteaSize.updated_at);
        const formattedDate = `${months[updatedAt.getMonth()]} ${updatedAt.getDate()}, ${updatedAt.getFullYear()} ${updatedAt.getHours()}:${updatedAt.getMinutes() < 10 ? '0' : ''}${updatedAt.getMinutes()}`;
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap">${milkteaSize.id}</td>
            <td class="px-6 py-4 whitespace-nowrap">${milkteaSize.name}</td>
            <td class="px-6 py-4 whitespace-nowrap">P ${parseFloat(milkteaSize.price).toFixed(2)}</td>
            <td class="px-6 py-4 whitespace-nowrap">${formattedDate}</td>
            
            <td class="px-6 py-4 whitespace-nowrap">
    <a href="{{ url('milkteaInSize') }}/${milkteaSize.id}" class="text-blue-500 hover:text-blue-700 mr-2 py-1 px-2 border rounded border-blue-500 hover:border-blue-700">View</a>
    <a href="{{ url('milkteaInSize') }}/${milkteaSize.id}/edit" class="text-green-500 hover:text-green-700 mr-2 py-1 px-2 border rounded border-green-500 hover:border-green-700">Edit</a>
    <form action="{{ url('milkteaInSize') }}/${milkteaSize.id}" method="POST" class="inline" id="delete-form-${milkteaSize.id}">
    @csrf
    @method('DELETE')
    <button type="button" class="text-red-500 hover:text-red-700 py-1 px-2 border rounded border-red-500 hover:border-red-700 delete-button">Delete</button>
</form>

</td>

        `;
        tableBody.appendChild(row);
    });
}

searchInput.addEventListener('input', function() {
    const searchValue = searchInput.value.toLowerCase();
    const filteredData = milkteaSizesData.filter(milkteaSize => {
        return (
            milkteaSize.id.toString().includes(searchValue) ||
            milkteaSize.name.toLowerCase().includes(searchValue) ||
            milkteaSize.price.toString().includes(searchValue) ||
            new Date(milkteaSize.created_at).toLocaleString().includes(searchValue)
        );
    });
    renderTable(filteredData);
    // Set the visibility of the table header based on search results
    tableHeader.style.display = filteredData.length > 0 ? 'table-row' : 'none';
});

// Initial rendering of the table with all data
renderTable(milkteaSizesData);

document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.delete-button');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const formId = this.parentElement.id;
            Swal.fire({
                title: 'Delete Milk Tea Size',
                text: 'Are you sure you want to delete this milk tea size?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        });
    });
});


    </script>
</x-app-layout>
