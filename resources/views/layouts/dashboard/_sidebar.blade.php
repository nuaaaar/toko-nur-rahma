<aside id="sidebar"
    class="sidebar sidebar fixed top-0 bottom-0 z-50 h-full min-h-screen w-64 shadow-lg  transition-transform -translate-x-full md:translate-x-0 duration-300">
    <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
        <div class="flex items-center pl-2.5 mb-5">
            <a href="{{ route('dashboard.index') }}" class="grid place-items-center mr-3 p-2 rounded dark:bg-white" >
                <img src="{{ asset('images/logo.png') }}" class="h-6" alt="Flowbite Logo" />
            </a>
            <span
                class="self-center text-xl font-bold tracking-tight whitespace-nowrap dark:text-white">SISTEM TOKO</span>
        </div>
        <ul class="space-y-2">
            @can('roles.read')
                <li class="menu-item">
                    <a href="{{ route('dashboard.role-and-permission.index') }}">
                        <div class="menu-icon">
                            <i data-feather="users"></i>
                        </div>
                        <span class="menu-text">Jenis Pengguna</span>
                    </a>
                </li>
            @endcan
            <li class="menu-item">
                <a href="{{ route('dashboard.user.index') }}">
                    <div class="menu-icon">
                        <i data-feather="user"></i>
                    </div>
                    <span class="menu-text">Pengguna</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
