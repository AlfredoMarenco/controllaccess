<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Administration') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4">
                @if ($boxs_view)
                    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3 px-6">
                                        Seccion
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Palco
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($boxs as $box)
                                    <tr class="{{ $loop->iteration % 2 ? 'bg-white' : 'bg-gray-50' }} border-b">
                                        <th scope="row"
                                            class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                            {{ $box->name }}
                                        </th>
                                        <td class="py-4 px-6">
                                            {{ $box->identifier }}
                                        </td>
                                        <td class="py-4 px-6">
                                            <a wire:click="showBox({{ $box }})"
                                                class="font-medium text-blue-600 hover:underline cursor-pointer">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="p-4">
                            {{ $boxs->links() }}
                        </div>
                    </div>
                @endif
                @if ($box_view)
                    <div class="flex justify-end items-center mt-4">
                        <x-jet-button>Agregar tarjeta</x-jet-button>
                    </div>
                    <div class="w-full px-4 py-4 my-4 shadow-xl bg-gray-300">
                        <div class="grid grid-cols-4 gap-2 mt-6">
                            @foreach ($box->codes as $seat)
                                <div wire:click="showSeat({{ $seat }})"
                                    class="flex justify-center items-center bg-green-600 hover:bg-green-800 text-white text-lg font-bold shadow-lg cursor-pointer">
                                    <p>{{ $seat->seat }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <x-jet-dialog-modal wire:model="seat_view">
                        <x-slot name="title">
                            {{-- {{ $seat->box->name }} {{ $seat->box->identifier }} - Tarjeta {{ $seat->row }} --}}
                        </x-slot>
                        <x-slot name="content">
                            <form wire:submit.prevent="" class="w-full">
                                <div class="w-full">
                                    <x-jet-label value="Section:" />
                                    <x-jet-input type="text" class="w-full bg-gray-100" wire:model="seatEdit.name"
                                        disabled />
                                </div>
                                <div class="w-full">
                                    <x-jet-label value="Palco:" />
                                    <x-jet-input type="text" class="w-full bg-gray-100"
                                        wire:model="seatEdit.identifier" disabled />
                                </div>
                                <div class="w-full">
                                    <x-jet-label value="Tarjeta:" />
                                    <x-jet-input type="text" class="w-full bg-gray-100" wire:model="seatEdit.seat"
                                        disabled />
                                </div>
                                <div class="w-full">
                                    <x-jet-label value="Codigo:" />
                                    <x-jet-input type="text" class="w-full" wire:model="seatEdit.barcode" />
                                </div>
                                <div class="w-full flex justify-end mt-4">
                                    <x-jet-danger-button class="text-xs">Eliminar Tarjeta</x-jet-danger-button>
                                </div>
                            </form>
                        </x-slot>
                        <x-slot name="footer">
                            <x-jet-secondary-button class="mr-4" wire:click="$set('seat_view',false)">Cancelar
                            </x-jet-secondary-button>
                            <x-jet-button wire:click="updateSeat({{ $seatEdit['id'] }})">Actualizar</x-jet-button>
                        </x-slot>
                    </x-jet-dialog-modal>
                @endif
            </div>
        </div>
    </div>
</div>
