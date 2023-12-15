<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Milktea Size') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('milkteaInSize.update', $milkteaSize) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-600">Name:</label>
                            <input type="text" name="name" id="name" class="mt-1 p-2 border rounded-md w-full" value="{{ $milkteaSize->name }}" required>
                        </div>
                        <div class="mb-4">
                            <label for="price" class="block text-sm font-medium text-gray-600">Price (P):</label>
                            <input type="number" step="0.01" name="price" id="price" class="mt-1 p-2 border rounded-md w-full" value="{{ $milkteaSize->price }}" required>
                        </div>
                        <div class="flex items-center justify-end">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
