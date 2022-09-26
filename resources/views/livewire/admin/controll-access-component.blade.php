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
                    <div class="flex mx-auto px-4 py-2">
                        <x-jet-label class="mx-4 mb-2" value="Ingreso:" />
                        <input type="radio" wire:model="type" name="type" value="1">
                        <x-jet-label class="mx-4 mb-2" value="Salida:" />
                        <input type="radio" wire:model="type" name="type" value="2">
                    </div>
                    <div class="mx-auto p-4 text-center">
                        <x-jet-label class="mb-4" value="Codigo:" />
                        <x-jet-input class="w-full text-center" type="text" wire:model="barcode" />
                    </div>
                </form>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="mx-auto w-1/5 py-2 mb-2">
                        <div class="grid grid-cols-4 gap-3 place-content-center">
                            @if ($boxs)
                                @foreach ($boxs as $box)
                                    <div class="bg-green-600">
                                        1
                                    </div>
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
