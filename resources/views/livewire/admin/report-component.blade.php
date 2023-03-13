<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="px-4 pb-4 mb-4 shadow-xl bg-white">
                    <div class="grid lg:grid-cols-5 lg:gap-8 grid-cols-1 gap-2 place-content-center p-4">
                        @foreach ($boxs as $palco)
                            <div>
                                <h1 class="text-center font-bold p-2">PALCO {{ $palco->name }} {{ $palco->identifier }}</h1>
                                <div class="grid grid-cols-4 gap-2 place-content-center">
                                    @foreach ($palco->codes as $seat)
                                        @if ($seat->box_id == $palco->id )
                                            @if ($seat->status == 1)
                                                <div
                                                    class="flex justify-center items-center bg-green-600 text-white text-lg font-bold shadow-lg">
                                                    <p>{{ $seat->seat }}</p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                                    </svg>

                                                </div>
                                            @elseif($seat->status == 2)
                                                <div
                                                    class="flex justify-center items-center bg-orange-600 text-white text-lg font-bold shadow-lg">
                                                    <p>{{ $seat->seat }}</p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                                                    </svg>
                                                </div>
                                            @else
                                                <div
                                                    class="flex bg-red-600 justify-center text-white text-lg font-bold shadow-lg items-center">
                                                    <p>{{ $seat->seat }}</p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
