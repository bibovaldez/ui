<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

new #[Layout('layouts.app')]
    #[Title('Logistics Dashboard')] 
    class extends Component {
    
    public $activeTab = 'deliveries';
    
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
            'customer' => 'Angkel Ben',
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
            'product' => 'Feeds Starter',
            'stock' => 1003,
            'reorder_level' => 50,
            'status' => 'In Stock',
        ],
        [
            'id' => 2,
            'product' => 'Feeds Grower',
            'stock' => 500,
            'reorder_level' => 45,
            'status' => 'Low Stock',
        ],
    ];
    
    public function setActiveTab($tab) {
        $this->activeTab = $tab;
    }

    public function getStatusColor($status) {
        return match ($status) {
            'Pending' => 'yellow',
            'In Transit', 'Shipped' => 'blue',
            'Processing' => 'indigo',
            'Low Stock' => 'red',
            default => 'green',
        };
    }
}; ?>

<div class="p-6 space-y-6">
    <!-- Dashboard Header -->
    <header class="flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Logistics Dashboard</h1>
    </header>

    <!-- Navigation Tabs -->
    <nav class="border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center">
            <li class="mr-2">
                <button wire:click="setActiveTab('deliveries')" 
                    class="inline-block p-4 rounded-t-lg {{ $activeTab === 'deliveries' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-500 hover:text-gray-600' }}">
                    Delivery Schedules
                </button>
            </li>
            <li class="mr-2">
                <button wire:click="setActiveTab('orders')"
                    class="inline-block p-4 rounded-t-lg {{ $activeTab === 'orders' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-500 hover:text-gray-600' }}">
                    Customer Orders
                </button>
            </li>
            <li class="mr-2">
                <button wire:click="setActiveTab('inventory')"
                    class="inline-block p-4 rounded-t-lg {{ $activeTab === 'inventory' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-500 hover:text-gray-600' }}">
                    Inventory Status
                </button>
            </li>
        </ul>
    </nav>

    <!-- Content Section -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
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
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $schedule['id'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $schedule['supplier'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $schedule['delivery_date'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $this->getStatusColor($schedule['status']) }}-100 text-{{ $this->getStatusColor($schedule['status']) }}-800">
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
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $order['id'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $order['customer'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $order['order_date'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $this->getStatusColor($order['status']) }}-100 text-{{ $this->getStatusColor($order['status']) }}-800">
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
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item['id'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item['product'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item['stock'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item['reorder_level'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $this->getStatusColor($item['status']) }}-100 text-{{ $this->getStatusColor($item['status']) }}-800">
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