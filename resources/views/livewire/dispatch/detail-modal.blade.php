<div>
    <x-dialog-modal wire:model='open' maxWidth="screen" >
        <x-slot name="title">
            Detalle de blending
        </x-slot>
        <x-slot name="content">
            <div class="grid grid-cols-1 sm:grid-cols-5">
            @foreach ($dispatchDetails as $dispatchDetail)
            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                <x-label>Lote:</x-label>
                <x-input type="text" style="height:40px;width: 100%" value="{{ $dispatchDetail->Settlement->batch }}" disabled/>

            </div>
            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                <x-label>Concentrado:</x-label>
                <x-input type="text" style="height:40px;width: 100%" value="{{ $dispatchDetail->Settlement->Order->Concentrate->concentrate }}" disabled/>

            </div>
            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                <x-label>TMH:</x-label>
                <x-input type="text" style="height:40px;width: 100%" value="{{ number_format($dispatchDetail->wmt,3) }}" disabled/>

            </div>
            @php
               $factor = $dispatchDetail->Settlement->Law->tmns/$dispatchDetail->Settlement->Order->wmt
            @endphp
            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                <x-label>TMS:</x-label>
                <x-input type="text" style="height:40px;width: 100%" value="{{ round($dispatchDetail->wmt*$factor,3) }}" disabled/>

            </div>
            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                <x-label>Monto:</x-label>
                <x-input type="text" style="height:40px;width: 100%" value="$ {{ number_format(round($dispatchDetail->Settlement->SettlementTotal->total*$dispatchDetail->wmt/$dispatchDetail->Settlement->Order->wmt,2),2) }}" disabled/>

            </div>
            @endforeach
        </div>
        </x-slot>
        <x-slot name="footer">
            @if (!$shipped)
            <x-button wire:loading.attr="disabled" wire:click="$emit('confirmShip',{{ $dispatchId }})">
                Enviar
            </x-button>
            @endif
            <x-secondary-button wire:click="$set('open',false)" class="ml-2">
                Cerrar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
