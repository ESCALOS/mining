<div>
    <x-dialog-modal wire:model='open' maxWidth="screen">
        <x-slot name="title">
            Registrar Órdenes
        </x-slot>
        <x-slot name="content">
            <div wire:loading.remove>
                <div class="grid grid-cols-1 sm:grid-cols-3">
                    <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                        <x-label>Fecha:</x-label>
                        <x-input type="date" style="height:40px;width: 100%" wire:model.defer="date" max="{{ date('Y-m-d') }}"/>

                        <x-input-error for="date"/>

                    </div>
                    <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                        <x-label>Ticket:</x-label>
                        <x-input type="text" style="height:40px;width: 100%" wire:model.defer="ticket"/>

                        <x-input-error for="ticket"/>

                    </div>
                    <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                        <x-label>Ruc ó Dni del cliente</x-label>
                        <x-input type="number" style="height:40px;width: 100%" wire:model.lazy="clientDocumentNumber"/>

                        <x-input-error for="clientDocumentNumber"/>

                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2">
                    <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                        <x-label>Nombre ó Razón Social del Cliente:</x-label>
                        <x-input type="text" style="height:40px;width: 100%" disabled value="{{ $clientName }}"/>

                        <x-input-error for="clientName"/>

                    </div>
                    <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                        <x-label>Dirección del Cliente:</x-label>
                        <x-input type="text" style="height:40px;width: 100%" wire:model.defer="clientAddress"/>

                        <x-input-error for="clientAddress"/>

                    </div>
                </div>
                <div class="grid grid-cols-3">
                    <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                        <x-label>Concentrado:</x-label>
                        <select class="form-select" style="width: 100%" wire:model.defer='concentrateId'>
                            <option value="0">Seleccione una opción</option>
                            @foreach ($concentrates as $concentrate)
                                <option value="{{ $concentrate->id }}">{{ $concentrate->concentrate }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="concentrateId"/>
                    </div>
                    <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                        <x-label>TMH:</x-label>
                        <x-input type="text" style="height:40px;width: 100%" wire:model.defer="wmt"/>

                        <x-input-error for="wmt"/>

                    </div>
                    <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                        <x-label>Procedencia:</x-label>
                        <x-input type="text" style="height:40px;width: 100%" wire:model.defer="origin"/>

                        <x-input-error for="origin"/>

                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2">
                    <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                        <x-label>Ruc del Transportista:</x-label>
                        <x-input type="text" style="height:40px;width: 100%" wire:model.lazy="carriageDocumentNumber"/>

                        <x-input-error for="carriageDocumentNumber"/>

                    </div>
                    <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                        <x-label>Razón Social del Transportista:</x-label>
                        <x-input type="text" style="height:40px;width: 100%" disabled value="{{ $carriageName }}"/>

                        <x-input-error for="carriageName"/>

                    </div>
                </div>
                <div class="grid grid-cols-3">
                    <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                        <x-label>N° de placa:</x-label>
                        <x-input type="text" style="height:40px;width: 100%" wire:model.defer="plateNumber"/>

                        <x-input-error for="plateNumber"/>

                    </div>
                    <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                        <x-label>Guía de Transporte:</x-label>
                        <x-input type="text" style="height:40px;width: 100%" wire:model.defer="transportGuide"/>

                        <x-input-error for="transportGuide"/>

                    </div>
                    <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                        <x-label>Guía de Remisión:</x-label>
                        <x-input type="text" style="height:40px;width: 100%" wire:model.defer="deliveryNote"/>

                        <x-input-error for="deliveryNote"/>

                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2">
                    <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                        <x-label>Ruc Balanza:</x-label>
                        <x-input type="text" style="height:40px;width: 100%" wire:model.lazy="weighingScaleDocumentNumber"/>

                        <x-input-error for="weighingScaleDocumentNumber"/>

                    </div>
                    <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                        <x-label>Razón Social Balanza:</x-label>
                        <x-input type="text" style="height:40px;width: 100%" disabled value="{{ $weighingScaleName }}"/>

                        <x-input-error for="weighingScaleName"/>

                    </div>
                </div>
            </div>
            <div class="text-4xl text-center" wire:loading.flex>
                Cargando...
            </div>
        </x-slot>
        <x-slot name="footer">
            @if(!$settled)
            <x-button wire:loading.attr="disabled" wire:click="registrar">
                Guardar
            </x-button>
            @endif
            <div wire:loading wire:target='registrar'>
                Registrando...
            </div>
            <x-secondary-button wire:click="$set('open',false)" class="ml-2">
                Cerrar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
    <livewire:order.import-modal :wire:key="3">
</div>
