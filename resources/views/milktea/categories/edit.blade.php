<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categories MilkTea') }}
        </h2>
    </x-slot>

    <div class="container mx-auto">
        @section('content')
            <div class="max-w-md mx-auto mt-4 bg-white p-6 rounded shadow-md">
                <h1 class="text-2xl font-semibold mb-4">Edit Milk Tea Category</h1>
                <form action="{{ route('milktea.categories.update', $category) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                        <input type="text" name="name" id="name" class="w-full p-2 border rounded-lg" value="{{ $category->name }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                        <textarea name="description" id="description" class="w-full p-2 border rounded-lg" rows="4">{{ $category->description }}</textarea>
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300 ease-in-out">Update Category</button>
                </form>
            </div>
        @endsection
    </div>
</x-app-layout>
