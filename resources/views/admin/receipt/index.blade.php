<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Receipt List') }}
            </h2>

            @if (session('status'))
                <p class="text-base text-green-600 dark:text-green-400">{{ session('status') }}</p>
            @endif

            <a href="{{ route('dashboard.receipt.create') }}"
                class="inline-block bg-green-500 dark:bg-green-800 hover:bg-green-700 dark:hover:bg-green-600 text-gray-900 dark:text-white font-bold py-2 px-4 rounded">
                Create Receipt
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($receipts->isEmpty())
                        <p>No receipt founds</p>
                    @else
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-900 dark:text-white uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-900 dark:text-white uppercase tracking-wider">
                                        Thumbnail
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-900 dark:text-white uppercase tracking-wider">
                                        Description
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-900 dark:text-white uppercase tracking-wider">
                                        Categories
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-900 dark:text-white uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class=" divide-y divide-gray-200">
                                @foreach ($receipts as $receipt)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                            {{ $receipt->title }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                            <img src="{{ Storage::disk('receipts')->url($receipt->thumbnail_image) }}"
                                                alt="Thumbnail" class="max-w-xs">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white description-cell">
                                            {{ $receipt->description }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                            {{ implode(', ',$receipt->categories()->pluck('name')->toArray()) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                            <button onclick="openReceiptModal('{{ $receipt->id }}')"
                                                class="text-blue-600 hover:underline focus:outline-none">
                                                View More
                                            </button>
                                            <br>
                                            <button onclick="window.location.href = '{{ route('dashboard.receipt.edit', $receipt->id) }}'"
                                                class="text-yellow-600 hover:underline focus:outline-none">
                                                Edit
                                            </button>
                                            <br>
                                            <button onclick="showDeleteConfirmation({{ $receipt->id }})"
                                                class="text-red-600 hover:underline focus:outline-none">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Receipt Modal -->
    <div id="receiptModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-white dark:bg-gray-800 max-w-4xl mx-auto">
                <!-- Updated max-w-4xl -->
                <div class="flex justify-between items-center bg-gray-100 dark:bg-gray-700 p-4">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Receipt Details</h2>
                    <button onclick="closeReceiptModal()" class="text-gray-500 dark:text-gray-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div id="receiptContent" class="p-6">
                    <!-- Updated p-6 -->
                    <!-- ... existing code ... -->
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal"
        class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto transform duration-300 ease-out hidden"
        style="background-color: rgba(0, 0, 0, 0.5);">
        <div class="bg-white dark:bg-gray-800 p-4 rounded shadow">
            <p class="text-lg text-gray-800 dark:text-gray-200 mb-4">Are you sure you want to delete this receipt?
            </p>
            <div class="flex justify-end">
                <button class="px-4 py-2 bg-red-500 hover:bg-red-700 text-gray-900 dark:text-white font-medium rounded"
                    onclick="hideDeleteConfirmation()">Cancel</button>
                @isset($receipt)
                    <form id="deleteForm" method="POST"
                        action="{{ route('dashboard.receipt.destroy', $receipt->id) }}" class="ml-4">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 bg-green-500 hover:bg-green-700 text-gray-900 dark:text-white font-medium rounded">Delete</button>
                    </form>
                @endisset
            </div>
        </div>
    </div>

    <script>
        const receipt = @json($receipt ?? []);

        function openReceiptModal(receiptId) {
            const modal = document.getElementById('receiptModal');
            modal.classList.remove('hidden');

            // Send AJAX request to fetch receipt details
            $.ajax({
                url: `{{ route('dashboard.receipt.show', '') }}/${receiptId}`,
                type: 'GET',
                success: function(data) {
                    const receiptContent = document.getElementById('receiptContent');
                    // Update the receipt details in the modal
                    receiptContent.innerHTML = `
            <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">${data.title}</h3>
            <div class="flex items-center space-x-4 mb-4">
                <img src="{{ isset($receipt['thumbnail_image']) ? Storage::disk('receipts')->url($receipt['thumbnail_image']) : '' }}" alt="Thumbnail" class="max-w-xs">
                <span class= text-gray-900"dark:text-white">${data.description}</span>
            </div>
            <div>
                <h4 class="font-semibold mb-2 text-gray-900 dark:text-white">Categories:</h4>
                <ul class="mb-4 text-gray-900 dark:text-white">
                    ${data.categories.map(category => `<li>- ${category.name}</li>`).join('')}
                </ul>
                
                
            </div>
            <div>
                <h4 class="font-semibold mb-2 text-gray-900 dark:text-white">Ingredients:</h4>
                <ul class="mb-4 text-gray-900 dark:text-white">
                    ${data.ingredients.map(ingredient => `<li>- ${ingredient.name}</li>`).join('')}
                </ul>    
            </div>
            <div>
                <h4 class="font-semibold mb-2 text-gray-900 dark:text-white">Tools:</h4>
                <ul class="mb-4 text-gray-900 dark:text-white">
                    ${data.tools.map(tool => `<li>- ${tool.name}</li>`).join('')}
                </ul>
                </div>
            <div>
                <h4 class="font-semibold mb-2 text-gray-900 dark:text-white">Steps:</h4>
                <ol class= text-gray-900"dark:text-white">
                    ${data.steps.map(step => `
                                            <li>
                                                <h3 class="font-bold">Title : ${step.title}</h3>
                                                <p>Description : ${step.description}</p>
                                                ${step.step_images.map(stepImage => `
                                <img src="{{ Storage::disk('steps')->url('${stepImage.image}') }}" alt="Step Image" class="max-w-xs">
                            `).join('')}
                                            </li>
                                        `).join('')}
                </ol>


            </div>
        `;
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }

        function closeReceiptModal() {
            const modal = document.getElementById('receiptModal');
            modal.classList.add('hidden');
        }

        function showDeleteConfirmation(receiptId) {
            const deleteModal = document.getElementById('deleteModal');
            deleteModal.classList.remove('hidden');
            deleteModal.querySelector('#deleteForm').action = '/dashboard/receipt/destroy/' + receiptId;
        }

        function hideDeleteConfirmation() {
            const deleteModal = document.getElementById('deleteModal');
            deleteModal.classList.add('hidden');
            deleteModal.querySelector('#deleteForm').action = '';
        }
    </script>
</x-app-layout>
