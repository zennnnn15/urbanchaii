<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categories MilkTea') }}
        </h2>
    </x-slot>

    @section('content')
        <h1 class="text-2xl font-semibold mb-4">Milk Tea Categories</h1>
        <a href="{{ route('milktea.categories.create') }}" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-300 ease-in-out mb-4 inline-block">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block -mt-1 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Category
        </a>
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Description</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Last Updated</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                    
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($categories as $category)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $category->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $category->description }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($category->updated_at)->diffForHumans() }}
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('milktea.categories.edit', $category) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white py-2 px-4 rounded-full focus:outline-none focus:ring focus:ring-indigo-300">
                                Edit
                            </a>
                            <form action="{{ route('milktea.categories.destroy', $category) }}" method="POST" class="inline" id="delete-form-{{ $category->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete('{{ $category->id }}')" class="bg-red-500 hover:bg-red-700 text-white py-2 px-4 rounded-full focus:outline-none focus:ring focus:ring-red-300">
                                    Delete
                                </button>
                            </form>
                        </td>
                        
                        
                @endforeach
            </tbody>
        </table>
    @endsection
</x-app-layout>
<style>
    .swal2-popup {
        width: 400px; /* Adjust the width as needed */
        height: auto; /* You can set a specific height if required */
        padding: 20px;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDelete(categoryId) {
        Swal.fire({
            title: 'Delete Category',
            text: 'Are you sure you want to delete this category?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // User confirmed, proceed with deletion
                document.getElementById('delete-form-' + categoryId).submit();
            }
        });
    }
</script>
