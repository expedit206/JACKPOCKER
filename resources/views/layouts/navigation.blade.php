<nav x-data="{ open: false }" class="bg-slate-700 border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0  items-center  ">
                    <a href="{{ route('packs.index') }}"><i class="fas fa-dove text-amber-500 text-4xl"></i>

                    </a>
                </div>

                <!-- Navigation Links -->
                <div class=" space-x-2 sm:-my-px sm:ms-2 sm:flex gap-2 ">
                    <x-nav-link :href="route('packs.index')" :active="request()->routeIs('dashboard')" class="hidden sm:flex">
                        {{ __(config('app_name.name')) }}
                    </x-nav-link>
                    @auth

                    @if (auth()->user()->isAdmin() )

                    <a href="{{ route('admin.comptes.retraits') }}" class="bg-blue-500 rounded-lg p-2 text-white">retraits</a>

<a href="{{ route('admin.all_comptes') }}" class="bg-blue-500 rounded-lg p-2 text-white">comptes</a>
<a href="{{ route('comptes.create') }}" class="bg-blue-500 rounded-lg p-2 text-white">Add compte</a>
<a href="{{ route('admin.users') }}" class="bg-blue-500 rounded-lg p-2 text-white">Users</a>

@endif
@endauth

<a href="{{ route('packs.index') }}" class="bg-blue-500 rounded-lg p-2 text-white">Packs disponible</a>



                </div>
            </div>

            <!-- Settings Dropdown -->
     @auth
     <p class="flex items-center justify-center">

        <a href="https://t.me/potjacker" class=" text-green-400 p-2 rounded-lg font-bold flex items-center justify-center gap-2 border-2 border-green-500">Telegram <i class="fab fa-telegram text-blue-500 text-2xl"></i>
        </a>
        </p>
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-100  hover:text-gray-200 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
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
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-100">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

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
    @endauth

    @guest
    <div class="flex items-center text-white border-3 rounded-lg  ">

    <a href="{{ route('login') }}" class="bg-slate-800 border-3 rounded-lg  p-2">Se connecter</a>
    </div>
    @endguest
    @if(session('success'))
    <div class="mb-4 p-4 bg-green-300 text-green-700 rounded-md">
        {{ session('success') }}
    </div>
@elseif(session('error'))
    <div class="mb-4 p-4 bg-red-400 text-white rounded-md">
        {{ session('error') }}
    </div>
@endif

</nav>
