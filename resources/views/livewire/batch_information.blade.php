<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;
use Carbon\Carbon;

new #[Layout('layouts.app')] #[Title('Login')] class// <-- Here is the `empty` layout
 extends Component {
    // Form Properties
    #[Rule('required|string|max:50')]
    public $batchNumber = '';

    #[Rule('required|string|max:100')]
    public $breedType = '';

    #[Rule('required|integer|min:1')]
    public $initialQuantity = '';

    #[Rule('required|integer|min:0')]
    public $currentQuantity = '';

    #[Rule('required|date')]
    public $startDate = '';

    #[Rule('required|date|after:startDate')]
    public $expectedHarvestDate = '';

    #[Rule('required|string|max:200')]
    public $supplier = '';

    public $isEditing = false;
    public $editingId = null;

    // Sample Data
    public function with(): array
    {
        return [
            'batches' => $this->getSampleBatches(),
        ];
    }

    // Sample Batches Data
    private function getSampleBatches()
    {
        return [
            [
                'id' => 1,
                'batchNumber' => 'B2024-001',
                'breedType' => 'Broiler',
                'initialQuantity' => 1000,
                'currentQuantity' => 985,
                'startDate' => '2024-10-01',
                'expectedHarvestDate' => '2024-11-15',
                'supplier' => 'Premium Poultry Supplies Ltd.',
                'status' => 'Active',
            ],
            [
                'id' => 2,
                'batchNumber' => 'B2024-002',
                'breedType' => 'Layer',
                'initialQuantity' => 800,
                'currentQuantity' => 792,
                'startDate' => '2024-10-10',
                'expectedHarvestDate' => '2024-11-25',
                'supplier' => 'Farm Fresh Genetics Co.',
                'status' => 'Active',
            ],
        ];
    }

    // Form Submission
    public function saveBatch()
    {
        $this->validate();

        // Here you would typically save to database
        // For now, we'll just reset the form
        $this->reset();

        $this->dispatch('batch-saved');
    }

    // Edit Batch
    public function editBatch($batchId)
    {
        $batch = collect($this->getSampleBatches())->firstWhere('id', $batchId);
        if ($batch) {
            $this->isEditing = true;
            $this->editingId = $batchId;
            $this->batchNumber = $batch['batchNumber'];
            $this->breedType = $batch['breedType'];
            $this->initialQuantity = $batch['initialQuantity'];
            $this->currentQuantity = $batch['currentQuantity'];
            $this->startDate = $batch['startDate'];
            $this->expectedHarvestDate = $batch['expectedHarvestDate'];
            $this->supplier = $batch['supplier'];
        }
    }

    // Cancel Editing
    public function cancelEdit()
    {
        $this->isEditing = false;
        $this->editingId = null;
        $this->reset();
    }
}; ?>

<div class="">
    <div class="py-1">
        <div class="max-w-full mx-0 sm:px-6 lg:px-0">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 text-gray-900 dark:text-gray-100">


                    <!-- Batches Table -->
                    <div class="">
                        <h3 class="text-xl font-semibold mb-4">Current Batches</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Batch Number</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Breed Type</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Quantity (Current/Initial)</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Dates</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Status</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                    @foreach ($batches as $batch)
                                        <tr>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $batch['batchNumber'] }}</td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                {{ $batch['breedType'] }}</td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                {{ $batch['currentQuantity'] }}/{{ $batch['initialQuantity'] }}</td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                <div>Start: {{ $batch['startDate'] }}</div>
                                                <div>Harvest: {{ $batch['expectedHarvestDate'] }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    {{ $batch['status'] }}
                                                </span>
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                <button wire:click="editBatch({{ $batch['id'] }})"
                                                    class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Edit</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <x-mary-menu-separator />
                    <h2 class="text-2xl font-semibold mb-6">{{ $isEditing ? 'Edit Batch' : 'New Batch' }}</h2>

                    <!-- Batch Information Form -->
                    <form wire:submit="saveBatch" class="space-y-6 mt-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Batch Number -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Batch
                                    Number</label>
                                <input type="text" wire:model="batchNumber"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('batchNumber')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Breed Type -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Breed
                                    Type</label>
                                <input type="text" wire:model="breedType"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('breedType')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Initial Quantity -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Initial
                                    Quantity</label>
                                <input type="number" wire:model="initialQuantity"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('initialQuantity')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Current Quantity -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Current
                                    Quantity</label>
                                <input type="number" wire:model="currentQuantity"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('currentQuantity')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Start Date -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start
                                    Date</label>
                                <input type="date" wire:model="startDate"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('startDate')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Expected Harvest Date -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Expected
                                    Harvest Date</label>
                                <input type="date" wire:model="expectedHarvestDate"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('expectedHarvestDate')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Supplier -->
                            <div class="md:col-span-2">
                                <label
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Supplier</label>
                                <input type="text" wire:model="supplier"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('supplier')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3">
                            @if ($isEditing)
                                <button type="button" wire:click="cancelEdit"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                    Cancel
                                </button>
                            @endif
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ $isEditing ? 'Update Batch' : 'Create Batch' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
