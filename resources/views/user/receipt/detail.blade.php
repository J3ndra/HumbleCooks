<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Humble's Cook's</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.6/flowbite.min.css" rel="stylesheet" />

    <link rel="shortcut icon" href="{{ asset('/rumah/images/favicon/hc.png')}}" type="image/x-icon">


    <link rel="stylesheet" href="{{ asset('/rumah/css/main.css')}}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
                        class="flex-1 px-2 py-1 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:outline-none dark:text-white"
                        placeholder="Search ingredient...">
                    <button type="submit"
                        class="ml-2 px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-medium rounded">
                        Search
                    </button>
                </form>
            </div>
            {{-- <div class="w-full max-w-xl relative flex">
                <span class="absolute left-4 top-3 text-lg text-gray-400">
                    <i class="fa fa-search" ></i>
                </span><form action="{{ route('search')}}" method="GET">
                    @csrf
                    @method('GET')
                <input type="text" name="search" id="search" class="w-full border border-primary border-r-0 pl-12 py-3 pr-3 rounded-l-md focus:outline-none hidden md:flex"
                    placeholder="search">
                    <button type="submit" class="bg-primary border border-primary text-white px-8 rounded-r-md hover:bg-transparent hover:text-primary transition hidden md:flex"
                            style="display: flex; justify-content: center; font-size: 30px;" name="search" id="search">cari
                    </button>
                </form>
            </div> --}}

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
            Detail   Resep
            </h1>
            <p class="text-white"">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aperiam <br>
                accusantium perspiciatis, sapiente
                magni eos dolorum ex quos dolores odio</p>
            
        </div>
    </div>
    <!-- ./banner -->

    

    <!-- categories -->
    {{-- <div class="container py-16">
        
    <a  class="block max-w-sm p-6 bg-white border border-gray-300 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
        <h1 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white" style="margin-bottom: 30px;">
            Langkah Dan Bahan
        </h1>
        
    </a>

    <a  style="width: fit-content; height:fit-content;" class="block max-w-sm p-6 bg-white border border-gray-300 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
        <div class="container py-14">
            <img src="https://tecdn.b-cdn.net/img/new/standard/city/041.jpg"
            class="max-w-sm rounded border bg-white p-1 dark:border-neutral-700 dark:bg-neutral-800"
            alt="..." />
        </div>
        
    </a>

    <a  class="block max-w-sm p-6 bg-white border border-gray-300 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
        <div class="container py-14">
            <img src="https://tecdn.b-cdn.net/img/new/standard/city/041.jpg" 
            class="max-w-sm rounded border bg-white p-1 dark:border-neutral-700 dark:bg-neutral-800"
            alt="..." />
        </div>   
        <p class="mb-4 mt-6 text-xl font-light leading-relaxed">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nobis, libero
                iste quod quibusdam maxime recusandae odit eveniet, aspernatur culpa
                provident error molestiae vitae corporis in vero est! Beatae, ipsum
                voluptatibus.
            </p>
       
        
    </a> --}}
    
        {{-- <img
        style="margin-top: 40px;"
        src="https://tecdn.b-cdn.net/img/new/slides/041.jpg"
        class="h-auto max-w-full"
        alt="..." /> --}}
    
        

        {{-- <p class="mb-4 mt-6 text-xl font-light leading-relaxed">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nobis, libero
            iste quod quibusdam maxime recusandae odit eveniet, aspernatur culpa
            provident error molestiae vitae corporis in vero est! Beatae, ipsum
            voluptatibus.
          </p> --}}
    
       
    {{-- </div> --}}
    <!-- ./categories -->
    <div class="flex items-center justify-center h-screen" style="text-align:center;">
        <div class="max-w-lg rounded shadow-lg">
            <img class="w-full" src="https://tecdn.b-cdn.net/img/new/standard/city/041.jpg" alt="Sunset in the mountains">
            
            
          </div>
        <div class="px-6 py-4">
              <div class="font-bold text-justify text-xl mb-2">The Coldest Sunset</div>
              <p class="text-gray-700 text-justify text-base">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus quia, nulla! Maiores et perferendis eaque, exercitationem praesentium nihil.
              </p>
            </div></div>

    

    

    <!-- footer -->


    <!-- copyright -->
    <div class="bg-gray-800 py-4">
        <div class="container flex items-center justify-between">
            <p class="text-white">&copy; Humble's Cook's Corp</p>

        </div>
    </div>
    <!-- ./copyright -->
</body>

</html>