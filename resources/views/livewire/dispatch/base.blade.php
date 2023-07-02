<div class="w-full">
    <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
        <x-input type="text" style="height:40px;width: 100%" wire:model.lazy="search" placeholder="Buscar blendings"/>
    </div>
    @if ($dispatches->count())
    <table class="w-full overflow-x-scroll table-fixed" wire:loading.remove wire:target='getDispatches'>
        <thead>
            <tr class="text-sm leading-normal text-gray-600 uppercase bg-gray-200">
                <th class="py-3 text-center">
                    <span class="block">Lote</span>
                </th>
                <th class="py-3 text-center">
                    <span class="block">THM</span>
                </th>
                <th class="py-3 text-center" style="width:150px">
                    <span class="block">Acciones</span>
                </th>
            </tr>
        </thead>
        <tbody class="text-sm font-light text-gray-600">
            @foreach ($dispatches as $dispatch)
                <tr style="cursor:pointer" class="border-b border-gray-200">
                    <td class="py-3 text-center">
                        <div>
                            <span class="font-medium">{{ $dispatch->batch }}</span>
                        </div>
                    </td>
                    <td class="py-3 text-center">
                        <div>
                            <span class="font-medium">{{ number_format($dispatch->details_sum_wmt,3) }}</span>
                        </div>
                    </td>
                    <td class="py-3 text-center">
                        <div class="grid grid-cols-3 mx-auto text-center">
                            <div title="Ver detalles" class="w-10 h-10 mx-auto" wire:click="$emit('abrirModal',{{ $dispatch->id }})">
                                <x-icons.eye :size="10" : class="p-2 font-medium text-center text-white bg-blue-500 rounded-md"/>
                            </div>
                            <div title="Deshacer" class="w-10 h-10 mx-auto" wire:click='confirmPullApart({{ $dispatch->id }})'>
                                <x-icons.trash :size="10" : class="p-2 font-medium text-center text-white bg-red-500 rounded-md"/>
                            </div>
                            <div title="Enviar" class="w-10 h-10 mx-auto" wire:click="confirmShip({{ $dispatch->id }})">
                                <x-icons.arrow-right :size="10" : class="p-2 font-medium text-center text-white bg-green-500 rounded-md"/>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="px-4 py-4" wire:loading.remove wire:target='getDispatches'>
        {{ $dispatches->links() }}
    </div>
    @else
    <div class="px-6 py-4 text-2xl font-black" wire:loading.remove wire:target='getDispatches'>
        Ningún registro coincidente
    </div>
    @endif
    <div style="align-items:center;justify-content:center;margin-bottom:15px" wire:loading.flex wire:target='getDispatches'>
        <div class="text-center">
            <h1 class="text-4xl font-bold">
                CARGANDO DATOS...
            </h1>
        </div>
    </div>
    @livewire('dispatch.detail-modal')
</div>
