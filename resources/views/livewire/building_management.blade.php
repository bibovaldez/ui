<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;
 
new
#[Layout('layouts.app')]       // <-- Here is the `empty` layout
#[Title('Building Management')]
class extends Component {
    public $buildings = [];
    
    public function mount()
    {
        // Sample data
        $this->buildings = [
            [
                'id' => 1,
                'name' => 'Tower A',
                'type' => 'Residential',
                'capacity' => 100,
                'current_occupancy' => 85,
                'status' => 'Active',
                'cleaning_status' => 'Completed',
                'next_maintenance' => '2024-11-15',
                'last_inspection' => '2024-10-01',
            ],
            [
                'id' => 2,
                'name' => 'Building B',
                'type' => 'Commercial',
                'capacity' => 50,
                'current_occupancy' => 45,
                'status' => 'Active',
                'cleaning_status' => 'In Progress',
                'next_maintenance' => '2024-11-20',
                'last_inspection' => '2024-09-28',
            ],
            [
                'id' => 3,
                'name' => 'Complex C',
                'type' => 'Mixed Use',
                'capacity' => 75,
                'current_occupancy' => 60,
                'status' => 'Inactive',
                'cleaning_status' => 'Pending',
                'next_maintenance' => '2024-11-10',
                'last_inspection' => '2024-10-05',
            ],
        ];
    }

    public function getOccupancyPercentage($building)
    {
        return round(($building['current_occupancy'] / $building['capacity']) * 100);
    }

    public function getStatusColor($status)
    {
        return match($status) {
            'Active' => 'green',
            'Inactive' => 'red',
            default => 'gray'
        };
    }

    public function getCleaningStatusColor($status)
    {
        return match($status) {
            'Completed' => 'green',
            'In Progress' => 'yellow',
            'Pending' => 'red',
            default => 'gray'
        };
    }
}; ?>

<div>
    <div class="py-2">
        <div class="max-w-full mx-0 sm:px-6 lg:px-0">
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Total Buildings</h3>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ count($buildings) }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Active Buildings</h3>
                    <p class="text-3xl font-bold text-green-600">
                        {{ count(array_filter($buildings, fn($b) => $b['status'] === 'Active')) }}
                    </p>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Total Capacity</h3>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">
                        {{ array_sum(array_column($buildings, 'capacity')) }}
                    </p>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Total Occupancy</h3>
                    <p class="text-3xl font-bold text-blue-600">
                        {{ array_sum(array_column($buildings, 'current_occupancy')) }}
                    </p>
                </div>
            </div>

            <!-- Buildings Table -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">Building Details</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Building</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Occupancy</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Cleaning</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Next Maintenance</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-800">
                                @foreach($buildings as $building)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $building['name'] }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500 dark:text-gray-300">{{ $building['type'] }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $this->getOccupancyPercentage($building) }}%"></div>
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-300 mt-1">
                                            {{ $building['current_occupancy'] }}/{{ $building['capacity'] }}
                                            ({{ $this->getOccupancyPercentage($building) }}%)
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $this->getStatusColor($building['status']) }}-100 text-{{ $this->getStatusColor($building['status']) }}-800">
                                            {{ $building['status'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $this->getCleaningStatusColor($building['cleaning_status']) }}-100 text-{{ $this->getCleaningStatusColor($building['cleaning_status']) }}-800">
                                            {{ $building['cleaning_status'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500 dark:text-gray-300">
                                            {{ date('M d, Y', strtotime($building['next_maintenance'])) }}
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
