<div>
    <x-dialog-modal wire:model='open' maxWidth="screen" >
        <x-slot name="title">
            Detalle de blending
        </x-slot>
        <x-slot name="content">
            <div class="grid grid-cols-1 sm:grid-cols-5">
            @foreach ($dispatchDetails as $dispatchDetail)
            @php
               $factor = $dispatchDetail->Settlement->Law->tmns/$dispatchDetail->Settlement->Order->wmt;
               $wmt = round($dispatchDetail->wmt,3);
               $dnwmt = round($wmt*$factor,3);
               $amount = round($dispatchDetail->Settlement->SettlementTotal->total*$wmt/$dispatchDetail->Settlement->Order->wmt,2);
               $wmt_total += $wmt;
               $amount_total += $amount;
               $dnwmt_total += $dnwmt;
               $copper_total += $dnwmt*$dispatchDetail->Settlement->Law->copper;
               $silver_total += $dnwmt*$dispatchDetail->Settlement->Law->silver;
               $gold_total += $dnwmt*$dispatchDetail->Settlement->Law->gold;
            @endphp
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
                <x-input type="text" style="height:40px;width: 100%" value="{{ number_format($wmt,3) }}" disabled/>

            </div>
            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                <x-label>TMNS:</x-label>
                <x-input type="text" style="height:40px;width: 100%" value="{{ number_format($dnwmt,3) }}" disabled/>

            </div>
            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                <x-label>Monto:</x-label>
                <x-input type="text" style="height:40px;width: 100%" value="$ {{ number_format($amount,2) }}" disabled/>

            </div>
            @endforeach
        </div>
        <div id="Promedio de Leyes">
            <div class="w-full py-2 mt-4 bg-amber-600">
                <h1 class="text-lg text-center text-white">Promedio de Leyes</h1>
            </div>
            <div class="grid grid-cols-3 mt-2">
                <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                    <x-label>Cobre:</x-label>
                    <x-input type="text" style="height:40px;width: 100%" disabled value="{{ $dnwmt_total == 0 ? 0 : number_format($copper_total/$dnwmt_total,3) }}"/>
                </div>
                <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                    <x-label>Plata:</x-label>
                    <x-input type="text" style="height:40px;width: 100%" disabled value="{{ $dnwmt_total == 0 ? 0 : number_format($silver_total/$dnwmt_total,3) }}"/>
                </div>
                <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                    <x-label>Oro:</x-label>
                    <x-input type="text" style="height:40px;width: 100%" disabled value="{{ $dnwmt_total == 0 ? 0 : number_format($gold_total/$dnwmt_total,3) }}"/>
                </div>
            </div>
        </div>
        <div id="Total">
            <div class="w-full py-2 mt-4 bg-amber-600">
                <h1 class="text-lg text-center text-white">Total</h1>
            </div>
            <div class="grid grid-cols-3 mt-2">
                <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                    <x-label>TMH:</x-label>
                    <x-input type="text" style="height:40px;width: 100%" disabled value="{{ number_format($wmt_total,3) }}"/>
                </div>
                <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                    <x-label>TMNS:</x-label>
                    <x-input type="text" style="height:40px;width: 100%" disabled value="{{ number_format($dnwmt_total,3) }}"/>
                </div>
                <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                    <x-label>MONTO:</x-label>
                    <x-input type="text" style="height:40px;width: 100%" disabled value="$ {{ number_format($amount_total,2) }}"/>
                </div>
            </div>
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
