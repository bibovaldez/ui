<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body class="min-h-screen font-sans antialiased bg-base-200/50 dark:bg-base-200">
    <x-banner />

      {{-- NAVBAR mobile only --}}
      <x-mary-nav sticky class="lg:hidden">
        <x-slot:actions>
            <label for="main-drawer" class="lg:hidden mr-3">
                <x-mary-icon name="o-bars-3" class="cursor-pointer" />
            </label>
        </x-slot:actions>
    </x-mary-nav>

    <x-mary-main full-width>
        <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100 lg:bg-inherit scrollbar-thin" right-mobile>

            {{-- BRAND AND TOGGLE THEME --}}
            <div class="flex items-center justify-between">
                <div class="ml-5 pt-5">Sagitarian Phil.Inc.</div>
                <x-mary-theme-toggle class="mr-5 pt-5" />
            </div>


            {{-- MENU --}}
            <x-mary-menu activate-by-route>

                {{-- User --}}
                @if ($user = auth()->user())
                    <x-mary-menu-separator />

                    <x-mary-list-item :item="$user" value="name" sub-value="email" no-separator no-hover
                        class="-mx-2 !-my-2 rounded">
                        <x-slot:actions>
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <x-mary-button icon="o-power" class="btn-circle btn-ghost btn-xs" tooltip="Logoff"
                                    tooltip-placement="left" @click.prevent="$root.submit()" no-wire-navigate />
                            </form>
                        </x-slot:actions>
                    </x-mary-list-item>

                    <x-mary-menu-separator />
                @endif
                {{-- <x-mary-menu-item title="Dashboard" icon="o-envelope" link="{{ route('dashboard') }}" /> --}}

                {{-- poultry --}}
                {{-- <x-mary-menu-sub title="Poultry" icon="healthicons.o-animal-chicken"> --}}
                    <x-mary-menu-item title="Building Management" icon="far.building" link="{{ route('building-management') }}" />

                    
                    <x-mary-menu-item title="Batch Information" icon="o-information-circle" link="{{ route('batch-information') }}" />
                   
                    <x-mary-menu-item title="Flock Management" icon="o-archive-box" link="{{ route('flock-management') }}" />
                    <x-mary-menu-item title="Inventory Management" icon="o-folder-open" link="{{ route('inventory-management') }}" />
                    <x-mary-menu-item title="Logistics" icon="iconpark.transporter-o" link="{{ route('logistics') }}" />
                    <x-mary-menu-item title="Production Metrics" icon="m-chart-pie" link="{{ route('production-metrics') }}" />
                    <x-mary-menu-item title="Reports" icon="fas.headset" link="{{ route('report') }}" />
                    <x-mary-menu-item title="Supply Chain" icon="fas.box" link="####" />
                    <x-mary-menu-item title="Utilities" icon="healthicons.o-electricity" link="####" />
                {{-- </x-mary-menu-sub> --}}

             
                <x-mary-menu-item title="Messages" icon="o-envelope" link="####" />
                <x-mary-menu-item title="Notifications" icon="o-bell" link="####" />

                <x-mary-menu-sub title="Settings" icon="o-cog-6-tooth">
                    <x-mary-menu-item title="Wifi" icon="o-wifi" link="####" />
                    <x-mary-menu-item title="Archives" icon="o-archive-box" link="####" />
                </x-mary-menu-sub>
            </x-mary-menu>
        </x-slot:sidebar>

        <x-slot name="content" class="bg-base-1000 lg:bg-inherit scrollbar-thin">
            {{ $slot }}
        </x-slot>
    </x-mary-main>

    <x-mary-toast />

    @stack('modals')
    @push('scripts')
    @livewireScripts
</body>

</html>
