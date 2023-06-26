<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Humble's Cook's</title>

    <link rel="shortcut icon" href="{{ asset('/rumah/images/favicon/hc.png')}}" type="image/x-icon">


    <link rel="stylesheet" href="{{ asset('/rumah/css/main.css')}}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.6/flowbite.min.css" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap"
        rel="stylesheet">
        <link rel="stylesheet" href=
        "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.css"> </link>
    <link rel="stylesheet" href="{{ asset('/rumah/css/font-awesome.min.css')}}">
</head>

<body>
    <!-- header -->
    <header class="py-4 shadow-sm bg-white">
        <div class="container flex items-center justify-between">
            <a href="{{ route('home') }}">
                <img src="{{ asset('/css/logo.png')}}" alt="Logo" width="300" height="253">
            </a>
            <div class="mb-4 flex justify-end">
                <form action="{{ route('search') }}" method="GET" class="flex">
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                        class="flex-1 px-2 py-1 border border-black-300 dark:border-gray-700 dark:bg-gray-900 focus:outline-none dark:text-white"
                        placeholder="Search ingredient...">
                    <button type="submit"
                        class="ml-2 px-4 py-2 bg-orange-500 hover:bg-orange-700 text-white font-medium rounded"
                        style="background-color: orangered">
                        Search
                    </button>
                </form>
            </div>
        

            <div class="flex items-center space-x-4">
                <a href="#" class="text-center text-gray-700 hover:text-primary transition relative">
                    <div class="text-2xl">
                        <i class="fa fa-plus-square-o"></i>
                    </div>
                    <div class="text-xs leading-3">Tambah resep</div>
                </a>
                <a href="{{ route('profile.edit') }}" class="text-center text-gray-700 hover:text-primary transition relative">
                    <div class="text-2xl">
                        <i class="fa-regular fa-user"></i>
                    </div>
                    <div class="text-xs leading-3">Akun</div>
                </a>
            </div>
        </div>
    </header>
    <!-- ./header -->

    <!-- navbar -->
    <nav class="bg-gray-800">
        <div class="container flex">
            <div class="flex items-center justify-between flex-grow md:pl-12 py-5">
                <div class="flex items-center space-x-6 capitalize">
                    <a href="pages/shop.html" class="text-gray-200 hover:text-white transition">Shop</a>
                    <a href="#" class="text-gray-200 hover:text-white transition">About us</a>
                    <a href="#" class="text-gray-200 hover:text-white transition">Contact us</a>
                </div>
                <div style="text-align: right;" class="flex items-center space-x-4">
                @if (Route::has('login'))
                
                    @auth
                         <a href="{{ __('logout') }}" method="POST" class="text-gray-200 hover:text-white transition">Logout</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-200 hover:text-white transition">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-gray-200 hover:text-white transition mr-12">Register</a>
                        @endif
                    @endauth
                
            @endif
                </div>
            </div>
        </div>
    </nav>
    <!-- ./navbar -->

    <!-- banner -->
    <div class="bg-cover bg-no-repeat bg-center py-36" style="background-image: url('{{asset('/rumah/images/cook1.jpg')}}');">
        <div class="container">
            <h1 class="text-6xl text-white font-medium mb-4 capitalize">
            The place to find the best <br> dining menu 
            </h1>
            <p class="text-white"">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aperiam <br>
                accusantium perspiciatis, sapiente
                magni eos dolorum ex quos dolores odio</p>
            
        </div>
    </div>
    <!-- ./banner -->

    <!-- features -->
    <div class="container py-16">
        <div class="w-10/12 grid grid-cols-1 md:grid-cols-3 gap-6 mx-auto justify-center">
            <div class="border border-primary rounded-sm px-3 py-6 flex justify-center items-center gap-5">
                <img src="{{ asset('/rumah/images/icons/delivery-van.svg')}}" alt="Delivery" class="w-12 h-12 object-contain">
                <div>
                    <h4 class="font-medium capitalize text-lg">Free Shipping</h4>
                    <p class="text-gray-500 text-sm">Order over $200</p>
                </div>
            </div>
            <div class="border border-primary rounded-sm px-3 py-6 flex justify-center items-center gap-5">
                <img src="{{ asset('/rumah/images/icons/money-back.svg')}}" alt="Delivery" class="w-12 h-12 object-contain">
                <div>
                    <h4 class="font-medium capitalize text-lg">Money Rturns</h4>
                    <p class="text-gray-500 text-sm">30 days money returs</p>
                </div>
            </div>
            <div class="border border-primary rounded-sm px-3 py-6 flex justify-center items-center gap-5">
                <img src="{{ asset('/rumah/images/icons/service-hours.svg')}}" alt="Delivery" class="w-12 h-12 object-contain">
                <div>
                    <h4 class="font-medium capitalize text-lg">24/7 Support</h4>
                    <p class="text-gray-500 text-sm">Customer support</p>
                </div>
            </div>
        </div>
    </div>
    <!-- ./features -->

    <!-- SEARCH -->
    <div class="container py-16">
        <h2 class="text-2xl font-medium text-gray-800 uppercase mb-6">Hasil Pencarian :</h2>
        @foreach ($ingr as $ingredient)
        <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <a href="#">
                <img class="rounded-t-lg "  src="{{ Storage::disk('ingredients')->url($ingredient->image) }}" alt="" />
                </a>
                <div class="p-5">
                 <a href="#">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        {{ $ingredient->name }}
                    </h5>
                 </a>
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ $ingredient->description }}</p>
                  <a href="#" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Lihat Resep
                <svg aria-hidden="true" class="w-4 h-4 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </a>
                 </div>
        </div>
        
        @endforeach
    </div>
    
    <!-- ./SEARCH -->

   
    

    

    <!-- copyright -->
    <div class="bg-gray-800 py-4">
        <div class="container flex items-center justify-between">
            <p class="text-white">&copy; Humble's Cook's Corp</p>
            <div>
            </div>
        </div>
    </div>
    <!-- ./copyright -->
</body>

</html>