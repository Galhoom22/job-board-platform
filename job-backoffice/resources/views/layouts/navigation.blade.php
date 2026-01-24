<nav 
    :class="$store.sidebar.open ? 'w-[250px]' : 'w-0'" 
    class="bg-white h-screen border-r border-gray-200 transition-all duration-300 ease-in-out overflow-hidden flex-shrink-0"
>
    <div class="w-[250px]">
        <!-- Logo Section -->
        <div class="flex items-center justify-between px-6 border-b border-gray-200 py-4">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                <x-application-logo class="h-6 w-auto fill-current text-gray-800" />
                <span class="text-lg font-semibold text-gray-800"> {{ __('Hire Hub') }}</span>
            </a>
            {{-- Close Sidebar Button --}}
            <button 
                @click="$store.sidebar.open = false" 
                class="p-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-600 hover:text-gray-800 transition-colors"
                title="Close Sidebar"
            >
                <x-icon name="chevron-left" class="w-5 h-5"/>
            </button>
        </div>

        <!-- Navigation Links -->
        <ul class="flex flex-col px-4 py-6 space-y-4">
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-nav-link>

            <x-nav-link :href="route('companies.index')" :active="request()->routeIs('companies.*')">
                {{ __('Companies') }}
            </x-nav-link>

            <x-nav-link :href="route('job-applications.index')" :active="request()->routeIs('job-applications.*')">
                {{ __('Applications') }}
            </x-nav-link>

            <x-nav-link :href="route('job-categories.index')" :active="request()->routeIs('job-categories.*')">
                {{ __('Categories') }}
            </x-nav-link>

            <x-nav-link :href="route('job-vacancies.index')" :active="request()->routeIs('job-vacancies.*')">
                {{ __('Job Vacancies') }}
            </x-nav-link>

            <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                {{ __('Users') }}
            </x-nav-link>
            <hr />
            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <x-nav-link class="text-red-500" :href="route('logout')"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                    {{ __('Log Out') }}
                </x-nav-link>
            </form>
        </ul>
    </div>
</nav>