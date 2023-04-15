<div class="w-full">
    <div class="grid items-center grid-cols-1 gap-4 p-6 bg-white sm:grid-cols-1">
        <x-boton-crud accion="blending" color="gray" :activo="$boton_activo">Blending</x-boton-crud>
    </div>

    <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
        <x-input type="text" style="height:40px;width: 100%" wire:model.lazy="search" placeholder="Escriba algo y presione enter para buscar"/>
    </div>
    @if ($settlements->count())
    <table class="w-full overflow-x-scroll table-fixed" wire:loading.remove wire:target='getSettlements'>
        <thead>
            <tr class="text-sm leading-normal text-gray-600 uppercase bg-gray-200">
                <th class="py-3 text-center" width="20px">
                    <span class="block"></span>
                </th>
                <th class="py-3 text-center">
                    <span class="block">Lote</span>
                </th>
                <th class="py-3 text-center">
                    <span class="block">Concentrado</span>
                </th>
                <th class="py-3 text-center">
                    <span class="block">TMH</span>
                </th>
                <th class="py-3 text-center">
                    <span class="block">TMNS</span>
                </th>
                <th class="py-3 text-center">
                    <span class="block">Nombre o Razón Social</span>
                </th>
                <th class="py-3 text-center" style="width:150px">
                    <span class="block">Acciones</span>
                </th>
            </tr>
        </thead>
        <tbody class="text-sm font-light text-gray-600">
            @foreach ($settlements as $settlement)
                <tr style="cursor:pointer" class="border-b {{ $settlement->id == $settlementId ? 'bg-blue-200' : '' }} border-gray-200">
                    <td class="py-3 text-center">
                        <div class="flex items-center h-5">
                            <input id="helper-checkbox" aria-describedby="helper-checkbox-text" type="checkbox" value="" class="w-4 h-4 ml-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" wire:click="seleccionar({{$settlement->id}})">
                        </div>
                    </td>
                    <td class="py-3 text-center">
                        <div>
                            <span class="font-medium">{{ $settlement->batch }}</span>
                        </div>
                    </td>
                    <td class="py-3 text-center">
                        <div>
                            <span class="font-medium">{{ $settlement->concentrate }}</span>
                        </div>
                    </td>
                    <td class="py-3 text-center">
                        <div>
                            <span class="font-medium">{{ number_format($settlement->wmt,3) }}</span>
                        </div>
                    </td>
                    <td class="py-3 text-center">
                        <div>
                            <span class="font-medium">{{ number_format($settlement->Law->tmns,3) }}</span>
                        </div>
                    </td>
                    <td class="py-3 text-center">
                        <div>
                            <span class="font-medium">{{ $settlement->name }}</span>
                        </div>
                    </td>
                    <td class="py-3 text-center">
                        <div class="grid grid-cols-2 mx-auto text-center">
                            <div class="w-10 h-10 mx-auto" wire:click='$emitTo("order.settle-modal","abrirModal",{{ $settlement->id }},{{ $settlement->order_id }})'>
                                <x-icons.pencil :size="10" : class="p-2 font-medium text-center text-white rounded-md bg-amber-500"/>
                            </div>
                            <div class="w-10 h-10 mx-auto" wire:click='$emitTo("settlement.detail-modal","showDetails",{{ $settlement->id }})'>
                                <x-icons.eye :size="10" : class="p-2 font-medium text-center text-white bg-blue-500 rounded-md"/>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="px-4 py-4" wire:loading.remove wire:target='getSettlements'>
        {{ $settlements->links() }}
    </div>
    @else
    <div class="px-6 py-4 text-2xl font-black" wire:loading.remove wire:target='getSettlements'>
        Ningún registro coincidente
    </div>
    @endif
    <div style="align-items:center;justify-content:center;margin-bottom:15px" wire:loading.flex wire:target='getSettlements'>
        <div class="text-center">
            <h1 class="text-4xl font-bold">
                CARGANDO DATOS...
            </h1>
        </div>
    </div>
    @livewire('settlement.detail-modal')
    @livewire('settlement.blending-modal')
    @livewire('order.settle-modal')
</div>
