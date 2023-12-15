<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage MilkTea') }}
        </h2>
    </x-slot>

    @section('content')
    <div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
        <h1 class="text-2xl font-semibold mb-6">Edit Milk Tea</h1>
        <form method="POST" action="{{ route('milktea.update', $milktea) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="grid grid-cols-2 gap-6">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-600">Name:</label>
                    <input type="text" name="name" id="name" value="{{ $milktea->name }}" class="mt-1 p-2 rounded-md border border-gray-300 w-full">
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-600">Description:</label>
                    <textarea name="description" id="description" class="mt-1 p-2 rounded-md border border-gray-300 w-full">{{ $milktea->description }}</textarea>
                </div>
                <div class="mb-4">
                    <label for="category" class="block text-sm font-medium text-gray-600">Category:</label>
                    <select name="category" id="category" class="mt-1 p-2 rounded-md border border-gray-300 w-full">
                        @foreach($category as $categ)
                            <option value="{{ $categ->id }}" {{ $categ->id == $milktea->category->id ? 'selected' : '' }}>
                                {{ $categ->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <div id="image-last" class="mb-2 text-red-500">Old Image:</div>
                    <img src="data:image/png;base64,{{ base64_encode($milktea->image) }}" alt="Milk Tea Image" class="w-32 h-32 object-cover border border-gray-300">
                </div>
                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-600">Image:</label>
                    <input type="file" name="image" id="image" class="mt-1 p-2 rounded-md border border-gray-300 w-full" accept="image/*" onchange="previewImage(this)">
                </div>
                <div class="mb-4 col-span-2">
                    <div id="image-message" class="mb-2 text-red-500">No Image to Preview</div>
                    <img id="image-preview" src="{{ $milktea->image ? asset('images/' . $milktea->image) : 'data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=' }}" alt="Image Preview" class="w-32 h-32 object-cover border border-gray-300">
                </div>
                <div class="col-span-2 flex justify-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline-blue">
                        Update Milk Tea
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var preview = document.getElementById('image-preview');
            var message = document.getElementById('image-message');
            preview.style.display = 'none';
            message.style.display = 'block';

            function previewImage(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        preview.src = e.target.result;
                        message.style.display = 'none';
                        preview.style.display = 'block';
                    };
                    reader.readAsDataURL(input.files[0]);
                } else {
                    preview.style.display = 'none';
                    message.style.display = 'block';
                }
            }

            var imageInput = document.getElementById('image');
            imageInput.addEventListener('change', function() {
                previewImage(this);
            });
        });
    </script>
    @endsection
</x-app-layout>
