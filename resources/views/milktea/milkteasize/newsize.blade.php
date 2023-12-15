<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create MilkTea Size-MilkTea Relationship') }}
        </h2>
    </x-slot>

    @section('content')
    <div class="container mx-auto p-8">
        <form action="{{ route('milkteasize.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="milktea_id" class="block text-sm font-medium text-gray-600">MilkTea:</label>
                <select name="milktea_id" id="milktea_id" class="mt-1 p-2 border border-gray-300 rounded w-full">
                    <option value="{{ $milkteaName->name }}">{{ $milkteaName->name }}</option>
                </select>
                <input type="hidden" name="milktea_id_hidden" id="milktea_id_hidden" value="{{ $milkteaName->id }}">
            </div>
            <div class="mb-4">
                <label for="milktea_size_id" class="block text-sm font-medium text-gray-600">MilkTea Size:</label>
                <select name="milktea_size_id" id="milktea_size_id" class="mt-1 p-2 border border-gray-300 rounded w-full"></select>
            </div>
            <div class="mt-4">
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700">Create Size</button>
            </div>
        </form>
    </div>

    <script>
        const milkteaDropdown = document.getElementById('milktea_id');
        const milkteaSizeDropdown = document.getElementById('milktea_size_id');
        const milkteaSizeOptions = {!! json_encode($milkteaSize) !!};

        function filterMilkteaSize() {
            const selectedMilktea = milkteaDropdown.value.toLowerCase();
            const filteredOptions = milkteaSizeOptions.filter(option => option.name.toLowerCase().includes(selectedMilktea));

            milkteaSizeDropdown.innerHTML = '';
            filteredOptions.forEach(option => {
                const newOption = document.createElement('option');
                newOption.value = option.id;
                newOption.textContent = option.name;
                milkteaSizeDropdown.appendChild(newOption);
            });
        }

        // Initial filter on page load
        filterMilkteaSize();

        milkteaDropdown.addEventListener('change', function() {
            const selectedMilkteaId = this.value;
            document.getElementById('milktea_id_hidden').value = selectedMilkteaId;
            filterMilkteaSize();
        });
    </script>
    @endsection
</x-app-layout>
