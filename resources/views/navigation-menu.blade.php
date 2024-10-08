<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-mark class="block h-12 w-auto"/>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        {{ __('all.dashboard') }}
                    </x-nav-link>
                    <x-nav-link href="{{ route('cashier') }}" :active="request()->routeIs('cashier')">
                        {{ __('all.cashiers') }}
                    </x-nav-link>
                    @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('sales'))
                        <x-nav-link href="{{ route('orders.list') }}" :active="request()->routeIs('orders.list')">
                            {{ __('Orders') }}
                        </x-nav-link>
                        <x-nav-link href="{{ route('verification.list') }}" :active="request()->routeIs('verification.list')">
                            {{ __('Verification') }}
                        </x-nav-link>
                        <x-nav-link href="{{ route('withdrawal.list') }}" :active="request()->routeIs('withdrawal.list')">
                            {{ __('Withdrawal') }}
                        </x-nav-link>
                        <x-nav-link href="{{ route('users.list') }}" :active="request()->routeIs('users.list')">
                            {{ __('Users') }}
                        </x-nav-link>
                        <x-nav-link href="{{ route('reset-tax-code.list') }}" :active="request()->routeIs('reset-tax-code.list')">
                            {{ __('Reset Tax') }}
                        </x-nav-link>
                    @endif
                    @if(Auth::user()->hasRole('admin'))
                        <x-nav-link href="{{ route('logs.list') }}" :active="request()->routeIs('logs.list')">
                            {{ __('Logs') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Teams Dropdown -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="ms-3 relative">
                        <x-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150">
                                        {{ Auth::user()->currentTeam->name }}

                                        <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                             viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"/>
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>

                            <x-slot name="content">
                                <div class="w-60">
                                    <!-- Team Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Manage Team') }}
                                    </div>

                                    <!-- Team Settings -->
                                    <x-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                        {{ __('Team Settings') }}
                                    </x-dropdown-link>

                                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                        <x-dropdown-link href="{{ route('teams.create') }}">
                                            {{ __('Create New Team') }}
                                        </x-dropdown-link>
                                    @endcan

                                    <!-- Team Switcher -->
                                    @if (Auth::user()->allTeams()->count() > 1)
                                        <div class="border-t border-gray-200 dark:border-gray-600"></div>

                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ __('Switch Teams') }}
                                        </div>

                                        @foreach (Auth::user()->allTeams() as $team)
                                            <x-switchable-team :team="$team"/>
                                        @endforeach
                                    @endif
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endif

                @if(!isset(Auth::user()->verifications) || Auth::user()->verifications->status == 0)
                    <a href="{{ route('profile.show') }}"
                        class="mr-3 bg-yellow-400 text-white px-3 py-1 rounded border border-yellow-500 transition-colors
        hover:bg-yellow-500 hover:border-yellow-600
        active:bg-yellow-600 active:border-yellow-700
        focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:ring-offset-2
        dark:bg-yellow-300 dark:text-gray-800 dark:border-yellow-400
        dark:hover:bg-yellow-400 dark:hover:border-yellow-500
        dark:active:bg-yellow-500 dark:active:border-yellow-600
        dark:focus:ring-yellow-400 dark:focus:ring-offset-gray-800">
                        {{ __('Verify now') }}
                    </a>
                @endif

                <livewire:notifications>

                <livewire:language>


                    <!-- Settings Dropdown -->
                    <div class="ms-3 relative">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <button
                                        class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                        <img class="h-8 w-8 rounded-full object-cover"
                                             src="{{ Auth::user()->profile_photo_url }}"
                                             alt="{{ Auth::user()->name }}"/>
                                    </button>
                                @else
                                    <span class="inline-flex rounded-md">
                                    <button type="button"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150">
                                        {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}

                                        <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                             viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                        </svg>
                                    </button>
                                </span>
                                @endif
                            </x-slot>

                            <x-slot name="content">
                                <!-- Account Management -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('all.manage_account') }}
                                </div>

                                <x-dropdown-link href="{{ route('profile.show') }}">
                                    {{ __('all.profile') }}
                                </x-dropdown-link>

                                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                    <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                        {{ __('API Tokens') }}
                                    </x-dropdown-link>
                                @endif

                                <div class="border-t border-gray-200 dark:border-gray-600"></div>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf

                                    <x-dropdown-link href="{{ route('logout') }}"
                                                     @click.prevent="$root.submit();">
                                        {{ __('all.log_out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('all.dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('cashier') }}" :active="request()->routeIs('cashier')">
                {{ __('all.cashiers') }}
            </x-responsive-nav-link>
            @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('sales'))
                <x-responsive-nav-link href="{{ route('orders.list') }}" :active="request()->routeIs('orders.list')">
                    {{ __('Orders') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('verification.list') }}" :active="request()->routeIs('verification.list')">
                    {{ __('Verification') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('withdrawal.list') }}" :active="request()->routeIs('withdrawal.list')">
                    {{ __('Withdrawal') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('users.list') }}" :active="request()->routeIs('users.list')">
                    {{ __('Users') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('reset-tax-code.list') }}" :active="request()->routeIs('reset-tax-code.list')">
                    {{ __('Reset Tax') }}
                </x-responsive-nav-link>
           @endif
            @if(Auth::user()->hasRole('admin'))
                <x-responsive-nav-link href="{{ route('logs.list') }}" :active="request()->routeIs('logs.list')">
                    {{ __('Logs') }}
                </x-responsive-nav-link>
            @endif
            <livewire:notifications/>

        </div>



        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 me-3">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                             alt="{{ Auth::user()->name }}"/>
                    </div>
                @endif

                <div>
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('all.profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-responsive-nav-link href="{{ route('logout') }}"
                                           @click.prevent="$root.submit();">
                        {{ __('all.log_out') }}
                    </x-responsive-nav-link>
                </form>

            </div>
        </div>
    </div>
</nav>
