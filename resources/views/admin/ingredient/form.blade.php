<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ isset($ingredient) ? __('Edit Ingredient') : __('Create Ingredient') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <form
                    action="{{ isset($ingredient) ? route('dashboard.ingredient.update', $ingredient->id) : route('dashboard.ingredient.store') }}"
                    method="POST" enctype="multipart/form-data" class="p-6 dark:bg-gray-800">
                    @csrf

                    @if (isset($ingredient))
                        @method('PUT')
                    @endif

                    <div class="mb-4">
                        <label for="name"
                            class="block text-base font-medium text-gray-700 dark:text-gray-300">Name</label>
                        <input type="text" name="name" id="name"
                            value="{{ isset($ingredient) ? $ingredient->name : '' }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:focus:border-indigo-500 dark:focus:ring-indigo-500 dark:text-white"
                            required>
                    </div>

                    <div class="mb-4">
                        <label for="image"
                            class="block text-base font-medium text-gray-700 dark:text-gray-300">Image</label>
                        <input type="file" name="image" id="image" onchange="previewImage(event)"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:focus:border-indigo-500 dark:focus:ring-indigo-500 dark:text-white"
                            {{ isset($ingredient) ? '' : 'required' }}>
                        <img id="imagePreview"
                            src="{{ isset($ingredient) ? Storage::disk('ingredients')->url($ingredient->image) : '' }}"
                            alt="Image Preview" class="mt-2 max-w-xl">
                    </div>

                    <div class="mb-4">
                        <label for="description"
                            class="block text-base font-medium text-gray-700 dark:text-gray-300">Description</label>
                        <textarea name="description" id="description" rows="4"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:focus:border-indigo-500 dark:focus:ring-indigo-500 dark:text-white"
                            required>{{ isset($ingredient) ? $ingredient->description : '' }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="category"
                            class="block text-base font-medium text-gray-700 dark:text-gray-300">Category</label>
                        <select name="category" id="category"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:focus:border-indigo-500 dark:focus:ring-indigo-500 dark:text-white"
                            required>
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ isset($ingredient) && $ingredient->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-700 dark:bg-green-800 dark:hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 text-white font-medium rounded-md">
                            {{ isset($ingredient) ? 'Update Ingredient' : 'Create Ingredient' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function previewImage(event) {
        const imageInput = event.target;
        const imagePreview = document.getElementById('imagePreview');

        if (imageInput.files && imageInput.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                imagePreview.src = e.target.result;
            };

            reader.readAsDataURL(imageInput.files[0]);
        } else {
            imagePreview.src = '';
        }
    }
</script>
