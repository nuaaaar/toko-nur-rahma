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
        <ul class="space-y-1">
            @canany(['sales.read', 'customers.read', 'banks.read'])
                <li class="menu-item has-submenu">
                    <a href="javascript:;" class="toggle-submenu">
                        <div class="menu-icon">
                            <i data-feather="shopping-cart"></i>
                        </div>
                        <span class="menu-text">Penjualan</span>
                    </a>
                    <ul class="submenu">
                        @can('sales.read')
                            <li class="submenu-item">
                                <a href="{{ route('dashboard.sale.index') }}">
                                    <span class="menu-text">Penjualan</span>
                                </a>
                            </li>
                        @endcan
                        @can('customers.read')
                            <li class="submenu-item">
                                <a href="{{ route('dashboard.customer.index') }}">
                                    <span class="menu-text">Customer</span>
                                </a>
                            </li>
                        @endcan
                        @can('banks.read')
                            <li class="submenu-item">
                                <a href="{{ route('dashboard.bank.index') }}">
                                    <span class="menu-text">Bank</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany
            @canany(['procurements.read', 'suppliers.read', 'products.read', 'empty-product-stocks.read'])
                <li class="menu-item has-submenu">
                    <a href="javascript:;" class="toggle-submenu">
                        <div class="menu-icon">
                            <i data-feather="archive"></i>
                        </div>
                        <span class="menu-text">Pengadaan Stok</span>
                    </a>
                    <ul class="submenu">
                        @can('procurements.read')
                            <li class="submenu-item">
                                <a href="{{ route('dashboard.procurement.index') }}">
                                    <span class="menu-text">Pengadaan Stok</span>
                                </a>
                            </li>
                        @endcan
                        @can('suppliers.read')
                            <li class="submenu-item">
                                <a href="{{ route('dashboard.supplier.index') }}">
                                    <span class="menu-text">Agen</span>
                                </a>
                            </li>
                        @endcan
                        @can('products.read')
                            <li class="submenu-item">
                                <a href="{{ route('dashboard.product.index') }}">
                                    <span class="menu-text">Jenis Barang</span>
                                </a>
                            </li>
                        @endcan
                        @can('empty-product-stocks.read')
                            <li class="submenu-item">
                                <a href="#">
                                    <span class="menu-text">Stok Kosong</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany
            @canany(['purchase-orders.read', 'delivery-orders.read'])
                <li class="menu-item has-submenu">
                    <a href="javascript:;" class="toggle-submenu">
                        <div class="menu-icon">
                            <i data-feather="truck"></i>
                        </div>
                        <span class="menu-text">Purchase Order</span>
                    </a>
                    <ul class="submenu">
                        @can('purchase-orders.read')
                            <li class="submenu-item">
                                <a href="{{ route('dashboard.purchase-order.index') }}">
                                    <span class="menu-text">Purchase Order</span>
                                </a>
                            </li>
                        @endcan
                        @can('delivery-orders.read')
                            <li class="submenu-item">
                                <a href="{{ route('dashboard.delivery-order.index') }}">
                                    <span class="menu-text">Surat Jalan</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany
            @canany(['product-stocks.read', 'profit-and-loss'])
                <li class="menu-item has-submenu">
                    <a href="javascript:;" class="toggle-submenu">
                        <div class="menu-icon">
                            <i data-feather="file-text"></i>
                        </div>
                        <span class="menu-text">Laporan</span>
                    </a>
                    <ul class="submenu">
                        @can('product-stocks.read')
                            <li class="submenu-item">
                                <a href="{{ route('dashboard.product-stock.index') }}">
                                    <span class="menu-text">Laporan Stok</span>
                                </a>
                            </li>
                        @endcan
                        @can('profit-and-loss.read')
                            <li class="submenu-item">
                                <a href="{{ route('dashboard.profit-loss.index') }}">
                                    <span class="menu-text">Laba Rugi</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany
            @can('customer-returns.read')
                <li class="menu-item">
                    <a href="{{ route('dashboard.customer-return.index') }}">
                        <div class="menu-icon">
                            <i data-feather="rotate-ccw"></i>
                        </div>
                        <span class="menu-text">Retur Customer</span>
                    </a>
                </li>
            @endcan
            @can('stock-opnames.read')
                <li class="menu-item">
                    <a href="{{ route('dashboard.stock-opname.index') }}">
                        <div class="menu-icon">
                            <i data-feather="clipboard"></i>
                        </div>
                        <span class="menu-text">Stock Opname</span>
                    </a>
                </li>
            @endcan
            @canany(['users.read', 'roles.read'])
                <li class="menu-item has-submenu">
                    <a href="javascript:;" class="toggle-submenu">
                        <div class="menu-icon">
                            <i data-feather="users"></i>
                        </div>
                        <span class="menu-text">Akun Karyawan</span>
                    </a>
                    <ul class="submenu">
                        @can('users.read')
                            <li class="submenu-item">
                                <a href="{{ route('dashboard.user.index') }}">
                                    <span class="menu-text">Pengguna</span>
                                </a>
                            </li>
                        @endcan
                        @can('roles.read')
                            <li class="submenu-item">
                                <a href="{{ route('dashboard.role-and-permission.index') }}">
                                    <span class="menu-text">Jenis Pengguna</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany
        </ul>
    </div>
</aside>
