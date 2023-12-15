<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Milktea Size Details') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-3xl font-semibold mb-6">{{ $milkteaSize->name }}</h1>
                    <p class="text-lg mb-4">Price: P {{ number_format($milkteaSize->price, 2) }}</p>
                    @if($milkteaSize->created_at)
                        <p class="text-lg mb-4">Created At: {{ $milkteaSize->created_at->toFormattedDateString() }}</p>
                    @else
                        <p class="text-lg mb-4">Created At: N/A</p>
                    @endif
                    <!-- Add more details as needed -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
