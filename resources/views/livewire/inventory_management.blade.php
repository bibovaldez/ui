<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;
use Carbon\Carbon;

new
#[Layout('layouts.app')]
#[Title('Feed Inventory Management')]
class extends Component {
    public $feedTypes = [];
    public $suppliers = [];
    public $consumptionHistory = [];
    public $selectedFeedType = null;
    public $showLowStock = false;
    
    public function mount()
    {
        // Sample suppliers data
        $this->suppliers = [
            1 => [
                'id' => 1,
                'name' => 'Premium Feed Co.',
                'contact' => 'John Smith',
                'phone' => '(555) 123-4567',
                'email' => 'john@premiumfeed.com',
                'rating' => 4.8,
                'last_delivery' => '2024-10-15',
            ],
            2 => [
                'id' => 2,
                'name' => 'Quality Feeds Ltd.',
                'contact' => 'Sarah Johnson',
                'phone' => '(555) 987-6543',
                'email' => 'sarah@qualityfeeds.com',
                'rating' => 4.5,
                'last_delivery' => '2024-10-18',
            ],
        ];

        // Sample feed types data
        $this->feedTypes = [
            [
                'id' => 1,
                'name' => 'Starter Feed',
                'type' => 'Crumble',
                'current_stock' => 2500,
                'reorder_level' => 1000,
                'unit' => 'kg',
                'cost_per_unit' => 0.85,
                'supplier_id' => 1,
                'protein_content' => '22%',
                'energy_content' => '3100 kcal/kg',
                'last_quality_check' => '2024-10-20',
                'quality_score' => 95,
                'expiry_date' => '2024-12-15',
            ],
            [
                'id' => 2,
                'name' => 'Grower Feed',
                'type' => 'Pellet',
                'current_stock' => 800,
                'reorder_level' => 1200,
                'unit' => 'kg',
                'cost_per_unit' => 0.78,
                'supplier_id' => 2,
                'protein_content' => '20%',
                'energy_content' => '3050 kcal/kg',
                'last_quality_check' => '2024-10-19',
                'quality_score' => 92,
                'expiry_date' => '2024-12-20',
            ],
            [
                'id' => 3,
                'name' => 'Finisher Feed',
                'type' => 'Pellet',
                'current_stock' => 1800,
                'reorder_level' => 1000,
                'unit' => 'kg',
                'cost_per_unit' => 0.72,
                'supplier_id' => 1,
                'protein_content' => '18%',
                'energy_content' => '3200 kcal/kg',
                'last_quality_check' => '2024-10-18',
                'quality_score' => 94,
                'expiry_date' => '2024-12-25',
            ],
        ];

        // Generate sample consumption history
        $this->generateConsumptionHistory();
    }

    public function generateConsumptionHistory()
    {
        $this->consumptionHistory = [];
        foreach ($this->feedTypes as $feed) {
            $this->consumptionHistory[$feed['id']] = [];
            
            for ($i = 0; $i < 7; $i++) {
                $date = Carbon::now()->subDays($i);
                $baseConsumption = match($feed['name']) {
                    'Starter Feed' => 250,
                    'Grower Feed' => 350,
                    'Finisher Feed' => 400,
                    default => 300,
                };
                
                $this->consumptionHistory[$feed['id']][] = [
                    'date' => $date->format('Y-m-d'),
                    'consumption' => $baseConsumption + rand(-20, 20),
                    'wastage' => rand(1, 5),
                ];
            }
        }
    }

    public function getStockStatus($currentStock, $reorderLevel)
    {
        if ($currentStock <= $reorderLevel) {
            return ['color' => 'red', 'text' => 'Low Stock'];
        } elseif ($currentStock <= $reorderLevel * 1.5) {
            return ['color' => 'yellow', 'text' => 'Medium Stock'];
        } else {
            return ['color' => 'green', 'text' => 'Good Stock'];
        }
    }

    public function toggleLowStock()
    {
        $this->showLowStock = !$this->showLowStock;
    }

    public function getQualityScoreColor($score)
    {
        if ($score >= 90) return 'green';
        if ($score >= 80) return 'yellow';
        return 'red';
    }
}; ?>

<div>
    <div class="py-2">
        <div class="max-w-full mx-0 sm:px-6 lg:px-0">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Total Feed Stock</h3>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">
                        {{ number_format(array_sum(array_column($feedTypes, 'current_stock'))) }} kg
                    </p>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Low Stock Items</h3>
                    <p class="text-3xl font-bold text-red-600">
                        {{ count(array_filter($feedTypes, fn($feed) => $feed['current_stock'] <= $feed['reorder_level'])) }}
                    </p>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Average Quality Score</h3>
                    <p class="text-3xl font-bold text-blue-600">
                        {{ round(array_sum(array_column($feedTypes, 'quality_score')) / count($feedTypes), 1) }}%
                    </p>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Total Value</h3>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">
                        ${{ number_format(array_sum(array_map(fn($feed) => $feed['current_stock'] * $feed['cost_per_unit'], $feedTypes)), 2) }}
                    </p>
                </div>
            </div>

            <!-- Filter Controls -->
            <div class="mb-6 flex justify-between items-center">
                <button wire:click="toggleLowStock"
                    class="px-4 py-2 rounded-lg bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 shadow-sm hover:bg-red-50 transition-colors">
                    {{ $showLowStock ? 'Show All Stock' : 'Show Low Stock Only' }}
                </button>
            </div>

            <!-- Feed Inventory Table -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">Feed Inventory</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Feed Name</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Type</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Current Stock</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Quality</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Supplier</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Cost/Unit</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Expiry</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-800">
                                @foreach ($feedTypes as $feed)
                                    @if (!$showLowStock || ($showLowStock && $feed['current_stock'] <= $feed['reorder_level']))
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $feed['name'] }}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $feed['protein_content'] }} protein |
                                                    {{ $feed['energy_content'] }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-500 dark:text-gray-300">
                                                    {{ $feed['type'] }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php $status = $this->getStockStatus($feed['current_stock'], $feed['reorder_level']) @endphp
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ number_format($feed['current_stock']) }} {{ $feed['unit'] }}
                                                </div>
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $status['color'] }}-100 text-{{ $status['color'] }}-800">
                                                    {{ $status['text'] }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $this->getQualityScoreColor($feed['quality_score']) }}-100 text-{{ $this->getQualityScoreColor($feed['quality_score']) }}-800">
                                                    {{ $feed['quality_score'] }}%
                                                </span>
                                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                    Checked: {{ date('M d', strtotime($feed['last_quality_check'])) }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $suppliers[$feed['supplier_id']]['name'] }}
                                                </div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    Last delivery:
                                                    {{ date('M d', strtotime($suppliers[$feed['supplier_id']]['last_delivery'])) }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    ${{ number_format($feed['cost_per_unit'], 2) }}/{{ $feed['unit'] }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div
                                                    class="text-sm {{ Carbon::parse($feed['expiry_date'])->diffInDays(now()) < 30 ? 'text-red-600 font-semibold' : 'text-gray-500 dark:text-gray-300' }}">
                                                    {{ date('M d, Y', strtotime($feed['expiry_date'])) }}
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Daily Consumption Chart -->
            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">Daily Consumption History</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Date</th>
                                    @foreach ($feedTypes as $feed)
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            {{ $feed['name'] }} Consumption</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            {{ $feed['name'] }} Wastage</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-800">
                                @for ($i = 0; $i < 7; $i++)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ Carbon::now()->subDays($i)->format('Y-m-d') }}</div>
                                        </td>
                                        @foreach ($feedTypes as $feed)
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ number_format($consumptionHistory[$feed['id']][$i]['consumption']) }}
                                                    kg
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ number_format($consumptionHistory[$feed['id']][$i]['wastage']) }}
                                                    kg
                                                </div>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
