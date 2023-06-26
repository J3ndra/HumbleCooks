<!-- header -->
<header class="py-4 shadow-sm bg-white">
    <div class="container flex items-center justify-between">
        <a href="{{ route('home') }}">
            <img src="{{ asset('/css/logo.png') }}" alt="Logo" width="300" height="253">
        </a>
        <div class="mb-4 flex justify-end">
            <form action="{{ route('home') }}" method="GET" class="flex">
                <input type="text" name="search" value="{{ $search ?? '' }}"
                    class="flex-1 px-2 py-1 border border-black-300 focus:outline-none focus:ring-2 focus:ring-orange-600 focus:border-transparent"
                    placeholder="Search ingredient...">
                <button type="submit"
                    class="ml-2 px-4 py-2 bg-orange-500 hover:bg-orange-700 text-white font-medium rounded"
                    style="background-color: orangered">
                    Search
                </button>
            </form>
        </div>


        <div class="flex items-center space-x-4">
            <a href="{{ route('create_receipt_view') }}" class="text-center text-gray-700 hover:text-primary transition relative">
                <div class="text-2xl">
                    <i class="fa fa-plus-square-o"></i>
                </div>
                <div class="text-xs leading-3">Tambah resep</div>
            </a>

            @if (Route::has('login'))
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- If admin, add another dropdown link to go to dashboard -->
                            @if (Auth::user()->role->id == '1')
                                <x-dropdown-link :href="route('dashboard.dashboard')">
                                    {{ __('Dashboard') }}
                                </x-dropdown-link>
                            @endif
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-center text-gray-700 hover:text-primary transition relative">
                        <div class="text-2xl">
                            <i class="fas fa-sign-in"></i>
                        </div>
                        <div class="text-xs leading-3">Log in</div>
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="text-center text-gray-700 hover:text-primary transition relative">
                            <div class="text-2xl">
                                <i class="fas fa-address-book"></i>
                            </div>
                            <div class="text-xs leading-3">Register</div>
                    @endif
                @endauth
            @endif
        </div>
    </div>
</header>
<!-- ./header -->
