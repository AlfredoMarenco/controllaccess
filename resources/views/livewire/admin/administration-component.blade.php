<div>
    {<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Administration') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
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
                                <tr class="{{ $loop->iteration % 2  ? 'bg-white' : 'bg-gray-50'}} border-b">
                                    <th scope="row"
                                        class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $box->name }}
                                    </th>
                                    <td class="py-4 px-6">
                                        {{ $box->identifier }}
                                    </td>
                                    <td class="py-4 px-6">
                                        <a href="#"
                                            class="font-medium text-blue-600 hover:underline">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $boxs->links() }}
            </div>
        </div>
    </div>
</div>
