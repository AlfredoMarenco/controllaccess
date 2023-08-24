<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Controll de accesos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <form wire:submit.prevent='valid'>
                    <div class="flex mx-auto px-4 py-4 items-center">
                        <x-jet-label class="mx-4" value="Ingreso:" />
                        <input type="radio" wire:model="type" name="type" value="1">
                        <x-jet-label class="mx-4" value="Salida:" />
                        <input type="radio" wire:model="type" name="type" value="2">
                    </div>
                    <div class="mx-auto p-4 text-center">
                        <x-jet-label class="mb-4" value="Codigo:" />
                        <x-jet-input class="w-full text-center" type="text" wire:model="barcode" />
                    </div>
                </form>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="mx-auto w-1/5 px-4 pb-4 mb-4 shadow-xl bg-gray-300">
                        @if ($boxs)
                            <h1 class="text-center text-lg pt-2 mb-2">Palco: {{ $boxs->first()->section }}
                                {{ $boxs->first()->row }}</h1>
                        @endif
                        <div class="grid grid-cols-4 gap-2 place-content-center">
                            @if ($boxs)
                                @foreach ($boxs->sortBy('seat') as $box)
                                    @if ($box->status == 1)
                                        <div
                                            class="flex justify-center items-center bg-green-600 text-white text-lg font-bold shadow-lg">
                                            <p>{{ $box->seat }}</p>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                            </svg>

                                        </div>
                                    @elseif($box->status == 2)
                                        <div
                                            class="flex justify-center items-center bg-orange-600 text-white text-lg font-bold shadow-lg">
                                            <p>{{ $box->seat }}</p>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                                            </svg>
                                        </div>
                                    @elseif($box->status == 3)
                                        <div
                                            class="flex justify-center items-center bg-orange-600 text-white text-lg font-bold shadow-lg">
                                            <p>{{ $box->seat }}</p>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                            </svg>
                                        </div>
                                    @elseif($box->status == 4)
                                        <div
                                            class="flex justify-center items-center bg-red-600 text-white text-lg font-bold shadow-lg">
                                            <p>{{ $box->seat }}</p>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                    @else
                                        <div class="flex bg-red-600 justify-center text-white text-lg font-bold shadow-lg items-center"
                                            title="Escaneado: {{ $box->updated_at }}">
                                            <p class="cursor-pointer">{{ $box->seat }}</p>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4 cursor-pointer">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                                <title>Escaneado: {{ $box->updated_at }}</title>
                                            </svg>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            window.addEventListener('valid', event => {
                Swal.fire({
                    title: event.detail.title,
                    html: event.detail.html,
                    icon: event.detail.icon,
                    timer: event.detail.timer,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                    },
                }).then((result) => {
                    /* Read more about handling dismissals below */
                    if (result.dismiss === Swal.DismissReason.timer) {
                        console.log('I was closed by the timer')
                    }
                })
            });
        </script>
    @endpush
</div>
