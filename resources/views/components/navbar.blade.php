<nav class="bg-white shadow">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <span class="text-lg font-bold text-black">RUANG BUDAYA</span>
            </div>

            <!-- Navigation links -->
            <div class="hidden space-x-8 md:flex md:items-center">
                <a href="/" class="nav-link text-sm font-medium text-gray-700 hover:text-gray-900">Beranda</a>
                <a href="/library" class="nav-link text-sm font-medium text-gray-700 hover:text-gray-900">E-Learning</a>
                <a href="/history" class="nav-link text-sm font-medium text-gray-700 hover:text-gray-900">Sejarah Kebudayaan</a>
                <a href="/news" class="nav-link text-sm font-medium text-gray-700 hover:text-gray-900">Berita Terkini</a>
                <a href="/forum" class="nav-link text-sm font-medium text-gray-700 hover:text-gray-900">Forum Diskusi</a>

                @auth
                <div class="relative ml-3">
                    <div>
                        <button type="button" class="flex rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                            <span class="sr-only">Open user menu</span>
                            @if (Auth::user()->profile_picture == null)
                                @if (Auth::user()->role == 'user')
                                <img class="h-8 w-8 rounded-full" src="{{ asset('img/profile-icon/user.png') }}" alt="">
                                @elseif (Auth::user()->role == 'admin')
                                <img class="h-8 w-8 rounded-full" src="{{ asset('img/profile-icon/admin.png') }}" alt="">
                                @endif
                            @else
                                <img class="h-8 w-8 rounded-full" src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="">
                            @endif
                        </button>
                    </div>
                    <!-- Dropdown menu, hidden by default -->
                    <div id="user-dropdown" class="hidden absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button">
                        @if (Auth::user()->role == 'admin')
                            <span class="block px-4 pt-2 text-sm text-gray-400">Administrator</span>
                        @endif
                        <p class="block px-4 py-2 text-sm text-gray-700" role="menuitem">Halo, <span class="font-bold">{{ ucwords(Auth::user()->name) }}</span>!</p>
                        <hr>
                        <a href="/profile" class="block px-4 py-2 text-sm text-gray-700" role="menuitem">Profile</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-2 text-sm text-gray-700" role="menuitem">
                            Logout
                        </a>
                    </div>
                </div>
                @else
                <a href="/login" class="text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 duration-300 py-2 px-4 rounded-lg">Login</a>
                @endauth
            </div>
            
            <!-- Mobile menu button -->
            <div class="flex md:hidden">
                <button id="mobile-menu-button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-black focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                    <svg class="block h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 6h16M4 12h16m-7 6h7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div id="mobile-menu" class="hidden md:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="/" class="mobile-nav-link block px-3 py-2 text-base font-medium text-gray-700 rounded-md hover:bg-gray-50">Beranda</a>
            <a href="/library" class="mobile-nav-link block px-3 py-2 text-base font-medium text-gray-700 rounded-md hover:bg-gray-50">E-Learning</a>
            <a href="/history" class="mobile-nav-link block px-3 py-2 text-base font-medium text-gray-700 rounded-md hover:bg-gray-50">Sejarah Kebudayaan</a>
            <a href="/news" class="mobile-nav-link block px-3 py-2 text-base font-medium text-gray-700 rounded-md hover:bg-gray-50">Berita Terkini</a>
            <a href="/forum" class="mobile-nav-link block px-3 py-2 text-base font-medium text-gray-700 rounded-md hover:bg-gray-50">Forum Diskusi</a>
            @guest
            <a href="/login" class="mobile-nav-link block px-3 py-2 text-base font-medium text-gray-700 rounded-md hover:bg-gray-50">Login/Register</a>
            @endguest
        </div>
    </div>
</nav>

<script>
    // Highlight active link based on current URL
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-link');
    const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');

    navLinks.forEach(link => {
        if (link.getAttribute('href') === currentPath) {
            link.classList.add('text-indigo-600', 'font-bold');
        }
    });

    mobileNavLinks.forEach(link => {
        if (link.getAttribute('href') === currentPath) {
            link.classList.add('text-indigo-600', 'font-bold');
        }
    });

    // Toggle the mobile menu
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    mobileMenuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });

    // Toggle the dropdown
    const userMenuButton = document.getElementById('user-menu-button');
    const userDropdown = document.getElementById('user-dropdown');

    userMenuButton.addEventListener('click', (event) => {
        event.stopPropagation(); // Prevent the click from closing the dropdown
        userDropdown.classList.toggle('hidden');
    });

    // Close dropdown if clicked outside
    window.addEventListener('click', function(e) {
        if (!userMenuButton.contains(e.target) && !userDropdown.contains(e.target)) {
            userDropdown.classList.add('hidden');
        }
    });
</script>