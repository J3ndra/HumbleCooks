<x-app-user-layout>
    <div class="ml-48 mr-48 mt-16">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            {{-- Make thumbnail image cover div --}}
            <div class="h-96 bg-cover bg-center" style="background-image: url('{{ Storage::disk('receipts')->url($receipt->thumbnail_image) }}')"></div>
            <div class="m-4">
                <h1>{{ $receipt->title }}</h1>
            </div>
        </div>
    </div>
</x-app-user-layout>
