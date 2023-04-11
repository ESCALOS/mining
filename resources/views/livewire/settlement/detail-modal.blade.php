<div>
    <x-dialog-modal wire:model='open' maxWidth="screen" >
        <x-slot name="title">
            Detalle Liquidación - {{ $settlement != [] ? $settlement->batch : '' }}
        </x-slot>
        <x-slot name="content">
            @if ($settlement != [])
            <div id="Pagables">
                <div class="w-full py-2 mt-4 bg-gray-600">
                    <h1 class="text-lg text-center text-white">Pagables</h1>
                </div>
                <table style="font-family: Arial, Helvetica, sans-serif;border-collapse: collapse;width: 100%;font-size: 15px">
                    <thead class="bg-amber-300">
                        <th style="border: 2px solid black;padding: 1rem;text-align: center">Metal</th>
                        <th style="border: 2px solid black;padding: 1rem;text-align: center">Leyes</th>
                        <th style="border: 2px solid black;padding: 1rem;text-align: center">%Pagable</th>
                        <th style="border: 2px solid black;padding: 1rem;text-align: center">Deduccion</th>
                        <th style="border: 2px solid black;padding: 1rem;text-align: center">Precio</th>
                        <th style="border: 2px solid black;padding: 1rem;text-align: center">US$/Tm</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">Cu %</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">{{ floatval($settlement->Law->copper) }}%</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">{{ floatval($settlement->PercentagePayable->copper) }}%</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">{{ floatval($settlement->Deduction->copper) }}%</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->PayableTotal->unit_price_copper,3) }}</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->PayableTotal->total_price_copper,3) }}</td>
                        </tr>
                        <tr>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">Ag Oz/TC</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">{{ floatval($settlement->Law->silver) }}</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">{{ floatval($settlement->PercentagePayable->silver) }}%</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">{{ floatval($settlement->Deduction->silver) }}</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->PayableTotal->unit_price_silver,3) }}</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->PayableTotal->total_price_silver,3) }}</td>
                        </tr>
                        <tr>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">Au Oz/TC</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">{{ floatval($settlement->Law->gold) }}</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">{{ floatval($settlement->PercentagePayable->gold) }}%</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">{{ floatval($settlement->Deduction->gold) }}</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->PayableTotal->unit_price_gold,3) }}</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->PayableTotal->total_price_gold,3) }}</td>
                        </tr>
                        <tr>
                            <td colspan="5" style="border: 2px solid black;padding: 1rem;text-align: center;font-weight:bolder">Total Pagable / TM</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->SettlementTotal->payable_total,3) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="Deducciones">
                <div class="w-full py-2 mt-4 bg-gray-600">
                    <h1 class="text-lg text-center text-white">Deducciones</h1>
                </div>
                <table style="font-family: Arial, Helvetica, sans-serif;border-collapse: collapse;width: 100%;font-size: 15px">
                    <thead class="bg-amber-300">
                        <th style="border: 2px solid black;padding: 1rem;text-align: center">Concepto</th>
                        <th style="border: 2px solid black;padding: 1rem;text-align: center">Precio</th>
                        <th style="border: 2px solid black;padding: 1rem;text-align: center">US$/Tm</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">Refinación de Cu</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->DeductionTotal->unit_price_copper,3) }}</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->DeductionTotal->total_price_copper,3) }}</td>
                        </tr>
                        <tr>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">Refinación de Ag</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->DeductionTotal->unit_price_silver,3) }}</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->DeductionTotal->total_price_silver,3) }}</td>
                        <tr>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">Refinación de Au</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->DeductionTotal->unit_price_gold,3) }}</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->DeductionTotal->total_price_gold,3) }}</td>
                        </tr>
                        <tr>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">Maquila</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->DeductionTotal->maquila,3) }}</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->DeductionTotal->maquila,3) }}</td>
                        </tr>
                        <tr>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">Ánalisis</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->DeductionTotal->analysis,3) }}</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->DeductionTotal->analysis,3) }}</td>
                        </tr>
                        <tr>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">Estibadores</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->DeductionTotal->stevedore,3) }}</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->DeductionTotal->stevedore,3) }}</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="border: 2px solid black;padding: 1rem;text-align: center;font-weight:bolder">Total Deducciones</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->SettlementTotal->deduction_total,3) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="Penalidades">
                <div class="w-full py-2 mt-4 bg-gray-600">
                    <h1 class="text-lg text-center text-white">Penalidades</h1>
                </div>
                <table style="font-family: Arial, Helvetica, sans-serif;border-collapse: collapse;width: 100%;font-size: 15px">
                    <thead class="bg-amber-300">
                        <th style="border: 2px solid black;padding: 1rem;text-align: center">Elemento</th>
                        <th style="border: 2px solid black;padding: 1rem;text-align: center">Penalidad</th>
                        <th style="border: 2px solid black;padding: 1rem;text-align: center">Máximo Permitido</th>
                        <th style="border: 2px solid black;padding: 1rem;text-align: center">US$/Tm</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">As</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->Penalty->arsenic,3) }}</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->AllowedAmount->arsenic,3) }}</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->PenaltyTotal->total_arsenic,3) }}</td>
                        </tr>
                        <tr>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">Sb</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->Penalty->antomony,3) }}</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->AllowedAmount->antomony,3) }}</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->PenaltyTotal->total_antomony,3) }}</td>
                        <tr>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">Bi</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->Penalty->bismuth,3) }}</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->AllowedAmount->bismuth,3) }}</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->PenaltyTotal->total_bismuth,3) }}</td>
                        </tr>
                        <tr>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">Pb</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->Penalty->lead,3) }}</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->AllowedAmount->lead,3) }}</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->PenaltyTotal->total_lead,3) }}</td>
                        </tr>
                        <tr>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">Zn</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->Penalty->zinc,3) }}</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->AllowedAmount->zinc,3) }}</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->PenaltyTotal->total_zinc,3) }}</td>
                        </tr>
                        <tr>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">Hg</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->Penalty->mercury,3) }}</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->AllowedAmount->mercury,3) }}</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->PenaltyTotal->total_mercury,3) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" style="border: 2px solid black;padding: 1rem;text-align: center;font-weight:bolder">Total Penalidades</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->SettlementTotal->penalty_total,3) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="Total_Liquidacion">
                <div class="w-full py-2 mt-4 bg-gray-600">
                    <h1 class="text-lg text-center text-white">Total Liquidación</h1>
                </div>
                <table style="font-family: Arial, Helvetica, sans-serif;border-collapse: collapse;width: 100%;font-size: 15px">
                    <thead class="bg-amber-300">
                        <th style="border: 2px solid black;padding: 1rem;text-align: center">Total US$/TM</th>
                        <th style="border: 2px solid black;padding: 1rem;text-align: center">Valor por Lote US$</th>
                        <th style="border: 2px solid black;padding: 1rem;text-align: center">IGV</th>
                        <th style="border: 2px solid black;padding: 1rem;text-align: center">Detracción</th>
                        <th style="border: 2px solid black;padding: 1rem;text-align: center">Total de liquidacion</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->SettlementTotal->unit_price,3) }}</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->SettlementTotal->batch_price,2) }}</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->SettlementTotal->igv,2) }}</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->SettlementTotal->detraccion,2) }}</td>
                            <td style="border: 2px solid black;padding: 1rem;text-align: center">$ {{ number_format($settlement->SettlementTotal->total,2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @endif

        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$set('open',false)" class="ml-2">
                Cerrar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
