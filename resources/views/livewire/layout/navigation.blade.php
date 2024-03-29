<?php

use App\Livewire\Actions\Logout;
use App\Models\Order;
use function Livewire\Volt\{computed, state, on};

state([
    'orderPending' => fn() => Order::where('status', 'PENDING')->count(),
    'orderShipped' => fn() => Order::where('status', 'PACKED')->count(),
]);

$logout = function (Logout $logout) {
    $logout();

    $this->redirect('/', navigate: true);
};

on([
    'order-update' => function () {
        $this->orderPending = Order::where('status', 'PENDING')->count();
        $this->orderShipped = Order::where('status', 'PACKED')->count();
    },
]);
?>

<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 print:hidden">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" wire:navigate>
                        <img src="https://api.dicebear.com/7.x/notionists/svg?seed={{ Str::slug(Auth()->user()->name) }}"
                            class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-3 sm:-my-px sm:ms-10 sm:flex">

                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @if (auth()->user()->role == 'superadmin')
                        <x-nav-link :href="url('admin/users')" :active="request('admin/users')" wire:navigate>
                            {{ __('Admin') }}
                        </x-nav-link>

                        <x-nav-link :href="url('/admin/settings')" :active="request()->routeIs('/admin/settings')" wire:navigate>
                            {{ __('Toko') }}
                        </x-nav-link>
                    @else
                        <x-nav-link :href="url('/admin/costumers')" :active="request()->routeIs('/admin/costumers')" wire:navigate>
                            {{ __('Pelanggan') }}
                        </x-nav-link>

                        <div class="hidden sm:flex sm:items-center sm:ml-6 pt-1">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button
                                        class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                        <div>Kelola Produk</div>

                                        <div class="ml-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link :href="url('/admin/products/categories')"
                                        active="request()->routeIs('/admin/products/categories')" wire:navigate>
                                        {{ __('Kategori Produk') }}
                                    </x-dropdown-link>

                                    <x-dropdown-link :href="url('/admin/products')" active="request()->routeIs('/admin/products')"
                                        wire:navigate>
                                        {{ __('Produk Toko') }}
                                    </x-dropdown-link>

                                </x-slot>
                            </x-dropdown>
                        </div>

                        <x-nav-link :href="url('/admin/transactions/index')" :active="request()->routeIs('/admin/costumers')" wire:navigate>
                            {{ __('Transaksi') }} @if ($orderPending > 0)
                                <span class="ml-1 badge badge-neutral">!</span>
                            @elseif ($orderShipped > 0)
                                <span class="ml-1 badge badge-neutral">!</span>
                            @endif
                        </x-nav-link>
                    @endif

                    <div class="hidden sm:flex sm:items-center sm:ml-6 pt-1">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                    <div>Laporan</div>

                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="url('/admin/reports/costumers')"
                                    active="request()->routeIs('/admin/reports/costumers')" wire:navigate>
                                    {{ __('Pelanggan') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="url('/admin/reports/products')"
                                    active="request()->routeIs('/admin/reports/products')" wire:navigate>
                                    {{ __('Produk Toko') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="url('/admin/reports/categories')"
                                    active="request()->routeIs('/admin/reports/categories')" wire:navigate>
                                    {{ __('Kategori Produk') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="url('/admin/reports/transactions')"
                                    active="request()->routeIs('/admin/reports/transactions')" wire:navigate>
                                    {{ __('Penjualan') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="url('/admin/reports/shipping')"
                                    active="request()->routeIs('/admin/reports/shipping')" wire:navigate>
                                    {{ __('Pengiriman') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="url('/admin/reports/rank_categories')"
                                    active="request()->routeIs('/admin/reports/rank_categories')" wire:navigate>
                                    {{ __('Kategori Terlaris') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="url('/admin/reports/rank_products')"
                                    active="request()->routeIs('/admin/reports/rank_products')" wire:navigate>
                                    {{ __('Produk Terlaris') }}
                                </x-dropdown-link>

                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div x-data="{ name: '{{ auth()->user()->name }}' }" x-text="name"
                                x-on:profile-updated.window="name = $event.detail.name"></div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="url('/admin/account')" wire:navigate>
                            {{ __('Akun Pengguna') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link>
                                {{ __('Keluar') }}
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
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

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('/dashboard')" wire:navigate>
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if (auth()->user()->role == 'superadmin')
                <x-responsive-nav-link :href="url('/admin/users')" :active="request()->routeIs('/admin/users')" wire:navigate>
                    {{ __('Admin') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="url('/admin/settings')" :active="request()->routeIs('/admin/settings')" wire:navigate>
                    {{ __('Toko') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="url('/admin/costumers')" :active="request()->routeIs('/admin/costumers')" wire:navigate>
                    {{ __('Pelanggan') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="url('/admin/products/categories')" :active="request()->routeIs('/admin/products/categories')" wire:navigate>
                    {{ __('Kategori Produk') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="url('/admin/products')" :active="request()->routeIs('/admin/products')" wire:navigate>
                    {{ __('Produk Toko') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="url('/admin/transactions')" :active="request()->routeIs('/admin/transactions')" wire:navigate>
                    {{ __('Transaksi') }}
                </x-responsive-nav-link>
            @endif
            <x-responsive-nav-link :href="url('/admin/report')" :active="request()->routeIs('/admin/report')" wire:navigate>
                {{ __('Laporan') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200" x-data="{ name: '{{ auth()->user()->name }}' }"
                    x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="url('/admin/account')" wire:navigate>
                    {{ __('Akun Pengguna') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link>
                        {{ __('Keluar') }}
                    </x-responsive-nav-link>
                </button>
            </div>
        </div>
    </div>
</nav>
