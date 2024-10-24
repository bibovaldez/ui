<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

new #[Layout('layouts.app')]
#[Title('Dashboard')]
class extends Component {
    public $buildingStats = [
        'total_buildings' => 5,
        'total_capacity' => 10000,
        'current_occupancy' => 8500,
        'active_buildings' => 4,
    ];

    public $flockStats = [
        'total_birds' => 8500,
        'mortality_rate' => 0.5,
        'average_weight' => 2.1,
        'feed_consumption' => 1200,
    ];

    public $productionStats = [
        'daily_eggs' => 7500,
        'broken_eggs' => 25,
        'fcr' => 1.75,
        'adg' => 55,
    ];

    public $inventoryLevels = [
        'feed_stock' => 85,
        'medicine_stock' => 70,
        'vaccine_stock' => 60,
    ];

    public function mount()
    {
        // In a real application, you would fetch these from your database
    }
}; ?>

<div class="py-2">
    <div class="max-w-full mx-0 sm:px-6 lg:px-0">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <!-- Main Dashboard -->
            <div class="p-6">
                <!-- Header -->
                <div class="mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">
                        Poultry Farm Dashboard
                    </h2>
                </div>

                <!-- Quick Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <!-- Building Stats -->
                    <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold text-blue-700 dark:text-blue-200 mb-2">Building Status</h3>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-300">Total Buildings</p>
                                <p class="text-xl font-bold text-blue-600 dark:text-blue-300">
                                    {{ $buildingStats['total_buildings'] }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-300">Occupancy</p>
                                <p class="text-xl font-bold text-blue-600 dark:text-blue-300">
                                    {{ number_format(($buildingStats['current_occupancy'] / $buildingStats['total_capacity']) * 100, 1) }}%
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Flock Stats -->
                    <div class="bg-green-50 dark:bg-green-900 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold text-green-700 dark:text-green-200 mb-2">Flock Status</h3>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-300">Total Birds</p>
                                <p class="text-xl font-bold text-green-600 dark:text-green-300">
                                    {{ number_format($flockStats['total_birds']) }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-300">Mortality Rate</p>
                                <p class="text-xl font-bold text-green-600 dark:text-green-300">
                                    {{ $flockStats['mortality_rate'] }}%
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Production Stats -->
                    <div class="bg-yellow-50 dark:bg-yellow-900 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold text-yellow-700 dark:text-yellow-200 mb-2">Production</h3>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-300">Daily Eggs</p>
                                <p class="text-xl font-bold text-yellow-600 dark:text-yellow-300">
                                    {{ number_format($productionStats['daily_eggs']) }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-300">FCR</p>
                                <p class="text-xl font-bold text-yellow-600 dark:text-yellow-300">
                                    {{ $productionStats['fcr'] }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Inventory Stats -->
                    <div class="bg-purple-50 dark:bg-purple-900 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold text-purple-700 dark:text-purple-200 mb-2">Inventory</h3>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-300">Feed Stock</p>
                                <p class="text-xl font-bold text-purple-600 dark:text-purple-300">
                                    {{ $inventoryLevels['feed_stock'] }}%
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-300">Medicine Stock</p>
                                <p class="text-xl font-bold text-purple-600 dark:text-purple-300">
                                    {{ $inventoryLevels['medicine_stock'] }}%
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
 

                <!-- Recent Activities -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3">Recent Activities</h3>
                    <div class="bg-white dark:bg-gray-700 rounded-lg shadow">
                        <div class="p-4 border-b dark:border-gray-600">
                            <p class="text-gray-800 dark:text-gray-200">Daily collection recorded - Building A1</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Today 09:00 AM</p>
                        </div>
                        <div class="p-4 border-b dark:border-gray-600">
                            <p class="text-gray-800 dark:text-gray-200">Feed stock updated</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Today 08:30 AM</p>
                        </div>
                        <div class="p-4">
                            <p class="text-gray-800 dark:text-gray-200">Vaccination completed - Building B2</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Yesterday 04:15 PM</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>