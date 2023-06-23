<div class="w-full">
    <div class="grid items-center grid-cols-{{ Auth::user()->hasRole('administrador') ? 5 : 4 }} gap-4 p-6 bg-white">
        <x-boton-crud accion="$emitTo('order.modal','abrirModal',0)" color="green">Registrar</x-boton-crud>
        <x-boton-crud accion="$emitTo('order.modal','abrirModal',{{$orderId}})" color="amber" :activo="$boton_activo">Editar</x-boton-crud>
        @if (Auth::user()->hasRole('administrador'))
        <x-boton-crud accion="eliminar" color="red" :activo="$boton_activo">Eliminar</x-boton-crud>
        @endif
        <x-boton-crud accion="$emitTo('order.settle-modal','abrirModal',0,{{$orderId}})" color="blue" :activo="$boton_activo">Liquidar</x-boton-crud>
        <x-boton-crud accion="$emitTo('order.import-modal','abrirModal')" color="gray">Importar</x-boton-crud>
    </div>
    <div class="grid grid-cols-4">
        <div class="col-span-3 py-2" style="padding-left: 1rem; padding-right:1rem">
            <x-label>Buscar:</x-label>
            <x-input type="text" style="height:40px;width: 100%" wire:model.lazy="search" placeholder="Escriba algo y presione enter para buscar"/>
        </div>
        <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
            <x-label>Estado:</x-label>
            <select class="form-select" style="width: 100%" wire:model='estado'>
                <option value="">Todos</option>
                <option value="1">Liquidados</option>
                <option value="0">No liquidados</option>
            </select>
        </div>
    </div>
    @if ($orders->count())
    <table class="w-full overflow-x-scroll table-fixed" wire:loading.remove wire:target='getOrders'>
        <thead>
            <tr class="text-sm leading-normal text-gray-600 uppercase bg-gray-200">
                <th class="py-3 text-center">
                    <span class="block">Fecha</span>
                </th>
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
            @foreach ($orders as $order)
                <tr style="cursor:pointer" wire:click="seleccionar({{$order->id}})" class="border-b {{ $order->id == $orderId ? 'bg-blue-200' : '' }} border-gray-200">
                    <td class="py-3 text-center">
                        <div>
                            <span class="font-medium">{{ $order->date }}</span>
                        </div>
                    </td>
                    <td class="py-3 text-center">
                        <div>
                            <span class="font-medium">{{ $order->batch }}</span>
                        </div>
                    </td>
                    <td class="py-3 text-center">
                        <div>
                            <span class="font-medium">{{ $order->Concentrate->concentrate }}</span>
                        </div>
                    </td>
                    <td class="py-3 text-center">
                        <div>
                            <span class="font-medium">{{ number_format($order->wmt,3) }}</span>
                        </div>
                    </td>
                    <td class="py-3 text-center">
                        <div>
                            <span class="font-medium">{{ $order->Client->name }}</span>
                        </div>
                    </td>
                    <td class="py-3 text-center">
                        <div>
                            <x-badge color="{{ $order->settled ? 'green' : 'red' }}">{{ $order->settled ? 'Liquidado' : 'No liquidado' }}</x-badge>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="px-4 py-4" wire:loading.remove wire:target='getOrders'>
        {{ $orders->links() }}
    </div>
    @else
    <div class="px-6 py-4 text-2xl font-black" wire:loading.remove wire:target='getOrders'>
        Ningún registro coincidente
    </div>
    @endif
    <div style="align-items:center;justify-content:center;margin-bottom:15px" wire:loading.flex wire:target='getOrders'>
        <div class="text-center">
            <h1 class="text-4xl font-bold">
                CARGANDO DATOS...
            </h1>
        </div>
    </div>
    <livewire:order.modal :wire:key="1">
    <livewire:order.settle-modal :wire:key="2">
</div>
