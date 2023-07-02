<div class="w-full">
    <div class="grid items-center grid-cols-3 gap-4 p-6 bg-white">
        <x-boton-crud accion="$emitTo('concentrate.modal','abrirModal',0)" color="green">Registrar</x-boton-crud>
        <x-boton-crud accion="$emitTo('concentrate.modal','abrirModal',{{$concentrateId}})" color="amber" :activo="$boton_activo">Editar</x-boton-crud>
        <x-boton-crud accion="eliminar" color="red" :activo="$boton_activo">Eliminar</x-boton-crud>
    </div>

    <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
        <x-input type="text" style="height:40px;width: 100%" wire:model.lazy="search" placeholder="Buscar concentrado"/>
    </div>
    @if ($concentrates->count())
    <table class="w-full overflow-x-scroll table-fixed" wire:loading.remove wire:target='getConcentrates'>
        <thead>
            <tr class="text-sm leading-normal text-gray-600 uppercase bg-gray-200">
                <th class="py-3 text-center">
                    <span class="block">Concentrado</span>
                </th>
                <th class="py-3 text-center">
                    <span class="block">Símbolo Químico</span>
                </th>
            </tr>
        </thead>
        <tbody class="text-sm font-light text-gray-600">
            @foreach ($concentrates as $concentrate)
                <tr style="cursor:pointer" wire:click="seleccionar({{$concentrate->id}})" class="border-b {{ $concentrate->id == $concentrateId ? 'bg-blue-200' : '' }} border-gray-200">
                    <td class="py-3 text-center">
                        <div>
                            <span class="font-medium">{{ $concentrate->concentrate }}</span>
                        </div>
                    </td>
                    <td class="py-3 text-center">
                        <div>
                            <span class="font-medium">{{ $concentrate->chemical_symbol }}</span>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="px-4 py-4" wire:loading.remove wire:target='getConcentrates'>
        {{ $concentrates->links() }}
    </div>
    @else
    <div class="px-6 py-4 text-2xl font-black" wire:loading.remove wire:target='getConcentrates'>
        Ningún registro coincidente
    </div>
    @endif
    <div style="align-items:center;justify-content:center;margin-bottom:15px" wire:loading.flex wire:target='getConcentrates'>
        <div class="text-center">
            <h1 class="text-4xl font-bold">
                CARGANDO DATOS...
            </h1>
        </div>
    </div>
    @livewire('concentrate.modal')
</div>
