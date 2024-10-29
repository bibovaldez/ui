<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new #[Layout('layouts.app')] #[Title('Building Management')] class extends Component {
    public $buildings = [];
    public $selectedTab;
    // Modal for diferent buildin
    public $buildingModals = [];

    public function mount()
    {
        $this->buildingModals = [];
        $this->selectedTab = 'building-tab';
        // Realistic poultry farm building data
        $this->buildings = [
            [
                'id' => 'BH-001',
                'name' => 'Fuyo Farm',
                'type' => [
                    'type' => 'Broiler',
                    'breed' => 'Ross 308',
                ],
                'max_capacity' => 24000, // Based on standard density of 1.2 sq ft per bird
                'current_occupancy' => 22800,
                'status' => 'Active',
                'poultry_manager' => [
                    'name' => 'Mang Tomas',
                    'phone' => '0912345678',
                    'email' => 'mangtomas@example.com',
                ],
                'last_inspection' => '2024-10-05',
                'next_maintenance' => '2024-11-02',
                'current_flock' => [
                    'placement_date' => '2024-10-20',
                    'breed' => 'Ross 308', // 28 days old before harvest
                    'expected_harvest' => '2024-11-17',
                ],
            ],
        ];
        // Initialize modal state for each building
        foreach ($this->buildings as $building) {
            $this->buildingModals[$building['id']] = false;
        }
    }
    public function toggleModal($buildingId)
    {
        $this->buildingModals[$buildingId] = !$this->buildingModals[$buildingId];
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
    <div class="flex flex-row gap-4 overflow-x-auto whitespace-nowrap">
        <x-mary-stat title="Total Buildings" value="{{ count($buildings) }}" icon="o-building-office-2"
            tooltip-right="Total number of registered building" color="text-gray-600" class="text-gray-500" />
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
                                        Flock Details</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Maintenance</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-800">
                                @foreach ($buildings as $building)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <x-mary-modal wire:model="buildingModals.{{ $building['id'] }}"
                                                class="backdrop-blur" title="{{ $building['name'] }}"
                                                subtitle="{{ $building['id'] }}" separator box-class="max-w-[40rem]"
                                                persistent>

                                                {{-- Building Overview Section --}}
                                                <div class="space-y-6 p-4">
                                                    {{-- Manager Information Card --}}
                                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                                        <h3 class="text-lg font-semibold mb-3 flex items-center gap-2">
                                                            <x-mary-icon name="o-user-circle" class="w-5 h-5" />
                                                            Manager Information
                                                        </h3>
                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                            <div>
                                                                <div
                                                                    class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                                                    Name</div>
                                                                <div class="text-sm text-gray-900 dark:text-white">
                                                                    {{ $building['poultry_manager']['name'] }}</div>
                                                            </div>
                                                            <div>
                                                                <div
                                                                    class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                                                    Contact</div>
                                                                <div class="text-sm text-gray-900 dark:text-white">
                                                                    {{ $building['poultry_manager']['phone'] }}</div>
                                                                <div class="text-sm text-gray-900 dark:text-white">
                                                                    {{ $building['poultry_manager']['email'] }}</div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- Building Details Card --}}
                                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                                        <h3 class="text-lg font-semibold mb-3 flex items-center gap-2">
                                                            <x-mary-icon name="o-building-office-2" class="w-5 h-5" />
                                                            Building Details
                                                        </h3>
                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                            <div>
                                                                <div
                                                                    class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                                                    Type & Breed</div>
                                                                <div class="text-sm text-gray-900 dark:text-white">
                                                                    {{ $building['type']['type'] }} -
                                                                    {{ $building['type']['breed'] }}</div>
                                                            </div>
                                                            <div>
                                                                <div
                                                                    class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                                                    Capacity</div>
                                                                <div class="text-sm text-gray-900 dark:text-white">
                                                                    {{ number_format($building['current_occupancy']) }}
                                                                    / {{ number_format($building['max_capacity']) }}
                                                                    ({{ $this->getOccupancyPercentage($building) }}%)
                                                                </div>
                                                            </div>


                                                            <div>
                                                                <div
                                                                    class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                                                    Breed</div>
                                                                <div class="text-sm text-gray-900 dark:text-white">
                                                                    {{ $building['current_flock']['breed'] }}</div>
                                                            </div>
                                                            <div>
                                                                <div
                                                                    class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                                                    Age</div>
                                                                <div class="text-sm text-gray-900 dark:text-white">
                                                                    {{ date_diff(date_create($building['current_flock']['placement_date']), date_create('now'))->format('%a days') }}
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <div
                                                                    class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                                                    Placement Date</div>
                                                                <div class="text-sm text-gray-900 dark:text-white">
                                                                    {{ date('M d, Y', strtotime($building['current_flock']['placement_date'])) }}
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <div
                                                                    class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                                                    Expected Harvest</div>
                                                                <div class="text-sm text-gray-900 dark:text-white">
                                                                    {{ date('M d, Y', strtotime($building['current_flock']['expected_harvest'])) }}
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>



                                                    {{-- Maintenance Information --}}
                                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                                        <h3 class="text-lg font-semibold mb-3 flex items-center gap-2">
                                                            <x-mary-icon name="o-wrench-screwdriver" class="w-5 h-5" />
                                                            Maintenance Schedule
                                                        </h3>
                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                            <div>
                                                                <div
                                                                    class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                                                    Last Inspection</div>
                                                                <div class="text-sm text-gray-900 dark:text-white">
                                                                    {{ date('M d, Y', strtotime($building['last_inspection'])) }}
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <div
                                                                    class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                                                    Next Maintenance</div>
                                                                <div class="text-sm text-gray-900 dark:text-white">
                                                                    {{ date('M d, Y', strtotime($building['next_maintenance'])) }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="flex justify-end gap-2">
                                                    <x-mary-button label="Close" icon="o-x-mark"
                                                        wire:click="toggleModal('{{ $building['id'] }}')"
                                                        class="bg-blue-500 hover:bg-blue-600 text-white" />
                                                </div>

                                            </x-mary-modal>

                                            <x-mary-popover>
                                                <x-slot name="trigger"
                                                    wire:click="toggleModal('{{ $building['id'] }}')">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ $building['name'] }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        {{ $building['id'] }}
                                                    </div>
                                                </x-slot>
                                                <x-slot name="content">
                                                    <div class="text-sm text-gray-900 dark:text-white">
                                                        Manager Name: {{ $building['poultry_manager']['name'] }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        Phone: {{ $building['poultry_manager']['phone'] }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        Email: {{ $building['poultry_manager']['email'] }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        Click for more details
                                                    </div>
                                                </x-slot>
                                            </x-mary-popover>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500 dark:text-gray-300">
                                                {{ $building['type']['type'] }}
                                            </div>
                                            <div class="text-xs text-gray-400">
                                                {{ $building['type']['breed'] }}
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
                                            <x-mary-popover>
                                                <x-slot name="trigger">
                                                    @if ($building['current_flock'])
                                                        <div class="text-sm text-gray-900 dark:text-white">
                                                            {{ $building['current_flock']['breed'] }}
                                                        </div>
                                                        <div class="text-xs text-gray-500">
                                                            Age:
                                                            {{ date_diff(date_create($building['current_flock']['placement_date']), date_create('now'))->format('%a days') }}
                                                        </div>
                                                    @else
                                                        <div class="text-sm text-gray-500">No Active Flock</div>
                                                    @endif
                                                </x-slot>
                                                <x-slot name="content">
                                                    @if ($building['current_flock'])
                                                        Placement Date:
                                                        {{ date('M d, Y', strtotime($building['current_flock']['placement_date'])) }}
                                                        <br>
                                                        Expected Harvest:
                                                        {{ date('M d, Y', strtotime($building['current_flock']['expected_harvest'])) }}
                                                        <br>
                                                    @endif
                                                </x-slot>
                                            </x-mary-popover>

                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{-- last and next --}}
                                            <div class="text-sm text-gray-500 dark:text-gray-300">
                                                Last Inspection:
                                                {{ date('M d, Y', strtotime($building['last_inspection'])) }}
                                            </div>
                                            <div class="text-xs text-gray-400">
                                                Next Maintenance:
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



    {{-- tabs --}}



</div>
