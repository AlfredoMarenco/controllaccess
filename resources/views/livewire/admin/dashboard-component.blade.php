<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="grid sm:grid-cols-1 lg:grid-cols-2 gap-2 place-content-center">
                    <div style="height: 35rem;">
                        <livewire:livewire-pie-chart :pie-chart-model="$pieChartOcupation" />
                    </div>
                    <div style="height: 35rem;">
                        <livewire:livewire-column-chart :column-chart-model="$pieChartForSections" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
