<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage MilkTea') }}
        </h2>
    </x-slot>

    @section('content')
    <div class="max-w-2xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
            @if($milktea->image)
            <img src="data:image/png;base64,{{ base64_encode($milktea->image) }}" alt="Milk Tea Image" class="w-32 h-32 object-cover mx-auto mb-4 rounded-full border border-gray-400">
            @else
            <span class="text-gray-500">No Image</span>
            @endif
            <h1 class="text-3xl font-semibold mb-4 text-gray-800">{{ $milktea->name }}</h1>
            <div class="mb-4">
                <p class="text-gray-700 text-lg"><strong>Description:</strong> {{ $milktea->description }}</p>
                <p class="text-gray-700 text-lg"><strong>Category:</strong> {{ $milktea->category->name }}</p>
            </div>
            <a href="{{ route('milkteasize.create', $milktea) }}" class="flex items-center justify-center mt-4 bg-indigo-500 hover:bg-indigo-600 text-white font-semibold py-2 px-4 rounded">
                <i class="fas fa-cogs mr-2"></i> Manage Available Size
            </a>
            <a href="{{ route('milkteaInSize.manage.me', $milktea) }}" class="flex items-center justify-center mt-4 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
                <i class="fas fa-eye mr-2"></i> Show Sizes
            </a>
            <a href="{{ route('milktea.edit', $milktea) }}" class="flex items-center justify-center mt-4 bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded">
                <i class="fas fa-edit mr-2"></i> Edit Milk Tea
            </a>
        </div>
    </div>
    @endsection
</x-app-layout>
