<x-app-user-layout>
    <div class="ml-48 mr-48 mt-16 mb-16">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            {{-- Make thumbnail image cover div --}}
            <div class="h-96 bg-cover bg-center"
                style="background-image: url('{{ Storage::disk('receipts')->url($receipt->thumbnail_image) }}')"></div>
            <div class="m-8">
                <div class="mb-2">
                    @foreach ($receipt->categories as $category)
                        <div class="border border-gray-200 rounded-lg pr-4 pl-4 pt-2 pb-2 inline-block">
                            <p>{{ $category->name }}</p>
                        </div>
                    @endforeach
                </div>

                <p class="text-3xl font-bold mb-2">{{ $receipt->title }}</p>
                <p class="text-xs font-light mb-4">Created by {{ $receipt->user->name }}</p>
                <p class="text-base font-light mb-2">{{ $receipt->description }}</p>
                <p class="text-base font-light mb-2">Calories : {{ $receipt->cal_total }}</p>
                <p class="text-base font-light mb-4">Estimated Cost: Rp
                    {{ number_format($receipt->est_price, 2, ',', '.') }}</p>
                <p class="text-base font-bold mb-2">Bahan-bahan</p>
                <div class="mb-2">
                    @foreach ($receipt->ingredients as $ingredient)
                        <div class="border border-gray-200 rounded-lg pr-4 pl-4 pt-2 pb-2 inline-block">
                            <p>{{ $ingredient->name }}</p>
                        </div>
                    @endforeach
                </div>
                <p class="text-base font-bold mb-2">Alat Penunjang</p>
                <div class="mb-4">
                    @foreach ($receipt->tools as $tool)
                        <div class="border border-gray-200 rounded-lg pr-4 pl-4 pt-2 pb-2 inline-block">
                            <p>{{ $tool->name }}</p>
                        </div>
                    @endforeach
                </div>
                <p class="text-base font-bold mb-2">Step by step</p>
                <div class="mb-2">
                    @foreach ($receipt->steps as $index => $step)
                        <p class="text-base font-regular mb-2">{{ $index + 1 }}. {{ $step->title }}</p>
                        <p class="text-sm font-thin mb-2">{{ $step->description }}</p>
                        <div class="flex mb-2">
                            @foreach ($step->stepImages as $stepImage)
                                <img class="mr-2 max-w-xs" src="{{ Storage::disk('steps')->url($stepImage->image) }}" alt="step-image">
                            @endforeach
                        </div>
                    @endforeach
                </div>
                

            </div>
        </div>
    </div>
</x-app-user-layout>
