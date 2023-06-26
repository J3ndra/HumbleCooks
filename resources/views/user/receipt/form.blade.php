<x-app-user-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Receipt') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <form action="{{ route('create_receipt_view') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="block font-medium text-gray-700">Name</label>
                            <input type="text" name="name" id="name"
                                class="form-input rounded-md shadow-sm mt-1 block w-full" value="{{ old('name') }}"
                                required autofocus />
                            @error('name')
                                <p class="text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="thumbnail" class="block font-medium text-gray-700">Thumbnail</label>
                            <input type="file" name="thumbnail" id="thumbnail"
                                class="form-input rounded-md shadow-sm mt-1 block w-full" required />
                            @error('thumbnail')
                                <p class="text-red-500 mt-1">{{ $message }}</p>
                            @enderror

                            <!-- Preview thumbnail -->
                            <div id="thumbnail-preview" class="mt-2">
                                <!-- Placeholder for thumbnail preview -->
                            </div>
                        </div>


                        <div class="mb-4">
                            <label for="description" class="block font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" class="form-textarea rounded-md shadow-sm mt-1 block w-full" required>{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="cal_total" class="block font-medium text-gray-700">Total Calories</label>
                            <input type="number" name="cal_total" id="cal_total"
                                class="form-input rounded-md shadow-sm mt-1 block w-full" value="{{ old('cal_total') }}"
                                required />
                            @error('cal_total')
                                <p class="text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="est_price" class="block font-medium text-gray-700">Estimated Price</label>
                            <input type="number" name="est_price" id="est_price"
                                class="form-input rounded-md shadow-sm mt-1 block w-full" value="{{ old('est_price') }}"
                                required />
                            @error('est_price')
                                <p class="text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Steps -->
                        <div class="mb-4">
                            <label class="block font-medium text-gray-700">Steps</label>
                            <div id="steps-container">
                                <div class="mt-2" id="step-0">
                                    <input type="text" name="steps[0][title]"
                                        class="form-input rounded-md shadow-sm block w-full mb-2" placeholder="Title"
                                        required />
                                    @error('steps.0.title')
                                        <p class="text-red-500 mt-1">{{ $message }}</p>
                                    @enderror

                                    <textarea name="steps[0][description]" class="form-textarea rounded-md shadow-sm block w-full mt-2"
                                        placeholder="Description" required></textarea>
                                    @error('steps.0.description')
                                        <p class="text-red-500 mt-1">{{ $message }}</p>
                                    @enderror

                                    <input type="file" name="steps[0][images][]" multiple
                                        class="form-input rounded-md shadow-sm block w-full mt-2" accept="image/*" />
                                    @error('steps.0.images.*')
                                        <p class="text-red-500 mt-1">{{ $message }}</p>
                                    @enderror

                                    <!-- Preview thumbnail and images -->
                                    <div id="step-images-preview-0" class="flex mt-2">
                                        <!-- Preview thumbnail image -->
                                        <div id="step-thumbnail-preview-0" class="w-20 h-20 mr-2">
                                            <!-- Placeholder for thumbnail preview -->
                                        </div>

                                        <!-- Preview images -->
                                        <div id="step-images-preview-container-0" class="flex">
                                            <!-- Placeholder for image previews -->
                                        </div>
                                    </div>

                                    <!-- Add the "Remove Step" button -->
                                    <button type="button"
                                        class="px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 mt-2"
                                        onclick="removeStep(0)">Remove Step</button>
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="button" id="add-step-btn"
                                    class="px-4 py-2 border border-transparent text-sm font-medium rounded-md text-gray-900 bg-sky-500 hover:bg-sky-700 hover:text-white">
                                    Add Step
                                </button>
                            </div>
                        </div>

                        <!-- Categories -->
                        <div class="mb-4">
                            <label for="categories" class="block font-medium text-gray-700">Categories</label>
                            <select name="categories[]" id="categories" multiple
                                class="form-multiselect rounded-md shadow-sm mt-1 block w-full">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        @if (in_array($category->id, old('categories', []))) selected @endif>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categories')
                                <p class="text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Ingredients -->
                        <div class="mb-4">
                            <label for="ingredients" class="block font-medium text-gray-700">Ingredients</label>
                            <select name="ingredients[]" id="ingredients" multiple
                                class="form-multiselect rounded-md shadow-sm mt-1 block w-full">
                                @foreach ($ingredients as $ingredient)
                                    <option value="{{ $ingredient->id }}"
                                        @if (in_array($ingredient->id, old('ingredients', []))) selected @endif>
                                        {{ $ingredient->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('ingredients')
                                <p class="text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tools -->
                        <div class="mb-4">
                            <label for="tools" class="block font-medium text-gray-700">Tools</label>
                            <select name="tools[]" id="tools" multiple
                                class="form-multiselect rounded-md shadow-sm mt-1 block w-full">
                                @foreach ($tools as $tool)
                                    <option value="{{ $tool->id }}"
                                        @if (in_array($tool->id, old('tools', []))) selected @endif>
                                        {{ $tool->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tools')
                                <p class="text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit"
                                class="px-4 py-2 border border-transparent text-sm font-medium rounded-md text-gray-900 bg-green-500 hover:bg-green-700 hover:text-white">
                                Create Receipt
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function removeStep(stepIndex) {
            // Find the step element to remove
            var stepElement = document.getElementById('step-' + stepIndex);

            // Remove the step element
            if (stepElement) {
                stepElement.remove();
            }
        }

        document.getElementById('add-step-btn').addEventListener('click', function() {
            const container = document.getElementById('steps-container');
            const stepIndex = container.children.length;

            const stepDiv = document.createElement('div');
            stepDiv.classList.add('mt-2');
            stepDiv.id = 'step-' + stepIndex;

            const titleInput = document.createElement('input');
            titleInput.setAttribute('type', 'text');
            titleInput.setAttribute('name', `steps[${stepIndex}][title]`);
            titleInput.classList.add('form-input', 'rounded-md', 'shadow-sm', 'block', 'w-full', 'mb-2');
            titleInput.setAttribute('placeholder', 'Title');
            titleInput.required = true;

            const descriptionTextarea = document.createElement('textarea');
            descriptionTextarea.setAttribute('name', `steps[${stepIndex}][description]`);
            descriptionTextarea.classList.add('form-textarea', 'rounded-md', 'shadow-sm', 'block', 'w-full',
                'mb-2');
            descriptionTextarea.setAttribute('placeholder', 'Description');
            descriptionTextarea.required = true;

            const imagesInput = document.createElement('input');
            imagesInput.setAttribute('type', 'file');
            imagesInput.setAttribute('name', `steps[${stepIndex}][images][]`);
            imagesInput.setAttribute('multiple', 'multiple');
            imagesInput.classList.add('form-input', 'rounded-md', 'shadow-sm', 'block', 'w-full');
            imagesInput.setAttribute('accept', 'image/*');
            imagesInput.addEventListener('change', function(event) {
                // Remove previous image previews
                const previewContainer = document.getElementById(
                    `step-images-preview-container-${stepIndex}`);
                previewContainer.innerHTML = '';

                const files = event.target.files;
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const imagePreview = document.createElement('img');
                        imagePreview.setAttribute('src', e.target.result);
                        imagePreview.setAttribute('alt', file.name);
                        imagePreview.classList.add('w-20', 'h-20', 'mr-2');

                        previewContainer.appendChild(imagePreview);
                    };

                    reader.readAsDataURL(file);
                }
            });

            const removeStepButton = document.createElement('button');
            removeStepButton.setAttribute('type', 'button');
            removeStepButton.classList.add('px-4', 'py-2', 'border', 'border-transparent', 'text-sm', 'font-medium',
                'rounded-md', 'text-white', 'bg-red-600', 'hover:bg-red-700', 'mt-2');
            removeStepButton.textContent = 'Remove Step';
            removeStepButton.addEventListener('click', function() {
                removeStep(stepIndex);
            });

            stepDiv.appendChild(titleInput);
            stepDiv.appendChild(descriptionTextarea);
            stepDiv.appendChild(imagesInput);
            stepDiv.appendChild(removeStepButton);

            container.appendChild(stepDiv);
        });

        // Preview thumbnail image
        document.getElementById('thumbnail').addEventListener('change', function(event) {
            const thumbnailPreview = document.getElementById('thumbnail-preview');
            thumbnailPreview.innerHTML = '';

            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imagePreview = document.createElement('img');
                    imagePreview.setAttribute('src', e.target.result);
                    imagePreview.setAttribute('alt', file.name);
                    imagePreview.classList.add('max-w-xs', 'mr-2');

                    thumbnailPreview.appendChild(imagePreview);
                };

                reader.readAsDataURL(file);
            }
        });
    </script>

</x-app-user-layout>
