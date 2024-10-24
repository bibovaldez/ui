<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;
use Carbon\Carbon;

new
#[Layout('layouts.app')]
#[Title('Flock Management')]
class extends Component {
    public $flocks = [];
    public $selectedFlock = null;
    public $dailyData = [];
    public $dateRange = 7; // Days of data to show
    
    public function mount()
    {
        // Sample flock data
        $this->flocks = [
            [
                'id' => 1,
                'name' => 'Batch A-2024',
                'breed' => 'Broiler',
                'initial_count' => 1000,
                'current_count' => 985,
                'age_in_days' => 21,
                'entry_date' => '2024-10-03',
                'health_status' => 'Healthy',
                'next_vaccination' => '2024-11-01',
            ],
            [
                'id' => 2,
                'name' => 'Batch B-2024',
                'breed' => 'Layer',
                'initial_count' => 800,
                'current_count' => 792,
                'age_in_days' => 15,
                'entry_date' => '2024-10-09',
                'health_status' => 'Under Observation',
                'next_vaccination' => '2024-10-28',
            ]
        ];

        // Generate sample daily monitoring data
        $this->generateDailyData();
    }

    public function generateDailyData()
    {
        $this->dailyData = [];
        foreach ($this->flocks as $flock) {
            $this->dailyData[$flock['id']] = [];
            
            for ($i = 0; $i < $this->dateRange; $i++) {
                $date = Carbon::now()->subDays($i);
                $avgWeight = 42 + ($flock['age_in_days'] - $i) * 1.8 + rand(-5, 5) / 10;
                $mortality = rand(0, 2);
                
                $this->dailyData[$flock['id']][] = [
                    'date' => $date->format('Y-m-d'),
                    'mortality' => $mortality,
                    'feed_consumption' => round(($avgWeight * 0.1 * ($flock['current_count'] + $mortality)) + rand(-10, 10), 2),
                    'water_consumption' => round(($avgWeight * 0.2 * ($flock['current_count'] + $mortality)) + rand(-20, 20), 2),
                    'average_weight' => $avgWeight,
                    'growth_rate' => round($avgWeight - (42 + ($flock['age_in_days'] - $i - 1) * 1.8), 2),
                    'medication' => $i === 2 ? 'Vitamin supplement' : null,
                ];
            }
        }
    }

    public function selectFlock($id)
    {
        $this->selectedFlock = $id;
    }

    public function getMortalityRate($flockId)
    {
        $flock = collect($this->flocks)->firstWhere('id', $flockId);
        return round((($flock['initial_count'] - $flock['current_count']) / $flock['initial_count']) * 100, 2);
    }

    public function getHealthStatusColor($status)
    {
        return match($status) {
            'Healthy' => 'green',
            'Under Observation' => 'yellow',
            'Critical' => 'red',
            default => 'gray'
        };
    }
}; ?>

<div>
    <div class="py-2">
        <div class="max-w-full mx-0 sm:px-6 lg:px-0">
            <!-- Flock Selection -->
            <div class="mb-6">
                <div class="flex space-x-4">
                    @foreach($flocks as $flock)
                    <button 
                        wire:click="selectFlock({{ $flock['id'] }})"
                        class="px-4 py-2 rounded-lg {{ $selectedFlock === $flock['id'] ? 'bg-blue-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300' }} shadow-sm hover:bg-blue-500 hover:text-white transition-colors">
                        {{ $flock['name'] }}
                    </button>
                    @endforeach
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                @foreach($flocks as $flock)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">{{ $flock['name'] }}</h3>
                    <div class="mt-2 space-y-2">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Current Count: <span class="font-semibold">{{ $flock['current_count'] }}</span>
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Age: <span class="font-semibold">{{ $flock['age_in_days'] }} days</span>
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Mortality Rate: <span class="font-semibold text-red-600">{{ $this->getMortalityRate($flock['id']) }}%</span>
                        </p>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Status:</span>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $this->getHealthStatusColor($flock['health_status']) }}-100 text-{{ $this->getHealthStatusColor($flock['health_status']) }}-800">
                                {{ $flock['health_status'] }}
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Daily Monitoring Table -->
            @if($selectedFlock)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">Daily Monitoring - {{ collect($flocks)->firstWhere('id', $selectedFlock)['name'] }}</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Mortality</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Feed (kg)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Water (L)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Avg Weight (g)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Growth Rate (g)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Medication</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-800">
                                @foreach($dailyData[$selectedFlock] as $day)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ date('M d, Y', strtotime($day['date'])) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600 font-semibold">
                                        {{ $day['mortality'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $day['feed_consumption'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $day['water_consumption'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $day['average_weight'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm {{ $day['growth_rate'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $day['growth_rate'] > 0 ? '+' : '' }}{{ $day['growth_rate'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $day['medication'] ?? '-' }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <!-- Vaccination Schedule -->
            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">Upcoming Vaccinations</h2>
                    <div class="space-y-4">
                        @foreach($flocks as $flock)
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white">{{ $flock['name'] }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-300">Next vaccination: {{ date('M d, Y', strtotime($flock['next_vaccination'])) }}</p>
                            </div>
                            <span class="px-4 py-2 text-sm font-semibold rounded-full {{ Carbon::parse($flock['next_vaccination'])->isPast() ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                {{ Carbon::parse($flock['next_vaccination'])->isPast() ? 'Overdue' : 'Scheduled' }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>