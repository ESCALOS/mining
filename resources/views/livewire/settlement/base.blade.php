<div class="w-full">
    <div class="grid items-center grid-cols-2 gap-4 p-6 bg-white sm:grid-cols-4">
        <x-boton-crud accion="$emitTo('settlement.modal','abrirModal',0)" color="green">Registrar</x-boton-crud>
        <x-boton-crud accion="$emitTo('settlement.modal','abrirModal',{{$settlementId}})" color="amber" :activo="$boton_activo">Editar</x-boton-crud>
        <x-boton-crud accion="anular" color="red" :activo="$boton_activo">Anular</x-boton-crud>
        <x-boton-crud accion="settle" color="gray">Bleeding</x-boton-crud>
    </div>

    <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
        <x-input type="text" style="height:40px;width: 100%" wire:model.lazy="search" placeholder="Escriba algo y presione enter para buscar"/>
    </div>
    @if ($settlements->count())
    <table class="w-full overflow-x-scroll table-fixed" wire:loading.remove wire:target='getSettlements'>
        <thead>
            <tr class="text-sm leading-normal text-gray-600 uppercase bg-gray-200">
                <th class="py-3 text-center">
                    <span class="block">Lote</span>
                </th>
                <th class="py-3 text-center">
                    <span class="block">Concentrado</span>
                </th>
                <th class="py-3 text-center">
                    <span class="block">THM</span>
                </th>
                <th class="py-3 text-center">
                    <span class="block">Nombre o Razón Social</span>
                </th>
                <th class="py-3 text-center">
                    <span class="block">Estado</span>
                </th>
            </tr>
        </thead>
        <tbody class="text-sm font-light text-gray-600">
            @foreach ($settlements as $settlement)
                <tr style="cursor:pointer" wire:click="seleccionar({{$settlement->id}})" class="border-b {{ $settlement->id == $settlementId ? 'bg-blue-200' : '' }} border-gray-200">
                    <td class="py-3 text-center">
                        <div>
                            <span class="font-medium">{{ $settlement->batch }}</span>
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
    @livewire('settlement.modal')
</div>
