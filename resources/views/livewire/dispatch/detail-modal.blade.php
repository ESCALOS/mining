<div>
    <x-dialog-modal wire:model='open' maxWidth="screen" >
        <x-slot name="title">
            Detalle de blending
        </x-slot>
        <x-slot name="content">
            <div class="grid grid-cols-1 sm:grid-cols-7">
            @foreach ($dispatchDetails as $dispatchDetail)
            @php
               $factor = $dispatchDetail->Settlement->Law->tmns/$dispatchDetail->Settlement->Order->wmt;
               $wmt = round($dispatchDetail->wmt,3);
               $dnwmt = round($wmt*$factor,3);
               $igv = round($dispatchDetail->Settlement->SettlementTotal->igv*$wmt/$dispatchDetail->Settlement->Order->wmt,2);
               $amount = round(($dispatchDetail->Settlement->SettlementTotal->batch_price+$dispatchDetail->Settlement->SettlementTotal->igv)*$wmt/$dispatchDetail->Settlement->Order->wmt,2);
               $wmt_total += $wmt;
               $amount_total += $amount;
               $dnwmt_total += $dnwmt;
               $copper_total += $dnwmt*$dispatchDetail->Settlement->Law->copper;
               $silver_total += $dnwmt*$dispatchDetail->Settlement->Law->silver;
               $gold_total += $dnwmt*$dispatchDetail->Settlement->Law->gold;
               $arsenic_total += $dnwmt*$dispatchDetail->Settlement->Penalty->arsenic;
               $antomony_total += $dnwmt*$dispatchDetail->Settlement->Penalty->antomony;
               $lead_total += $dnwmt*$dispatchDetail->Settlement->Penalty->lead;
               $zinc_total += $dnwmt*$dispatchDetail->Settlement->Penalty->zinc;
               $bismuth_total += $dnwmt*$dispatchDetail->Settlement->Penalty->bismuth;
               $mercury_total += $dnwmt*$dispatchDetail->Settlement->Penalty->mercury;
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
                <x-label>Subtotal:</x-label>
                <x-input type="text" style="height:40px;width: 100%" value="$ {{ number_format($amount-$igv,2) }}" disabled/>
            </div>
            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                <x-label>IGV:</x-label>
                <x-input type="text" style="height:40px;width: 100%" value="$ {{ number_format($igv,2) }}" disabled/>
            </div>
            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                <x-label>Total:</x-label>
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
        <div id="Promedio de Penalidades">
            <div class="w-full py-2 mt-4 bg-red-600">
                <h1 class="text-lg text-center text-white">Promedio de Penalidades</h1>
            </div>
            <div class="grid grid-cols-6 mt-2">
                <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                    <x-label>Arsenico:</x-label>
                    <x-input type="text" style="height:40px;width: 100%" disabled value="{{ $dnwmt_total == 0 ? 0 : number_format($arsenic_total/$dnwmt_total,3) }}"/>
                </div>
                <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                    <x-label>Antimonio:</x-label>
                    <x-input type="text" style="height:40px;width: 100%" disabled value="{{ $dnwmt_total == 0 ? 0 : number_format($antomony_total/$dnwmt_total,3) }}"/>
                </div>
                <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                    <x-label>Plomo:</x-label>
                    <x-input type="text" style="height:40px;width: 100%" disabled value="{{ $dnwmt_total == 0 ? 0 : number_format($lead_total/$dnwmt_total,3) }}"/>
                </div>
                <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                    <x-label>Zinc:</x-label>
                    <x-input type="text" style="height:40px;width: 100%" disabled value="{{ $dnwmt_total == 0 ? 0 : number_format($zinc_total/$dnwmt_total,3) }}"/>
                </div>
                <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                    <x-label>Bismuto:</x-label>
                    <x-input type="text" style="height:40px;width: 100%" disabled value="{{ $dnwmt_total == 0 ? 0 : number_format($bismuth_total/$dnwmt_total,3) }}"/>
                </div>
                <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                    <x-label>Mercurio:</x-label>
                    <x-input type="text" style="height:40px;width: 100%" disabled value="{{ $dnwmt_total == 0 ? 0 : number_format($mercury_total/$dnwmt_total,3) }}"/>
                </div>
            </div>
        </div>
        <div id="Total">
            <div class="w-full py-2 mt-4 bg-green-600">
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
            <x-button class="mr-2" wire:loading.attr="disabled" wire:click="printDispatch">
                <div wire:loading.remove>
                    Imprimir
                </div>
                <div wire:loading.flex>
                    Cargando...
                </div>
            </x-button>
            @if (!$shipped)
            <x-boton-crud wire:loading.attr="disabled" accion="$emit('confirmShip',{{ $dispatchId }})" color="green">Enviar</x-boton-crud>
            @endif
            <x-secondary-button wire:click="$set('open',false)" class="ml-2">
                Cerrar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
