<x-app-user-layout>
    @if (session('status'))
        <x-slot name="header">
            <div>
                <p class="text-base text-green-600 font-bold">{{ session('status') }}</p>
            </div>
        </x-slot>
    @endif
    <!-- banner -->
    <div class="bg-cover bg-no-repeat bg-center py-36"
        style="background-image: url('{{ asset('/rumah/images/cook1.jpg') }}');">
        <div class="container">
            <h1 class="text-6xl text-white font-medium mb-4 ml-72 capitalize">
                The place to find the best <br> dining menu
            </h1>
            <p class="text-white ml-72"">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aperiam <br>
                accusantium perspiciatis, sapiente
                magni eos dolorum ex quos dolores odio</p>

        </div>
    </div>
    <!-- ./banner -->

    <!-- features -->
    <div class="flex justify-center items-center">
        <div class="container py-16">
            <div class="w-10/12 grid grid-cols-1 md:grid-cols-3 gap-6 mx-auto justify-center">
                <div class="border border-primary rounded-sm px-3 py-6 flex justify-center items-center gap-5">
                    <img src="{{ asset('/rumah/images/icons/delivery-van.svg') }}" alt="Delivery"
                        class="w-12 h-12 object-contain">
                    <div>
                        <h4 class="font-medium capitalize text-lg">Free Shipping</h4>
                        <p class="text-gray-500 text-sm">Order over $200</p>
                    </div>
                </div>
                <div class="border border-primary rounded-sm px-3 py-6 flex justify-center items-center gap-5">
                    <img src="{{ asset('/rumah/images/icons/money-back.svg') }}" alt="Delivery"
                        class="w-12 h-12 object-contain">
                    <div>
                        <h4 class="font-medium capitalize text-lg">Money Returns</h4>
                        <p class="text-gray-500 text-sm">30 days money returns</p>
                    </div>
                </div>
                <div class="border border-primary rounded-sm px-3 py-6 flex justify-center items-center gap-5">
                    <img src="{{ asset('/rumah/images/icons/service-hours.svg') }}" alt="Delivery"
                        class="w-12 h-12 object-contain">
                    <div>
                        <h4 class="font-medium capitalize text-lg">24/7 Support</h4>
                        <p class="text-gray-500 text-sm">Customer support</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ./features -->

    {{-- <!-- categories -->
    <div class="container py-16">
        <h2 class="text-2xl font-medium text-gray-800 uppercase mb-6">shop by category</h2>
        <div class="grid grid-cols-3 gap-3">
            <div class="relative rounded-sm overflow-hidden group">
                <img src="{{ asset('/rumah/images/category/category-1.jpg')}}" alt="category 1" class="w-full">
                <a href="#"
                    class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center text-xl text-white font-roboto font-medium group-hover:bg-opacity-60 transition">Bedroom</a>
            </div>
            <div class="relative rounded-sm overflow-hidden group">
                <img src="{{ asset('/rumah/images/category/category-2.jpg')}}" alt="category 1" class="w-full">
                <a href="#"
                    class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center text-xl text-white font-roboto font-medium group-hover:bg-opacity-60 transition">Mattrass</a>
            </div>
            <div class="relative rounded-sm overflow-hidden group">
                <img src="{{ asset('/rumah/images/category/category-3.jpg')}}" alt="category 1" class="w-full">
                <a href="#"
                    class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center text-xl text-white font-roboto font-medium group-hover:bg-opacity-60 transition">Outdoor
                </a>
            </div>
            <div class="relative rounded-sm overflow-hidden group">
                <img src="{{ asset('/rumah/images/category/category-4.jpg')}}" alt="category 1" class="w-full">
                <a href="#"
                    class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center text-xl text-white font-roboto font-medium group-hover:bg-opacity-60 transition">Sofa</a>
            </div>
            <div class="relative rounded-sm overflow-hidden group">
                <img src="{{ asset('/rumah/images/category/category-5.jpg')}}" alt="category 1" class="w-full">
                <a href="#"
                    class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center text-xl text-white font-roboto font-medium group-hover:bg-opacity-60 transition">Living
                    Room</a>
            </div>
            <div class="relative rounded-sm overflow-hidden group">
                <img src="{{ asset('/rumah/images/category/category-6.jpg')}}" alt="category 1" class="w-full">
                <a href="#"
                    class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center text-xl text-white font-roboto font-medium group-hover:bg-opacity-60 transition">Kitchen</a>
            </div>
        </div>
    </div>
    <!-- ./categories --> --}}

    <!-- product -->
    @if (isset($search))
        <div class="container ml-72 mr-72 mb-4">
            <h2 class="text-2xl font-medium text-gray-800 uppercase">Hasil Pencarian :</h2>
        </div>
    @else
        <div class="container ml-72 mr-72 mb-4">
            <h2 class="text-2xl font-medium text-gray-800 uppercase">recomended for you</h2>
        </div>
    @endif
    <!-- ./product -->
    <div class="container ml-72 mr-72 mb-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
            @forelse ($receipts as $receipt)
                <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow">
                    <a href="#">
                        <img class="rounded-t-lg bg-cover"
                            src="{{ Storage::disk('receipts')->url($receipt->thumbnail_image) }}" alt="" />
                    </a>
                    <div class="p-5">
                        <a href="#">
                            <h5 class="mb-1 text-2xl font-bold tracking-tight text-gray-900">
                                {{ $receipt->title }}</h5>
                        </a>
                        <p class="mb-1 font-thin text-gray-700 text-xs">Created by {{ $receipt->user->name }}</p>
                        <p class="mb-3 font-normal text-gray-700">{{ $receipt->description }}</p>
                        <a href="{{ route('detail', $receipt->id) }}"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                            Read more
                            <svg aria-hidden="true" class="w-4 h-4 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            @empty
                <h2>Tidak ada data resep!</h2>
            @endforelse
        </div>
    </div>
</x-app-user-layout>
