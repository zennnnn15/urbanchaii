<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage MilkTea') }}
        </h2>
    </x-slot>
    
    @section('content')
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="bg-green-200 text-green-800 p-4 mb-4 rounded-md">
                {{ session('success') }}
            </div>
        @endif
            <h1 class="text-2xl font-semibold mb-6">Milk Teas</h1>
            <a href="{{ route('milktea.create') }}" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-300 ease-in-out mb-4 inline-flex items-center">
                <i class="fas fa-plus-circle text-xl mr-2"></i>
                New MilkTea
            </a>
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($milkteas as $milktea)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $milktea->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $milktea->description }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($milktea->image)
                                    <img src="data:image/png;base64,{{ base64_encode($milktea->image) }}" alt="Milk Tea Image" class="w-16 h-16 object-cover">
                                @else
                                    No Image
                                @endif
                            </td>
                            
                            
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('milktea.show', $milktea) }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded transition duration-300 ease-in-out">
                                    Manage Size/Info
                                </a>
                            </td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>
    @endsection
</x-app-layout>
