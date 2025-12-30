<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <div class="flex items-center">
                            <div
                                class="w-8 h-8 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-full flex items-center justify-center shadow-md shadow-indigo-100 mr-2">
                                <span class="text-white font-black text-sm">K</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-lg font-black tracking-tighter text-indigo-600 uppercase">K</span>
                                <span class="text-lg font-black tracking-tighter text-slate-800 uppercase">-RENT</span>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Home') }}
                    </x-nav-link>

                    @if (Auth::user()->role === 'client')
                        <x-nav-link :href="route('user.rentals')" :active="request()->routeIs('user.rentals')">
                            {{ __('Pesanan Saya') }}
                        </x-nav-link>
                    @endif

                    @if (Auth::user()->role === 'admin')
                        <x-nav-link :href="route('clothes.index')" :active="request()->routeIs('clothes.*')">
                            {{ __('Kelola Baju') }}
                        </x-nav-link>

                        <x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                            {{ __('Kelola Kategori') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-3">

                {{-- ICON KERANJANG DESKTOP: Hanya untuk Client --}}
                @if (Auth::user()->role === 'client')
                    @php
                        $cartCount = \App\Models\Cart::where('user_id', Auth::id())->count();
                        $isCartPage = request()->routeIs('cart.index');
                    @endphp

                    <a href="{{ route('cart.index') }}"
                        class="relative p-2.5 rounded-xl transition-all duration-300 group 
                       {{ $isCartPage ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'text-gray-400 hover:text-indigo-600 hover:bg-indigo-50' }}">

                        <svg class="w-6 h-6 transition-transform group-hover:scale-110" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>

                        @if ($cartCount > 0)
                            <span class="absolute -top-1 -right-1 flex h-5 w-5">
                                @if (!$isCartPage)
                                    <span
                                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                @endif
                                <span
                                    class="relative inline-flex items-center justify-center rounded-full h-5 w-5 bg-rose-500 text-[10px] font-black text-white border-2 {{ $isCartPage ? 'border-indigo-600' : 'border-white' }}">
                                    {{ $cartCount }}
                                </span>
                            </span>
                        @endif
                    </a>
                @endif

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-gray-200 text-sm leading-4 font-medium rounded-xl text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div class="flex items-center gap-3">
                                <span class="font-semibold">{{ Auth::user()->name }}</span>
                                @php
                                    $role = Auth::user()->role;
                                    $roleClasses =
                                        [
                                            'admin' => 'bg-red-50 text-red-700 border-red-100',
                                            'staff' => 'bg-blue-50 text-blue-700 border-blue-100',
                                            'client' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                        ][$role] ?? 'bg-gray-50 text-gray-700 border-gray-100';
                                @endphp
                                <span
                                    class="px-2.5 py-0.5 rounded-lg text-[9px] font-black uppercase tracking-wider border {{ $roleClasses }}">
                                    {{ $role }}
                                </span>
                            </div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden gap-2">
                {{-- ICON KERANJANG MOBILE: Hanya untuk Client --}}
                @if (Auth::user()->role === 'client')
                    <a href="{{ route('cart.index') }}" class="p-2 text-gray-400 relative">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        @php
                            $cartCountMobile = \App\Models\Cart::where('user_id', Auth::id())->count();
                        @endphp
                        @if ($cartCountMobile > 0)
                            <span
                                class="absolute top-0 right-0 h-4 w-4 bg-rose-500 text-white text-[8px] flex items-center justify-center rounded-full font-bold border border-white">
                                {{ $cartCountMobile }}
                            </span>
                        @endif
                    </a>
                @endif

                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden bg-white border-t border-gray-100">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Home') }}
            </x-responsive-nav-link>

            @if (Auth::user()->role === 'client')
                <x-responsive-nav-link :href="route('user.rentals')" :active="request()->routeIs('user.rentals')">
                    {{ __('Pesanan Saya') }}
                </x-responsive-nav-link>
            @endif

            @if (Auth::user()->role === 'admin')
                <x-responsive-nav-link :href="route('clothes.index')" :active="request()->routeIs('clothes.*')">
                    {{ __('Kelola Baju') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4 flex items-center justify-between">
                <div>
                    <div class="font-bold text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
                <span
                    class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase border {{ $roleClasses ?? '' }}">
                    {{ Auth::user()->role }}
                </span>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
