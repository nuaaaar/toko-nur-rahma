<header>
    <nav class="bg-white border-gray-200 py-2.5 rounded-lg shadow-lg shadow-gray-300 dark:bg-gray-800">
        <div class="flex flex-wrap justify-between items-center">
            <div class="flex justify-start items-center">
                <button data-drawer-target="sidebar" data-drawer-toggle="sidebar" aria-expanded="true" aria-controls="sidebar"
                    class="p-2 mr-2 text-gray-600 rounded-lg cursor-pointer lg:hidden hover:text-gray-900 hover:bg-gray-100 focus:bg-gray-100 dark:focus:bg-gray-700 focus:ring-2 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    <i data-feather="menu"></i>
                    <span class="sr-only">Toggle sidebar</span>
                </button>
            </div>
            <div class="flex items-center lg:order-2">
                <button type="button" class="flex items-center mx-3 text-sm gap-3 px-3 rounded py-1 hover:bg-gray-200" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="dropdown">
                    <span class="sr-only">Open user menu</span>
                    <div class="bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600">
                        <img class="w-8 h-8 rounded-full"
                            src="https://flowbite.com/docs/images/people/profile-picture-5.jpg"
                            alt="user photo">
                    </div>
                    <div class="text-left">
                        <span
                            class="block text-sm font-semibold text-gray-900 dark:text-white">{{ Auth::user()->name }}</span>
                        <span
                            class="block text-sm font-light text-gray-500 truncate dark:text-gray-400">{{ Auth::user()->email }}</span>
                    </div>
                </button>
                <!-- Dropdown menu -->
                <div class="hidden z-50 my-4 w-56 text-base list-none bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600"
                    id="dropdown">
                    <ul class="py-1 font-light text-gray-500 dark:text-gray-400"
                        aria-labelledby="dropdown">
                        <li>
                            <a href="#"
                                class="block py-2 px-4 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-400 dark:hover:text-white">
                                <i data-feather="settings" class="inline-block mr-2"></i>
                                <span class="inline-block">Pengaturan</span>
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="block py-2 px-4 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                <i data-feather="power" class="inline-block mr-2"></i>
                                <span class="inline-block">Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>