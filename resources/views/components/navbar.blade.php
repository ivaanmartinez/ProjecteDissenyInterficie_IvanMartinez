<nav class="bg-indigo-600 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-white font-bold text-xl">
                        VideosApp
                    </a>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:items-center">
                    <div class="flex space-x-4">
                        <a href="{{ route('home') }}" class="text-white hover:bg-indigo-700 px-3 py-2 rounded-md text-sm font-medium">Inici</a>
                        <a href="{{ route('videos.index') }}" class="text-white hover:bg-indigo-700 px-3 py-2 rounded-md text-sm font-medium">Vídeos</a>
                        <a href="{{ route('series.index') }}" class="text-white hover:bg-indigo-700 px-3 py-2 rounded-md text-sm font-medium">Sèries</a>
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-white hover:bg-indigo-700 px-3 py-2 rounded-md text-sm font-medium">Panell</a>
                        @endauth
                    </div>
                </div>
            </div>
            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                @auth
                    <div class="ml-3 relative">
                        <div>
                            <button type="button" class="bg-indigo-700 flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-indigo-800 focus:ring-white" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                <span class="sr-only">Obrir menú d'usuari</span>
                                <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&color=7F9CF5&background=EBF4FF" alt="{{ auth()->user()->name }}">
                            </button>
                        </div>
                        <div class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1" id="user-menu">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">El meu perfil</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Tancar sessió</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-white bg-indigo-700 hover:bg-indigo-800 px-4 py-2 rounded-md text-sm font-medium">Iniciar sessió</a>
                    <a href="{{ route('register') }}" class="ml-2 text-indigo-200 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Registrar-se</a>
                @endauth
            </div>
            <div class="-mr-2 flex items-center sm:hidden">
                <!-- Mobile menu button -->
                <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-indigo-200 hover:text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false" id="mobile-menu-button">
                    <span class="sr-only">Obrir menú principal</span>
                    <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div class="hidden sm:hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="{{ route('home') }}" class="text-white hover:bg-indigo-700 block px-3 py-2 rounded-md text-base font-medium">Inici</a>
            <a href="{{ route('videos.index') }}" class="text-white hover:bg-indigo-700 block px-3 py-2 rounded-md text-base font-medium">Vídeos</a>
            <a href="{{ route('series.index') }}" class="text-white hover:bg-indigo-700 block px-3 py-2 rounded-md text-base font-medium">Sèries</a>
            @auth
                <a href="{{ route('dashboard') }}" class="text-white hover:bg-indigo-700 block px-3 py-2 rounded-md text-base font-medium">Panell</a>
            @endauth
        </div>
        @auth
            <div class="pt-4 pb-3 border-t border-indigo-700">
                <div class="flex items-center px-5">
                    <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&color=7F9CF5&background=EBF4FF" alt="{{ auth()->user()->name }}">
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-white">{{ auth()->user()->name }}</div>
                        <div class="text-sm font-medium text-indigo-200">{{ auth()->user()->email }}</div>
                    </div>
                </div>
                <div class="mt-3 px-2 space-y-1">
                    <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-indigo-700">El meu perfil</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-white hover:bg-indigo-700">Tancar sessió</button>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-3 border-t border-indigo-700">
                <div class="flex items-center justify-center space-x-2 px-5">
                    <a href="{{ route('login') }}" class="w-full text-center bg-indigo-700 hover:bg-indigo-800 px-4 py-2 rounded-md text-sm font-medium text-white">Iniciar sessió</a>
                    <a href="{{ route('register') }}" class="w-full text-center bg-white text-indigo-600 hover:bg-indigo-50 px-4 py-2 rounded-md text-sm font-medium">Registrar-se</a>
                </div>
            </div>
        @endauth
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', function() {
            const expanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', !expanded);
            mobileMenu.classList.toggle('hidden');

            // Toggle icon
            const openIcon = this.querySelector('svg:first-child');
            const closeIcon = this.querySelector('svg:last-child');
            openIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');
        });

        // User menu toggle
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenu = document.getElementById('user-menu');

        if (userMenuButton && userMenu) {
            userMenuButton.addEventListener('click', function() {
                const expanded = this.getAttribute('aria-expanded') === 'true';
                this.setAttribute('aria-expanded', !expanded);
                userMenu.classList.toggle('hidden');
            });

            // Close user menu when clicking outside
            document.addEventListener('click', function(event) {
                if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                    userMenuButton.setAttribute('aria-expanded', 'false');
                    userMenu.classList.add('hidden');
                }
            });
        }
    });
</script>
