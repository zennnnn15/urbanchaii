<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Categories MilkTea') }}
        </h2>
    </x-slot>

    @section('content')
        <div class="max-w-2xl mx-auto">
            <h1 class="text-2xl font-semibold mb-4">Add Milk Tea Category</h1>
            <form action="{{ route('milktea.categories.store') }}" method="POST" class="bg-white p-6 rounded shadow-md">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                    <input type="text" name="name" id="name" class="w-full p-2 border rounded-lg" required>
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                    <textarea name="description" id="description" class="w-full p-2 border rounded-lg" rows="4"></textarea>
                </div>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-300 ease-in-out" id="submit-button">Add Category</button>
            </form>
        </div>

       
    @endsection
</x-app-layout>
