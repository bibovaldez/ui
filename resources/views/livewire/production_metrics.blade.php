<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;
use Carbon\Carbon;

new
#[Layout('layouts.app')]       // <-- Here is the `empty` layout
#[Title('Login')]
class extends Component 
{
    // Form Properties for Daily Collection
    #[Rule('required|date')]
    public $collectionDate;

    // Egg Production Metrics
    #[Rule('integer|min:0')]
    public $totalEggs = 0;

    #[Rule('integer|min:0')]
    public $gradeAEggs = 0;

    #[Rule('integer|min:0')]
    public $gradeBEggs = 0;

    #[Rule('integer|min:0')]
    public $gradeCEggs = 0;

    #[Rule('integer|min:0')]
    public $brokenEggs = 0;

    #[Rule('integer|min:0')]
    public $rejectedEggs = 0;

    // Meat Production Metrics
    #[Rule('numeric|min:0')]
    public $avgLiveWeight = 0;

    #[Rule('numeric|min:0')]
    public $feedConversionRatio = 0;

    #[Rule('numeric|min:0')]
    public $avgDailyGain = 0;

    #[Rule('numeric|min:0')]
    public $totalFeedConsumed = 0;

    public $selectedBatch = null;
    public $productionType = 'egg'; // 'egg' or 'meat'

    // Initialize with sample data
    public function with(): array
    {
        return [
            'dailyMetrics' => $this->getSampleMetrics(),
            'batches' => $this->getSampleBatches(),
            'weeklyStats' => $this->getWeeklyStats(),
        ];
    }

    // Sample Batches
    private function getSampleBatches()
    {
        return [
            ['id' => 1, 'name' => 'Batch A-101', 'type' => 'layer'],
            ['id' => 2, 'name' => 'Batch B-202', 'type' => 'broiler'],
        ];
    }

    // Sample Daily Metrics
    private function getSampleMetrics()
    {
        return [
            [
                'date' => '2024-10-23',
                'batch_id' => 1,
                'type' => 'layer',
                'metrics' => [
                    'total_eggs' => 950,
                    'grade_a' => 800,
                    'grade_b' => 100,
                    'grade_c' => 30,
                    'broken' => 15,
                    'rejected' => 5,
                ]
            ],
            [
                'date' => '2024-10-23',
                'batch_id' => 2,
                'type' => 'broiler',
                'metrics' => [
                    'avg_live_weight' => 2.5,
                    'fcr' => 1.65,
                    'adg' => 0.085,
                    'feed_consumed' => 450,
                ]
            ],
        ];
    }

    // Calculate Weekly Stats
    private function getWeeklyStats()
    {
        // Sample weekly statistics
        return [
            'egg' => [
                'total_production' => 6650,
                'avg_daily_production' => 950,
                'quality_rate' => 94.5,
                'rejection_rate' => 5.5,
            ],
            'meat' => [
                'avg_weight_gain' => 0.595,
                'avg_fcr' => 1.68,
                'mortality_rate' => 0.5,
                'feed_efficiency' => 92.5,
            ],
        ];
    }

    // Save Daily Collection
    public function saveCollection()
    {
        $this->validate();
        
        // Here you would typically save to database
        // For now, we'll just reset the form
        
        $this->dispatch('collection-saved');
        $this->reset(['totalEggs', 'gradeAEggs', 'gradeBEggs', 'gradeCEggs', 'brokenEggs', 'rejectedEggs', 
                     'avgLiveWeight', 'feedConversionRatio', 'avgDailyGain', 'totalFeedConsumed']);
    }

    // Switch Production Type
    public function switchProductionType($type)
    {
        $this->productionType = $type;
        $this->reset(['selectedBatch']);
    }

    // Select Batch
    public function selectBatch($batchId)
    {
        $this->selectedBatch = $batchId;
    }
}; ?>

<div>
    <div class="py-2">
        <div class="max-w-full mx-0 sm:px-6 lg:px-0">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Production Type Switch -->
                    <div class="flex space-x-4 mb-6">
                        <button 
                            wire:click="switchProductionType('egg')" 
                            class="px-4 py-2 rounded-md {{ $productionType === 'egg' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700' }}"
                        >
                            Egg Production
                        </button>
                        <button 
                            wire:click="switchProductionType('meat')" 
                            class="px-4 py-2 rounded-md {{ $productionType === 'meat' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700' }}"
                        >
                            Meat Production
                        </button>
                    </div>

                    <!-- Weekly Summary Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                        @if($productionType === 'egg')
                            <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-4">
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Weekly Production</h3>
                                <p class="text-2xl font-semibold">{{ number_format($weeklyStats['egg']['total_production']) }} eggs</p>
                            </div>
                            <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-4">
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Avg. Daily Production</h3>
                                <p class="text-2xl font-semibold">{{ number_format($weeklyStats['egg']['avg_daily_production']) }} eggs</p>
                            </div>
                            <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-4">
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Quality Rate</h3>
                                <p class="text-2xl font-semibold">{{ $weeklyStats['egg']['quality_rate'] }}%</p>
                            </div>
                            <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-4">
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Rejection Rate</h3>
                                <p class="text-2xl font-semibold">{{ $weeklyStats['egg']['rejection_rate'] }}%</p>
                            </div>
                        @else
                            <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-4">
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Avg. Weight Gain</h3>
                                <p class="text-2xl font-semibold">{{ $weeklyStats['meat']['avg_weight_gain'] }} kg/day</p>
                            </div>
                            <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-4">
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Avg. FCR</h3>
                                <p class="text-2xl font-semibold">{{ $weeklyStats['meat']['avg_fcr'] }}</p>
                            </div>
                            <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-4">
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Mortality Rate</h3>
                                <p class="text-2xl font-semibold">{{ $weeklyStats['meat']['mortality_rate'] }}%</p>
                            </div>
                            <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-4">
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Feed Efficiency</h3>
                                <p class="text-2xl font-semibold">{{ $weeklyStats['meat']['feed_efficiency'] }}%</p>
                            </div>
                        @endif
                    </div>

                    <!-- Daily Collection Form -->
                    <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-6 mb-6">
                        <h2 class="text-xl font-semibold mb-4">Daily Collection Entry</h2>
                        
                        <form wire:submit="saveCollection" class="space-y-6">
                            <!-- Common Fields -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date</label>
                                    <input type="date" wire:model="collectionDate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Batch</label>
                                    <select wire:model="selectedBatch" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Select Batch</option>
                                        @foreach($batches as $batch)
                                            @if($batch['type'] === ($productionType === 'egg' ? 'layer' : 'broiler'))
                                                <option value="{{ $batch['id'] }}">{{ $batch['name'] }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            @if($productionType === 'egg')
                                <!-- Egg Production Fields -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Total Eggs</label>
                                        <input type="number" wire:model="totalEggs" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Grade A Eggs</label>
                                        <input type="number" wire:model="gradeAEggs" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Grade B Eggs</label>
                                        <input type="number" wire:model="gradeBEggs" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Grade C Eggs</label>
                                        <input type="number" wire:model="gradeCEggs" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Broken Eggs</label>
                                        <input type="number" wire:model="brokenEggs" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rejected Eggs</label>
                                        <input type="number" wire:model="rejectedEggs" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                </div>
                            @else
                                <!-- Meat Production Fields -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Average Live Weight (kg)</label>
                                        <input type="number" step="0.01" wire:model="avgLiveWeight" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Feed Conversion Ratio (FCR)</label>
                                        <input type="number" step="0.01" wire:model="feedConversionRatio" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Average Daily Gain (kg)</label>
                                        <input type="number" step="0.001" wire:model="avgDailyGain" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Total Feed Consumed (kg)</label>
                                        <input type="number" step="0.01" wire:model="totalFeedConsumed" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                </div>
                            @endif

                            <div>
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md">Save Collection</button>
                            </div>
                        </form>
                    </div>

                    <!-- Daily Metrics Table -->
                    <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-6">
                        <h2 class="text-xl font-semibold mb-4">Daily Metrics</h2>
                        <table class="w-full border-collapse">
                            <thead>
                                <tr>
                                    <th class="border-b border-gray-200 dark:border-gray-600">Date</th>
                                    <th class="border-b border-gray-200 dark:border-gray-600">Batch</th>
                                    @if($productionType === 'egg')
                                        <th class="border-b border-gray-200 dark:border-gray-600">Total Eggs</th>
                                        <th class="border-b border-gray-200 dark:border-gray-600">Grade A</th>
                                        <th class="border-b border-gray-200 dark:border-gray-600">Grade B</th>
                                        <th class="border-b border-gray-200 dark:border-gray-600">Grade C</th>
                                        <th class="border-b border-gray-200 dark:border-gray-600">Broken</th>
                                        <th class="border-b border-gray-200 dark:border-gray-600">Rejected</th>
                                    @else
                                        <th class="border-b border-gray-200 dark:border-gray-600">Avg. Live Weight</th>
                                        <th class="border-b border-gray-200 dark:border-gray-600">FCR</th>
                                        <th class="border-b border-gray-200 dark:border-gray-600">ADG</th>
                                        <th class="border-b border-gray-200 dark:border-gray-600">Feed Consumed</th>
                                    @endif
                                </tr>
                            </thead>
                            {{-- <tbody>
                                @foreach($dailyMetrics as $metric)
                                    <tr>
                                        <td class="border-b border-gray-200 dark:border-gray-600">{{ Carbon::parse($metric['date'])->format('M d, Y') }}</td>
                                        <td class="border-b border-gray-200 dark:border-gray-600">{{ $batches[$metric['batch_id'] - 1]['name'] }}</td>
                                        @if($productionType === 'egg')
                                            <td class="border-b border-gray-200 dark:border-gray-600">{{ $metric['metrics']['total_eggs'] }}</td>
                                            <td class="border-b border-gray-200 dark:border-gray-600">{{ $metric['metrics']['grade_a'] }}</td>
                                            <td class="border-b border-gray-200 dark:border-gray-600">{{ $metric['metrics']['grade_b'] }}</td>
                                            <td class="border-b border-gray-200 dark:border-gray-600">{{ $metric['metrics']['grade_c'] }}</td>
                                            <td class="border-b border-gray-200 dark:border-gray-600">{{ $metric['metrics']['broken'] }}</td>
                                            <td class="border-b border-gray-200 dark:border-gray-600">{{ $metric['metrics']['rejected'] }}</td>
                                        @else
                                            <td class="border-b border-gray-200 dark:border-gray-600">{{ $metric['metrics']['avg_live_weight'] }}</td>
                                            <td class="border-b border-gray-200 dark:border-gray-600">{{ $metric['metrics']['fcr'] }}</td>
                                            <td class="border-b border-gray-200 dark:border-gray-600">{{ $metric['metrics']['adg'] }}</td>
                                            <td class="border-b border-gray-200 dark:border-gray-600">{{ $metric['metrics']['feed_consumed'] }}</td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody> --}}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
