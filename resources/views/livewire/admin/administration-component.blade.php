<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Administration') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end">
                @if (auth()->user()->email == 'julio.peniche@boletea.com' || auth()->user()->email == 'alfredomarenco@boletea.com')
                    <x-jet-button class="mt-2" wire:click="$set('modal_restDataBase',true)">Restaurar Base de datos</x-jet-button>
                @endif
            </div>
            @if (session()->has('message'))
                <div class="w-full rounded-md p-2 bg-green-300 text-green-800">
                    {{ session('message') }}
                </div>
            @endif
            <x-jet-dialog-modal wire:model="modal_restDataBase">
                <x-slot name="title">Guardar base de datos actual</x-slot>
                <x-slot name="content">
                    <div>
                        <x-jet-label value="Nombre del evento"/>
                        <x-jet-input type="text" class="w-full" wire:model="event_name"/>
                    </div>
                    <div>
                        <x-jet-label value="Clave del evento"/>
                        <x-jet-input type="text" class="w-full" wire:model="event_code"/>
                    </div>
                </x-slot>
                <x-slot name="footer">
                    <x-jet-danger-button class="mr-2" wire:click="$set('modal_restDataBase',false)">Cancelar</x-jet-danger-button>
                    <x-jet-button wire:click="restartDataBase()">Guardar codigos y restablecer base</x-jet-button>
                </x-slot>
            </x-jet-dialog-modal>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 mb-4">

            </div>
            @if ($boxs_view)
                <div class="flex items-center justify-start p-6 space-x-10">
                    <div>
                        <x-jet-label value="Seccion:" />
                        <select wire:model="box_name"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm py-1">
                            <option value="" selected>Todos</option>
                            @foreach ($boxes_names->unique('name') as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-jet-label value="Palco:" />
                        <select wire:model="box_identifier"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm py-1">
                            <option value="" selected>Todos</option><
                            @foreach ($boxes_identifiers->unique('identifier') as $identifier)
                                <option value="{{ $identifier->identifier }}">{{ $identifier->identifier }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
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
                                    <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
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
                    {{-- <div class="p-4">
                            {{ $boxs->links() }}
                        </div> --}}
                </div>
            @endif
            @if ($box_view)
                <div class="flex justify-end items-center mt-4">
                    <x-jet-button wire:click="showAdd">Agregar tarjeta</x-jet-button>
                </div>
                <div class="w-full px-4 py-4 my-4 shadow-xl bg-gray-200">
                    <div class="grid grid-cols-4 gap-2 mt-6 mb-6">
                        @foreach ($box->codes as $seat)
                            @if ($seat->status != 3 && $seat->status != 4)
                                <div wire:click="showSeat({{ $seat }})"
                                    class="flex justify-center items-center bg-green-600 hover:bg-green-800 text-white text-lg font-bold shadow-lg cursor-pointer">
                                    <p>{{ $seat->seat }}</p>
                                </div>
                            @else
                                @if ($seat->status == 4)
                                    <div wire:click="showSeat({{ $seat }})"
                                        class="flex justify-center items-center bg-red-600 hover:bg-red-800 text-white text-lg font-bold shadow-lg cursor-pointer">
                                        <p>{{ $seat->seat }}</p>
                                    </div>
                                @else
                                    <div wire:click="showSeat({{ $seat }})"
                                        class="flex justify-center items-center bg-orange-600 hover:bg-orange-800 text-white text-lg font-bold shadow-lg cursor-pointer">
                                        <p>{{ $seat->seat }}</p>
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    </div>
                </div>
                {{-- Formulario de creacion de tarjetas --}}
                <x-jet-dialog-modal wire:model="add_view">
                    <x-slot name="title">
                        Agregar tarjeta
                    </x-slot>
                    <x-slot name="content">
                        <form wire:submit.prevent="" class="w-full">
                            <div class="w-full">
                                <x-jet-label value="Section:" />
                                <x-jet-input type="text" class="w-full bg-gray-100" wire:model="name" disabled />
                            </div>
                            <div class="w-full">
                                <x-jet-label value="Palco:" />
                                <x-jet-input type="text" class="w-full bg-gray-100" wire:model="identifier"
                                    disabled />
                            </div>
                            <div class="w-full">
                                <x-jet-label value="Status:" />
                                <select class="w-full border-gray-300 rounded-md" wire:model="status">
                                    <option value="" selected disabled>Selecciona una opcion</option>
                                    <option value="1">Activo</option>
                                    <option value="4">Desactivada</option>
                                    <option value="3">Reportada</option>
                                </select>
                                @error('status')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <x-jet-label value="Tarjeta:" />
                                <x-jet-input type="text" class="w-full" wire:model="seat" />
                                @error('seat')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <x-jet-label value="Codigo:" />
                                <x-jet-input type="text" class="w-full" wire:model="barcode" />
                                @error('barcode')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </form>
                    </x-slot>
                    <x-slot name="footer">
                        <x-jet-secondary-button class="mr-4" wire:click="$set('add_view',false)">Cancelar
                        </x-jet-secondary-button>
                        <x-jet-button wire:click="addCode">Agregar</x-jet-button>
                    </x-slot>
                </x-jet-dialog-modal>
                {{-- Formulario de edicion de tarjetas --}}
                <x-jet-dialog-modal wire:model="seat_view">
                    <x-slot name="title">
                        {{-- {{ $seat->box->name }} {{ $seat->box->identifier }} - Tarjeta {{ $seat->row }} - {{ $seat->seat }} --}}
                    </x-slot>
                    <x-slot name="content">
                        <form class="w-full">
                            <div class="w-full">
                                <x-jet-label value="Section:" />
                                <x-jet-input type="text" class="w-full bg-gray-100" wire:model="seatEdit.name"
                                    disabled />
                            </div>
                            <div class="w-full">
                                <x-jet-label value="Palco:" />
                                <x-jet-input type="text" class="w-full bg-gray-100" wire:model="seatEdit.identifier"
                                    disabled />
                            </div>
                            <div class="w-full">
                                <x-jet-label value="Status:" />
                                <select class="w-full border-gray-300 rounded-md" wire:model="seatEdit.status">
                                    <option value="" selected disabled>Selecciona una opcion</option>
                                    <option value="1">Activo</option>
                                    <option value="4">Desactivada</option>
                                    <option value="3">Reportada</option>
                                </select>
                                @error('status')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <x-jet-label value="Tarjeta:" />
                                <x-jet-input type="text" class="w-full bg-gray-100" wire:model="seatEdit.seat"
                                    disabled />
                            </div>
                            <div class="w-full">
                                <x-jet-label value="Codigo:" />
                                <x-jet-input type="text" class="w-full" wire:model="seatEdit.barcode" />
                                @error('barcode')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full flex justify-end mt-4">
                                <x-jet-danger-button class="text-xs"
                                    wire:click="$emit('seatDelete',{{ $seatEdit['id'] }})">Eliminar Tarjeta
                                </x-jet-danger-button>
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
@push('js')
    <script>
        Livewire.on('seatDelete', seatId => {
            Swal.fire({
                title: 'Estas seguro?',
                text: "Si eliminas la tarjeta todos los datos se perderan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('admin.administration-component', 'deleteSeat', seatId);
                    Swal.fire(
                        'Tarjeta eliminada!',
                        'La tarjeta se elimino con exito.',
                        'success'
                    )
                }
            })
        })
    </script>
@endpush
</div>
