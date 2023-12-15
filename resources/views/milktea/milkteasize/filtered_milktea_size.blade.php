<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage MilkTea') }}
        </h2>
    </x-slot>

    @section('content')
    <div class="container mx-auto p-8">
        <div class="mb-4 flex justify-between items-center">
            @if(session('success'))
            <div class="bg-green-200 text-green-800 p-4 mb-4 rounded-md">
                {{ session('success') }}
            </div>
        @endif
            <h1 class="text-3xl font-semibold mb-6">Milktea Size</h1>
            <input type="text" id="search" placeholder="Search..." class="border border-gray-300 rounded p-2">
        </div>
        
        
        <table id="milktea-relationships-table" class="min-w-full bg-white border border-gray-300 rounded-lg">
            <thead>
                <tr>
                    <th class="py-2 px-4 font-semibold">ID</th>
                    <th class="py-2 px-4 font-semibold">Milktea Name</th>
                    <th class="py-2 px-4 font-semibold">Milktea Size</th>
                    <th class="py-2 px-4 font-semibold">Milktea Price</th>
                    <th class="py-2 px-4 font-semibold">Category</th>
                    <th class="py-2 px-4 font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody id="milktea-relationships-body">
                @foreach($milkteaSizeMilkteas as $relationship)
                <tr>
                    <td class="py-2 px-4">{{ $relationship->id }}</td>
                    <td class="py-2 px-4">{{ $relationship->milktea->name }}</td>
                    <td class="py-2 px-4">{{ $relationship->milkteaSize->name }}</td>
                    <td class="py-2 px-4">₱{{ number_format($relationship->milkteaSize->price, 2) }}</td>
                    <td class="py-2 px-4">{{ $relationship->milktea->category->name }}</td>
                    <td class="py-2 px-4">
                       
                        <form action="{{ route('milkteasize.destroy', $relationship->id) }}" method="POST" class="inline-block ml-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-700">Delete</button>
                        </form>
                    </td>
                    
                    
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
        const searchInput = document.getElementById('search');
        const tableBody = document.getElementById('milktea-relationships-body');

        searchInput.addEventListener('input', function() {
            const searchValue = searchInput.value.toLowerCase();
            const rows = tableBody.getElementsByTagName('tr');

            for (const row of rows) {
                const columns = row.getElementsByTagName('td');
                let shouldHide = true;

                for (const column of columns) {
                    if (column.textContent.toLowerCase().includes(searchValue)) {
                        shouldHide = false;
                        break;
                    }
                }

                row.style.display = shouldHide ? 'none' : '';
            }
        });
    </script>
    @endsection
</x-app-layout>
