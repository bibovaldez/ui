<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;
 
new
#[Layout('layouts.app')]       // <-- Here is the `empty` layout
#[Title('Login')]
class extends Component {
    //
}; ?>

<div>
    <div class="py-2">
        <div class="max-w-full mx-0 sm:px-6 lg:px-0">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                
                <x-welcome />
            </div>
        </div>
    </div>
</div>
