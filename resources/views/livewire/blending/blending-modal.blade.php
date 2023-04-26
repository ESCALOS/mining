<div>
    <x-dialog-modal wire:model='open' maxWidth="screen" >
        <x-slot name="title">
            Mezclando
        </x-slot>
        <x-slot name="content">
            <div class="py-2 text-center" style="padding-left: 1rem; padding-right:1rem">
                <x-label>Cantidad máxima:</x-label>
                <x-input type="text" style="height:40px;width: 100%" class="text-center" wire:model="maximumWmt"/>

                <x-input-error for="maximumWmt"/>

            </div>
            <div class="grid grid-cols-1 sm:grid-cols-5">
            @foreach ($settlementId as $key => $settlement)
            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                <x-label>Lote:</x-label>
                <x-input type="text" style="height:40px;width: 100%" wire:model="batch.{{ $key }}" disabled/>
            </div>
            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                <x-label>Concentrado:</x-label>
                <x-input type="text" style="height:40px;width: 100%" wire:model="concentrate.{{ $key }}" disabled/>

            </div>
            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                <x-label>TMH:</x-label>
                <x-input type="number" style="height:40px;width: 100%" wire:model="wmt.{{ $key }}" disabled/>

            </div>
            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                <x-label>TMH Faltante:</x-label>
                <x-input type="number" style="height:40px;width: 100%" wire:model="missingWmt.{{ $key }}" disabled/>

            </div>
            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                <x-label>TMH a enviar:</x-label>
                <x-input type="number" style="height:40px;width: 100%" min="0" max="{{ $missingWmt[$key] }}" wire:model="wmtToShip.{{ $key }}"/>

                <x-input-error for="wmtToShip.{{ $key }}"/>

            </div>
            @endforeach
        </div>
        </x-slot>
        <x-slot name="footer">
            <x-button wire:loading.attr="disabled" wire:click="confirmBlending">
                Guardar
            </x-button>
            <div wire:loading wire:target='confirmBlending'>
                Registrando...
            </div>
            <x-secondary-button wire:click="$set('open',false)" class="ml-2">
                Cerrar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
