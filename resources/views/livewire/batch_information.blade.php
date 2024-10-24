<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;
use Carbon\Carbon;

new #[Layout('layouts.app')] #[Title('Batch Management')] class extends Component {
    public array $batches = [];

    public function mount()
    {
        // Enhanced sample data with more detailed information
        $this->batches = [
            [
                'id' => 'BAT-2024-001',
                'birdType' => 'Broiler',
                'breed' => 'Ross 308',
                'supplier' => [
                    'name' => 'Premium Poultry Genetics Ltd.',
                    'contact' => [
                        'phone' => '+1 (555) 123-4567',
                        'email' => 'orders@ppgenetics.com',
                        'representative' => 'John Smith',
                        'address' => '123 Poultry Farm Road, Kansas',
                    ],
                    'purchaseOrder' => [
                        'number' => 'PO-2024-0892',
                        'date' => '2024-03-10',
                        'terms' => 'Net 30',
                        'value' => '$25,000',
                    ],
                    'healthCertificates' => [
                        'number' => 'HC-2024-456',
                        'issueDate' => '2024-03-12',
                        'expiryDate' => '2024-03-19',
                        'issuingAuthority' => 'State Veterinary Board',
                    ],
                ],
                'placement' => [
                    'arrivalDate' => '2024-03-14',
                    'placementDate' => '2024-03-15',
                    'quantity' => 10000,
                    'location' => [
                        'house' => 'Sagitarian',
                        'section' => 'San Filipe',
                        'capacity' => 12000,
                    ],
                    'conditions' => [
                        'temperature' => '32°C',
                        'humidity' => '65%',
                        'ventilation' => 'Optimal',
                        'lighting' => '23 hours',
                    ],
                ],
                'initialMetrics' => [
                    'totalBirdsPlaced' => 10000,
                    'averageWeight' => '42g',
                    'uniformity' => '95%',
                    'mortalityRate' => '0.5%',
                    'expectedYield' => [
                        'targetWeight' => '2.5kg',
                        'expectedFCR' => '1.65',
                        'projectedMargin' => '22%',
                    ],
                    'growthTargets' => [
                        'week1' => '185g',
                        'week2' => '465g',
                        'week3' => '943g',
                        'week4' => '1580g',
                        'week5' => '2300g',
                        'week6' => '2500g',
                    ],
                ],
                'currentStatus' => [
                    'asOf' => '2024-04-10',
                    'liveBirdCount' => 9875,
                    'mortality' => [
                        'total' => 95,
                        'week1' => 25,
                        'week2' => 30,
                        'week3' => 40,
                    ],
                    'culling' => [
                        'total' => 30,
                        'reasons' => [
                            'runts' => 12,
                            'deformities' => 8,
                            'injuries' => 10,
                        ],
                    ],
                    'growthStatus' => [
                        'currentWeight' => '1650g',
                        'uniformity' => '92%',
                        'fcr' => '1.68',
                        'dailyGain' => '65g',
                    ],
                ],
                'harvestPlanning' => [
                    'expectedDate' => '2024-09-30',
                    'marketPreparation' => [
                        'withdrawalStart' => '2024-04-24',
                        'catchingTime' => '22:00',
                        'transportArrangements' => 'Confirmed',
                    ],
                    'processingSchedule' => [
                        'date' => '2024-04-26',
                        'shift' => 'Morning',
                        'processingPlant' => 'Main Plant - Line 2',
                        'capacityAllocated' => '10,000 birds',
                    ],
                    'targetMetrics' => [
                        'weight' => '2.5kg ± 200g',
                        'grade' => 'A',
                        'yield' => '72%',
                    ],
                    'marketDemand' => [
                        'buyer' => 'Metro Supermarkets',
                        'productType' => 'Whole Bird',
                        'pricePerKg' => '$3.25',
                        'orderQuantity' => '9000 birds',
                    ],
                ],
                'status' => 'active',
            ],
            [
                'id' => 'BAT-2024-002',
                'birdType' => 'Broiler',
                'breed' => 'Cobb 500',
                'supplier' => [
                    'name' => 'Poultry Genetics Inc.',
                    'contact' => [
                        'phone' => '+1 (555) 987-6543',
                        'email' => 'awdawd@dw.com',
                        'representative' => 'Jane Doe',
                        'address' => '456 Poultry Farm Road, Texas',
                    ],
                    'purchaseOrder' => [
                        'number' => 'PO-2024-0893',
                        'date' => '2024-03-15',
                        'terms' => 'Net 30',
                        'value' => '$28,000',
                    ],
                    'healthCertificates' => [
                        'number' => 'HC-2024-457',
                        'issueDate' => '2024-03-17',
                        'expiryDate' => '2024-03-24',
                        'issuingAuthority' => 'State Veterinary Board',
                    ],
                ],
                'placement' => [
                    'arrivalDate' => '2024-03-19',
                    'placementDate' => '2024-03-20',
                    'quantity' => 12000,
                    'location' => [
                        'house' => 'House B-2',
                        'section' => 'South Wing',
                        'capacity' => 15000,
                    ],
                    'conditions' => [
                        'temperature' => '30°C',
                        'humidity' => '70%',
                        'ventilation' => 'Optimal',
                        'lighting' => '22 hours',
                    ],
                ],
                'initialMetrics' => [
                    'totalBirdsPlaced' => 12000,
                    'averageWeight' => '38g',
                    'uniformity' => '93%',
                    'mortalityRate' => '0.7%',
                    'expectedYield' => [
                        'targetWeight' => '2.3kg',
                        'expectedFCR' => '1.70',
                        'projectedMargin' => '18%',
                    ],
                    'growthTargets' => [
                        'week1' => '175g',
                        'week2' => '450g',
                        'week3' => '900g',
                        'week4' => '1500g',
                        'week5' => '2200g',
                        'week6' => '2400g',
                    ],
                ],
                'currentStatus' => [
                    'asOf' => '2024-04-10',
                    'liveBirdCount' => 11800,
                    'mortality' => [
                        'total' => 200,
                        'week1' => 50,
                        'week2' => 60,
                        'week3' => 90,
                    ],
                    'culling' => [
                        'total' => 40,
                        'reasons' => [
                            'runts' => 15,
                            'deformities' => 10,
                            'injuries' => 15,
                        ],
                    ],
                    'growthStatus' => [
                        'currentWeight' => '1450g',
                        'uniformity' => '90%',
                        'fcr' => '1.72',
                        'dailyGain' => '60g',
                    ],
                ],
                'harvestPlanning' => [
                    'expectedDate' => '2024-09-28',
                    'marketPreparation' => [
                        'withdrawalStart' => '2024-04-26',
                        'catchingTime' => '23:00',
                        'transportArrangements' => 'Confirmed',
                    ],
                    'processingSchedule' => [
                        'date' => '2024-04-28',
                        'shift' => 'Morning',
                        'processingPlant' => 'Main Plant - Line 1',
                        'capacityAllocated' => '12,000 birds',
                    ],
                    'targetMetrics' => [
                        'weight' => '2.3kg ± 200g',
                        'grade' => 'A',
                        'yield' => '70%',
                    ],
                    'marketDemand' => [
                        'buyer' => 'Fresh Market',
                        'productType' => 'Whole Bird',
                        'pricePerKg' => '$3.10',
                        'orderQuantity' => '10000 birds',
                    ],
                ],
                'status' => 'active',
            ],
        ];
    }
}; ?>

<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="md:flex md:items-center md:justify-between mb-6">
            <div class="min-w-0 flex-1">
                <h2
                    class="text-2xl font-bold leading-7 text-gray-900 dark:text-white sm:truncate sm:text-3xl sm:tracking-tight">
                    Batch Management
                </h2>
            </div>
            <div class="mt-4 flex md:ml-4 md:mt-0">
                <button type="button"
                    class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Add New Batch
                </button>
            </div>
        </div>

        <!-- Batch Cards -->
        @foreach ($batches as $batch)
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg divide-y divide-gray-200 dark:divide-gray-700 mb-6">
                <!-- Batch Header -->
                <div class="px-4 py-5 sm:px-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">
                                Batch #{{ $batch['id'] }}
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">
                                {{ $batch['birdType'] }} - {{ $batch['breed'] }}
                            </p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span
                                class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-sm font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                {{ $batch['status'] }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Key Metrics Summary -->
                <div class="px-4 py-5 sm:p-6 bg-gray-50 dark:bg-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Current Birds</dt>
                            <dd class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">
                                {{ number_format($batch['currentStatus']['liveBirdCount']) }}
                            </dd>
                        </div>
                        <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Current Weight</dt>
                            <dd class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">
                                {{ $batch['currentStatus']['growthStatus']['currentWeight'] }}
                            </dd>
                        </div>
                        <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">FCR</dt>
                            <dd class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">
                                {{ $batch['currentStatus']['growthStatus']['fcr'] }}
                            </dd>
                        </div>
                        <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Days to Harvest</dt>
                            <dd class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">
                                {{ floor(Carbon::parse($batch['harvestPlanning']['expectedDate'])->diffInDays(Carbon::now())) }}
                            </dd>
                        </div>
                    </div>
                </div>

                <!-- Detailed Information -->
                <div class="px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Placement Information -->
                        <div class="space-y-4">
                            <h4 class="text-lg font-medium text-gray-900 dark:text-white">Placement Details</h4>
                            <dl class="space-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Arrival Date</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                        {{ $batch['placement']['arrivalDate'] }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Location</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                        {{ $batch['placement']['location']['house'] }} -
                                        {{ $batch['placement']['location']['section'] }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Conditions</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                        Temp: {{ $batch['placement']['conditions']['temperature'] }},
                                        Humidity: {{ $batch['placement']['conditions']['humidity'] }}
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Current Status -->
                        <div class="space-y-4">
                            <h4 class="text-lg font-medium text-gray-900 dark:text-white">Current Status</h4>
                            <dl class="space-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Mortality</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                        Total: {{ $batch['currentStatus']['mortality']['total'] }} birds
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Growth Status</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                        Daily Gain: {{ $batch['currentStatus']['growthStatus']['dailyGain'] }},
                                        Uniformity: {{ $batch['currentStatus']['growthStatus']['uniformity'] }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Culling</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                        Total: {{ $batch['currentStatus']['culling']['total'] }} birds
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Harvest Planning -->
                        <div class="space-y-4">
                            <h4 class="text-lg font-medium text-gray-900 dark:text-white">Harvest Planning</h4>
                            <dl class="space-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Market Details</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                        {{ $batch['harvestPlanning']['marketDemand']['buyer'] }} -
                                        {{ $batch['harvestPlanning']['marketDemand']['productType'] }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Processing</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                        {{ $batch['harvestPlanning']['processingSchedule']['date'] }} -
                                        {{ $batch['harvestPlanning']['processingSchedule']['shift'] }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Target Metrics</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                        Weight: {{ $batch['harvestPlanning']['targetMetrics']['weight'] }},
                                        Grade: {{ $batch['harvestPlanning']['targetMetrics']['grade'] }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="px-4 py-4 sm:px-6 bg-gray-50 dark:bg-gray-900">
                    <div class="flex justify-end space-x-3">
                        <button type="button"
                            class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                            Update Status
                        </button>
                        <button type="button"
                            class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-500 hover:bg-gray-50">
                            View Details
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
