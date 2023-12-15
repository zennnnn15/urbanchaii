<nav x-data="{ open: false }" class="bg-green-500 border-b border-black">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 text-white">
            <!-- Logo -->
            <style>
                #logo{
                    height: 70px
                }
            </style>
            <div class="shrink-0 flex items-center">
                <a href="{{ route('dashboard') }}">
                    <img id="logo" src="{{ asset('images/logo.png') }}" alt="Admin Image">
                </a>
            </div>

            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-nav-link>
            </div>

            <!-- Manage Dropdown -->
            <div class="relative group mt-4 text-black" x-data="{ open: false }">
                <button @click="open = !open" class="px-4 py-2 text-sm">
                    {{ __('Manage') }}
                </button>

                <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                    <div class="py-1" role="menuitem">
                        <!-- Sub-Item 1 -->
                        <a href="{{route('milktea.categories.index')}}" class="block px-4 py-2 text-sm hover:bg-gray-100">Manage Milk Tea Categories</a>
                        <!-- Sub-Item 2 -->
                        <a href="{{ route('milktea.index') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Manage MilkTea</a>
                        <a href="{{ route('milkteasize.index') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Manage Sizes Available</a>
                        <a href="{{ route('milkteaInSize.index') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Manage Milktea Sizes</a>
                        <!-- Add more sub-items as needed -->
                    </div>
                </div>
            </div>

            <!-- Orders Dropdown -->
            <div class="relative group mt-4 text-black" x-data="{ open: false }">
                <button @click="open = !open" class="px-4 py-2 text-sm">
                    {{ __('Orders') }}
                </button>

                <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                    <div class="py-1" role="menuitem">
                        <!-- Sub-Item 1 -->
                        <a href="{{route('transactions.index')}}" class="block px-4 py-2 text-sm hover:bg-gray-100">All Orders</a>
                        <a href="{{route('transactions.current')}}" class="block px-4 py-2 text-sm hover:bg-gray-100">Current Orders</a>
                        <!-- Sub-Item 2 -->
                        <a href="{{route('sales.report')}}" class="block px-4 py-2 text-sm hover:bg-gray-100">Sales Report</a>
                        <!-- Add more sub-items as needed -->
                    </div>
                </div>
            </div>

            <!-- User Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium hover:text-gray-300 focus:outline-none transition duration-150 ease-in-out">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
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
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-300 hover:bg-gray-100 focus:outline-none focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-black">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
