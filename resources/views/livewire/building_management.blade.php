<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new #[Layout('layouts.app')] #[Title('Building Management')] 
class extends Component {
    public $buildings = [];
    public $selectedTab;

    public function mount()
    {
        $this->selectedTab = 'building-tab';
        // Realistic poultry farm building data
        $this->buildings = [
            [
                'id' => 'BH-001',
                'name' => 'Broiler House 1',
                'type' => 'Broiler',
                'construction_date' => '2020-03-15',
                'square_footage' => 20000,
                'max_capacity' => 24000, // Based on standard density of 1.2 sq ft per bird
                'current_occupancy' => 22800,
                'status' => 'Active',
                'environmental_specs' => [
                    'ventilation' => 'Tunnel Ventilation',
                    'lighting' => 'LED Dimmer System',
                    'temp_control' => 'Automated Climate Control',
                    'humidity_control' => 'Evaporative Cooling',
                ],
                'cleaning_status' => 'Completed',
                'last_cleaning' => '2024-10-01',
                'next_cleaning' => '2024-11-15', // After flock departure
                'last_inspection' => '2024-10-05',
                'next_maintenance' => '2024-11-02',
                'current_flock' => [
                    'placement_date' => '2024-09-20',
                    'age_days' => 34,
                    'breed' => 'Ross 308',
                    'expected_harvest' => '2024-11-01',
                ],
            ],
            [
                'id' => 'LH-001',
                'name' => 'Layer House A',
                'type' => 'Layer',
                'construction_date' => '2021-06-20',
                'square_footage' => 25000,
                'max_capacity' => 20000, // Lower density for layers
                'current_occupancy' => 19500,
                'status' => 'Active',
                'environmental_specs' => [
                    'ventilation' => 'Cross Ventilation',
                    'lighting' => 'Programmable LED',
                    'temp_control' => 'Zone Control System',
                    'humidity_control' => 'Misting System',
                ],
                'cleaning_status' => 'In Progress',
                'last_cleaning' => '2024-09-15',
                'next_cleaning' => '2024-11-20',
                'last_inspection' => '2024-10-02',
                'next_maintenance' => '2024-10-30',
                'current_flock' => [
                    'placement_date' => '2024-05-15',
                    'age_days' => 162,
                    'breed' => 'Hy-Line Brown',
                    'production_phase' => 'Peak Lay',
                ],
            ],
            [
                'id' => 'BH-002',
                'name' => 'Broiler House 2',
                'type' => 'Broiler',
                'construction_date' => '2020-03-15',
                'square_footage' => 18000,
                'max_capacity' => 21600,
                'current_occupancy' => 0, // Empty for cleaning
                'status' => 'Inactive',
                'environmental_specs' => [
                    'ventilation' => 'Tunnel Ventilation',
                    'lighting' => 'LED Dimmer System',
                    'temp_control' => 'Automated Climate Control',
                    'humidity_control' => 'Evaporative Cooling',
                ],
                'cleaning_status' => 'In Progress',
                'last_cleaning' => '2024-10-10',
                'next_cleaning' => '2024-11-25',
                'last_inspection' => '2024-10-12',
                'next_maintenance' => '2024-10-28',
                'current_flock' => null, // No current flock
            ],
        ];
    }

    public function getOccupancyPercentage($building)
    {
        return round(($building['current_occupancy'] / $building['max_capacity']) * 100);
    }

    public function getStatusColor($status)
    {
        return match ($status) {
            'Active' => 'green',
            'Inactive' => 'red',
            'Maintenance' => 'yellow',
            default => 'gray',
        };
    }

    public function getCleaningStatusColor($status)
    {
        return match ($status) {
            'Completed' => 'green',
            'In Progress' => 'yellow',
            'Pending' => 'red',
            'Scheduled' => 'blue',
            default => 'gray',
        };
    }
}; ?>

<div>

   {{-- stats --}}
    <div class="flex flex-row gap-4 overflow-x-auto whitespace-nowrap p-4">
        <x-mary-stat title="Total Buildings" value="{{ count($buildings) }}" icon="o-building-office-2"
            tooltip-right="Total number of houses" color="text-gray-600" class="text-gray-500" />
        <x-mary-stat title="Total Capacity"
            value="{{ number_format(array_sum(array_column($buildings, 'max_capacity'))) }}"
            icon="healthicons.o-animal-chicken" tooltip-left="Maximum bird capacity" color="text-blue-600"
            class="text-blue-500" />
        <x-mary-stat title="Current Occupancy"
            value="{{ number_format(array_sum(array_column($buildings, 'current_occupancy'))) }}" icon="o-chart-bar"
            tooltip-left="Total current birds" color="text-green-600" class="text-green-500" />
    </div>
    
    {{-- tabs/ table --}}
    <div class="py-2">
        <div class="max-w-full mx-0 sm:px-6 lg:px-0">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">Poultry House Details</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        House ID/Name</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Type</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Occupancy</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Cleaning</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Flock Details</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Next Maintenance</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-800">
                                @foreach ($buildings as $building)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $building['id'] }} - {{ $building['name'] }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ number_format($building['square_footage']) }} sq ft
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500 dark:text-gray-300">
                                                {{ $building['type'] }}
                                            </div>
                                            <div class="text-xs text-gray-400">
                                                {{ $building['environmental_specs']['ventilation'] }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                                <div class="bg-blue-600 h-2.5 rounded-full"
                                                    style="width: {{ $this->getOccupancyPercentage($building) }}%">
                                                </div>
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-300 mt-1">
                                                {{ number_format($building['current_occupancy']) }}/{{ number_format($building['max_capacity']) }}
                                                ({{ $this->getOccupancyPercentage($building) }}%)
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $this->getStatusColor($building['status']) }}-100 text-{{ $this->getStatusColor($building['status']) }}-800">
                                                {{ $building['status'] }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $this->getCleaningStatusColor($building['cleaning_status']) }}-100 text-{{ $this->getCleaningStatusColor($building['cleaning_status']) }}-800">
                                                {{ $building['cleaning_status'] }}
                                            </span>
                                            <div class="text-xs text-gray-500 mt-1">
                                                Next: {{ date('M d', strtotime($building['next_cleaning'])) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($building['current_flock'])
                                                <div class="text-sm text-gray-900 dark:text-white">
                                                    {{ $building['current_flock']['breed'] }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    Age: {{ $building['current_flock']['age_days'] }} days
                                                </div>
                                            @else
                                                <div class="text-sm text-gray-500">No Active Flock</div>
                                            @endif
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
