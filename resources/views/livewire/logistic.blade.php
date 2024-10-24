<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

new 
#[Layout('layouts.app')]
#[Title('Logistics Dashboard')]
class extends Component {
    public $activeTab = 'deliveries';
    
    // Sample data - In production, this would come from your database
    public $deliverySchedules = [
        [
            'id' => 1,
            'supplier' => 'Sagitarian',
            'delivery_date' => '2024-10-25',
            'status' => 'Pending',
            'items' => 5,
        ],
        [
            'id' => 2,
            'supplier' => 'Chooks to Go',
            'delivery_date' => '2024-10-26',
            'status' => 'In Transit',
            'items' => 3,
        ],
    ];
    
    public $customerOrders = [
        [
            'id' => 1,
            'customer' => 'angkel ben',
            'order_date' => '2024-10-24',
            'status' => 'Processing',
            'total_items' => 2,
        ],
        [
            'id' => 2,
            'customer' => 'Mang Jose',
            'order_date' => '2024-10-23',
            'status' => 'Shipped',
            'total_items' => 4,
        ],
    ];
    
    public $inventory = [
        [
            'id' => 1,
            'product' => 'Feeds starter',
            'stock' => 1003,
            'reorder_level' => 50,
            'status' => 'In Stock',
        ],
        [
            'id' => 2,
            'product' => 'Feeds grower',
            'stock' => 500,
            'reorder_level' => 45,
            'status' => 'Low Stock',
        ],
    ];
    
    public function setActiveTab($tab) {
        $this->activeTab = $tab;
    }
}; ?>

<div class="p-6">
    <!-- Dashboard Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Logistics Dashboard</h1>
    </div>

    <!-- Navigation Tabs -->
    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center">
            <li class="mr-2">
                <button wire:click="setActiveTab('deliveries')" 
                    class="inline-block p-4 rounded-t-lg {{ $activeTab === 'deliveries' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-500' }}">
                    Delivery Schedules
                </button>
            </li>
            <li class="mr-2">
                <button wire:click="setActiveTab('orders')"
                    class="inline-block p-4 rounded-t-lg {{ $activeTab === 'orders' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-500' }}">
                    Customer Orders
                </button>
            </li>
            <li class="mr-2">
                <button wire:click="setActiveTab('inventory')"
                    class="inline-block p-4 rounded-t-lg {{ $activeTab === 'inventory' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-500' }}">
                    Inventory Status
                </button>
            </li>
        </ul>
    </div>

    <!-- Content Sections -->
    <div class="mt-6">
        <!-- Delivery Schedules -->
        @if($activeTab === 'deliveries')
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Supplier</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Delivery Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Items</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($deliverySchedules as $schedule)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $schedule['id'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $schedule['supplier'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $schedule['delivery_date'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $schedule['status'] === 'Pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                {{ $schedule['status'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $schedule['items'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        <!-- Customer Orders -->
        @if($activeTab === 'orders')
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Items</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($customerOrders as $order)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $order['id'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $order['customer'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $order['order_date'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $order['status'] === 'Processing' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                {{ $order['status'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $order['total_items'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        <!-- Inventory Status -->
        @if($activeTab === 'inventory')
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock Level</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reorder Level</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($inventory as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item['id'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item['product'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item['stock'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item['reorder_level'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $item['status'] === 'Low Stock' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                {{ $item['status'] }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>