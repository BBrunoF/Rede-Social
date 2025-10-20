<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-jet-application-mark class="block" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-jet-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
                        {{ __('Home') }}
                    </x-jet-nav-link>
                    
                    <x-jet-nav-link href="{{ route('feeds') }}" :active="request()->routeIs('feeds')">
                        {{ __('Feeds') }}
                    </x-jet-nav-link>
                    
                    <x-jet-nav-link href="{{ route('posts.create') }}" :active="request()->routeIs('posts.create')">
                        {{ __('Create Post') }}
                    </x-jet-nav-link>
                    
                    <x-jet-nav-link href="{{ route('posts.index') }}" :active="request()->routeIs('posts.index')">
                        {{ __('My Posts') }}
                    </x-jet-nav-link>
                    
                    @can('viewAny', auth()->user())
                    <x-jet-nav-link href="{{ route('users.index') }}" :active="request()->routeIs('users.create')">
		                {{ __('Manage Users') }}
		            </x-jet-nav-link>
                    <x-jet-nav-link href="{{ route('reports') }}">
                        {{ __('Manage Reports')  }} 
                    </x-jet-nav-link>
					@endcan
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <!-- Teams Dropdown -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="ml-3 relative">
                        <x-jet-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                                        {{ Auth::user()->currentTeam->name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
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
                                    <x-jet-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                        {{ __('Team Settings') }}
                                    </x-jet-dropdown-link>

                                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                        <x-jet-dropdown-link href="{{ route('teams.create') }}">
                                            {{ __('Create New Team') }}
                                        </x-jet-dropdown-link>
                                    @endcan

                                    <div class="border-t border-gray-100"></div>

                                    <!-- Team Switcher -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Switch Teams') }}
                                    </div>

                                    @foreach (Auth::user()->allTeams() as $team)
                                        <x-jet-switchable-team :team="$team" />
                                    @endforeach
                                </div>
                            </x-slot>
                        </x-jet-dropdown>
                    </div>
                @endif

                @livewire('search.search-users')

                <!-- Settings Dropdown -->
                <div class="ml-3 relative">
                    <x-jet-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <div class="flex-shrink-0 mr-3">
                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                      </div>
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                        {{ Auth::user()->name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>

                            <x-jet-dropdown-link href="{{ route('profile', ['username' => Auth::user()->username]) }}">
                                {{ __('Profile') }}
                            </x-jet-dropdown-link>
                            
                            <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profile Settings') }}
                            </x-jet-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-jet-dropdown-link>
                            @endif

                            <div class="border-t border-gray-100"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-jet-dropdown-link href="{{ route('logout') }}"
                                         onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-jet-dropdown-link>
                            </form>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
                <div class="flex-shrink-0 mr-3" style="margin-left: 10px">
                    <x-jet-nav-link href="{{ route('messages.index') }}" :active="request()->routeIs('messages.index')">
                    <img class="h-10 w-10 rounded-full object-cover" src="data:image/png;base64,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" />
                    </x-jet-nav-link>
                </div>
                
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
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
        @livewire('search.search-users')
        <div class="pt-2 pb-3 space-y-1">
            <x-jet-responsive-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
                {{ __('Home') }}
            </x-jet-responsive-nav-link>
            
            <x-jet-responsive-nav-link href="{{ route('feeds') }}" :active="request()->routeIs('feeds')">
                {{ __('Feeds') }}
            </x-jet-responsive-nav-link>
            
            <x-jet-responsive-nav-link href="{{ route('posts.create') }}" :active="request()->routeIs('posts.create')">
                {{ __('Create post') }}
            </x-jet-responsive-nav-link>
            
            <x-jet-responsive-nav-link href="{{ route('posts.index') }}">
                {{ __('My Posts') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{ route('messages.index') }}">
                {{ __('Messages') }}
            </x-jet-responsive-nav-link>
            @can('viewAny', auth()->user())
            <x-jet-responsive-nav-link href="{{ route('users.index') }}" :active="request()->routeIs('users.create')">
                {{ __('Manage Users')  }} 
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{ route('reports') }}">
                {{ __('Manage Reports')  }} 
            </x-jet-responsive-nav-link>
            @endcan
        </div>
        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())

                   <a href="{{ route('profile', ['username' => Auth::user()->username]) }}"> 
                        <div class="flex-shrink-0 mr-3">
                            <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                        </div>
                    </a>
                @endif
                <a href="{{ route('profile', ['username' => Auth::user()->username]) }}"> 
                    <div>
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </a>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-jet-responsive-nav-link href="{{ route('profile', ['username' => Auth::user()->username]) }}">
                    {{ __('Profile') }}
                </x-jet-responsive-nav-link>

                <x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profile Settings') }}
                </x-jet-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-jet-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-jet-responsive-nav-link href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                    this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-jet-responsive-nav-link>
                </form>

                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="border-t border-gray-200"></div>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Manage Team') }}
                    </div>

                    <!-- Team Settings -->
                    <x-jet-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                        {{ __('Team Settings') }}
                    </x-jet-responsive-nav-link>

                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <x-jet-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                            {{ __('Create New Team') }}
                        </x-jet-responsive-nav-link>
                    @endcan

                    <div class="border-t border-gray-200"></div>

                    <!-- Team Switcher -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Switch Teams') }}
                    </div>

                    @foreach (Auth::user()->allTeams() as $team)
                        <x-jet-switchable-team :team="$team" component="jet-responsive-nav-link" />
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</nav>
