<?php

use Dipantry\Rajaongkir\Models\ROProvince;
use Dipantry\Rajaongkir\Models\ROCity;
use App\Models\Shop;
use function Livewire\Volt\{state, computed, rules};

state(['province_id'])->url();

$getShop = computed(function () {
    return Shop::first();
});

state([
    'name' => fn() => $this->getShop->name ?? '',
    'province_id' => fn() => $this->getShop->province_id ?? '',
    'city_id' => fn() => $this->getShop->city_id ?? '',
    'details' => fn() => $this->getShop->details ?? '',
    'provinces' => fn() => ROProvince::all(),
]);

$cities = computed(function () {
    return ROCity::where('province_id', $this->province_id)->get();
});

rules([
    'name' => 'required|min:5',
    'province_id' => 'required|exists:rajaongkir_provinces,id',
    'city_id' => 'required|exists:rajaongkir_cities,id',
    'details' => 'required|min:20',
]);

$submit = function () {
    $validate = $this->validate();
    if ($this->getShop) {
        $updateShop = Shop::first();
        $updateShop->update($validate);
    } elseif (!$this->getShop) {
        Shop::create($validate);
    }
    $this->dispatch('address-update');
};

?>

<x-app-layout>
    @volt
        <div>
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Pengaturan Informasi
                </h2>
            </x-slot>

            <div>
                <div class="sm:px-6 lg:px-8">
                    <div x-data="{ openTab: 1 }" class="py-8">
                        <div class="mx-auto">
                            <div class="mb-4 flex space-x-4 p-2 bg-white rounded-lg shadow-md">
                                <button x-on:click="openTab = 1" :class="{ 'bg-black text-white': openTab === 1 }"
                                    class="flex-1 py-2 px-4 rounded-md focus:outline-none focus:shadow-outline-blue transition-all duration-300">Profile
                                    Pengguna</button>

                                <button x-on:click="openTab = 2" :class="{ 'bg-black text-white': openTab === 2 }"
                                    class="flex-1 py-2 px-4 rounded-md focus:outline-none focus:shadow-outline-blue transition-all duration-300">Update
                                    Password</button>


                            </div>

                            <div x-show="openTab === 1"
                                class="transition-all duration-300 bg-white p-4 rounded-lg shadow-md border-l-4 border-black">
                                <h2 class="text-2xl font-semibold mb-2">Profil Pengguna</h2>
                                <livewire:profile.update-profile-information-form />
                            </div>

                            <div x-show="openTab === 2"
                                class="transition-all duration-300 bg-white p-4 rounded-lg shadow-md border-l-4 border-black">
                                <h2 class="text-2xl font-semibold mb-2">Profil Pengguna</h2>
                                <livewire:profile.update-password-form />
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @endvolt
</x-app-layout>
