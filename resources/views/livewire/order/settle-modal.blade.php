<div>
    <x-dialog-modal wire:model='open' maxWidth="screen">
        <x-slot name="title">
            Liquidar Órdenes
        </x-slot>
        <x-slot name="content">
            <div wire:loading.remove>
                <div class="{{ $page == 2 ? 'hidden' : '' }}">
                    <div id="Precio_Internacional">
                        <div class="w-full py-2 bg-gray-600" >
                            <h1 class="text-lg text-center text-white">Precio Internacional</h1>
                        </div>
                        <div class="grid grid-cols-4 mt-4">
                            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                                <x-label>Factura:</x-label>
                                <select class="form-control" style="width: 100%" wire:model.defer='withInvoice'>
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
                                </select>

                                <x-input-error for="withInvoice"/>

                            </div>
                            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                                <x-label>Cobre Internacional:</x-label>
                                <x-input type="text" style="height:40px;width: 100%" wire:model.defer="internationalCopper"/>

                                <x-input-error for="internationalCopper"/>

                            </div>
                            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                                <x-label>Plata Internacional:</x-label>
                                <x-input type="text" style="height:40px;width: 100%" wire:model.defer="internationalSilver"/>

                                <x-input-error for="internationalSilver"/>

                            </div>
                            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                                <x-label>Oro Internacional:</x-label>
                                <x-input type="text" style="height:40px;width: 100%" wire:model.defer="internationalGold"/>

                                <x-input-error for="internationalGold"/>

                            </div>
                        </div>
                    </div>
                    <div id="Ensayes">
                        <div class="w-full py-2 mt-4 bg-gray-600">
                            <h1 class="text-lg text-center text-white">Ensayes</h1>
                        </div>
                        <div class="grid grid-cols-3 mt-4">
                            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                                <x-label>Ley Cobre(%):</x-label>
                                <x-input type="text" style="height:40px;width: 100%" wire:model.defer="copperLaw"/>

                                <x-input-error for="copperLaw"/>

                            </div>
                            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                                <x-label>Humedad H2O(%):</x-label>
                                <x-input type="text" style="height:40px;width: 100%" wire:model.defer="humidity"/>

                                <x-input-error for="humidity"/>

                            </div>
                            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                                <x-label>Merma(%):</x-label>
                                <x-input type="text" style="height:40px;width: 100%" wire:model.defer="decrease"/>

                                <x-input-error for="decrease"/>

                            </div>
                        </div>
                        <div class="grid grid-cols-2 mt-4 sm:grid-cols-4">
                            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                                <x-label>Ley Plata(Oz):</x-label>
                                <x-input type="text" style="height:40px;width: 100%" wire:model.defer="silverLaw"/>

                                <x-input-error for="silverLaw"/>

                            </div>
                            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                                <x-label>Factor:</x-label>
                                <x-input type="text" style="height:40px;width: 100%" wire:model.defer="silverFactor"/>

                                <x-input-error for="silverFactor"/>

                            </div>
                            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                                <x-label>Ley Oro(Oz):</x-label>
                                <x-input type="text" style="height:40px;width: 100%" wire:model.defer="goldLaw"/>

                                <x-input-error for="goldLaw"/>

                            </div>
                            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                                <x-label>Factor:</x-label>
                                <x-input type="text" style="height:40px;width: 100%" wire:model.defer="goldFactor"/>

                                <x-input-error for="goldFactor"/>

                            </div>
                        </div>
                    </div>
                    <div id="Porcentajes_Pagables">
                        <div class="w-full py-2 mt-4 bg-gray-600">
                            <h1 class="text-lg text-center text-white">Porcentajes Pagables</h1>
                        </div>
                        <div class="grid grid-cols-3 mt-4">
                            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                                <x-label>Cobre(%):</x-label>
                                <x-input type="text" style="height:40px;width: 100%" wire:model.defer="copperPayable"/>

                                <x-input-error for="copperPayable"/>

                            </div>
                            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                                <x-label>Plata(%):</x-label>
                                <x-input type="text" style="height:40px;width: 100%" wire:model.defer="silverPayable"/>

                                <x-input-error for="silverPayable"/>

                            </div>
                            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                                <x-label>Oro(%):</x-label>
                                <x-input type="text" style="height:40px;width: 100%" wire:model.defer="goldPayable"/>

                                <x-input-error for="goldPayable"/>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="{{ $page == 1 ? 'hidden' : '' }}">
                    <div id="Requerimientos">
                        <div class="w-full py-2 mt-4 bg-gray-600">
                            <h1 class="text-lg text-center text-white">Requerimientos</h1>
                        </div>
                        <div class="grid grid-cols-3 mt-4">
                            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                                <x-label>Protección Cobre:</x-label>
                                <x-input type="text" style="height:40px;width: 100%" wire:model.defer="copperProtection"/>

                                <x-input-error for="copperProtection"/>

                            </div>
                            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                                <x-label>Protección Plata:</x-label>
                                <x-input type="text" style="height:40px;width: 100%" wire:model.defer="silverProtection"/>

                                <x-input-error for="silverProtection"/>

                            </div>
                            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                                <x-label>Protección Oro:</x-label>
                                <x-input type="text" style="height:40px;width: 100%" wire:model.defer="goldProtection"/>

                                <x-input-error for="goldProtection"/>

                            </div>
                            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                                <x-label>Deducción Cobre:</x-label>
                                <x-input type="text" style="height:40px;width: 100%" wire:model.defer="copperDeduction"/>

                                <x-input-error for="copperDeduction"/>

                            </div>
                            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                                <x-label>Deducción Plata:</x-label>
                                <x-input type="text" style="height:40px;width: 100%" wire:model.defer="silverDeduction"/>

                                <x-input-error for="silverDeduction"/>

                            </div>
                            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                                <x-label>Deducción Oro:</x-label>
                                <x-input type="text" style="height:40px;width: 100%" wire:model.defer="goldDeduction"/>

                                <x-input-error for="goldDeduction"/>

                            </div>
                            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                                <x-label>Refinamiento Cobre:</x-label>
                                <x-input type="text" style="height:40px;width: 100%" wire:model.defer="copperRefinement"/>

                                <x-input-error for="copperRefinement"/>

                            </div>
                            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                                <x-label>Refinamiento Plata:</x-label>
                                <x-input type="text" style="height:40px;width: 100%" wire:model.defer="silverRefinement"/>

                                <x-input-error for="silverRefinement"/>

                            </div>
                            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                                <x-label>Refinamiento Oro:</x-label>
                                <x-input type="text" style="height:40px;width: 100%" wire:model.defer="goldRefinement"/>

                                <x-input-error for="goldRefinement"/>

                            </div>
                            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                                <x-label>Maquila:</x-label>
                                <x-input type="text" style="height:40px;width: 100%" wire:model.defer="maquila"/>

                                <x-input-error for="maquila"/>

                            </div>
                            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                                <x-label>Análisis:</x-label>
                                <x-input type="text" style="height:40px;width: 100%" wire:model.defer="analysis"/>

                                <x-input-error for="analysis"/>

                            </div>
                            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                                <x-label>Estibadores:</x-label>
                                <x-input type="text" style="height:40px;width: 100%" wire:model.defer="stevedore"/>

                                <x-input-error for="stevedore"/>

                            </div>
                        </div>
                    </div>
                    <div id="Penalidades">
                        <div class="w-full py-2 mt-4 bg-gray-600">
                            <h1 class="text-lg text-center text-white">Penalidades</h1>
                        </div>
                        <div class="grid grid-cols-3 mt-4 sm:grid-cols-6">
                            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                                <x-label>Arsénico:</x-label>
                                <x-input type="text" style="height:40px;width: 100%" wire:model.defer="arsenicPenalty"/>

                                <x-input-error for="arsenic_penalty"/>

                            </div>
                            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                                <x-label>Antimonio:</x-label>
                                <x-input type="text" style="height:40px;width: 100%" wire:model.defer="antomonyPenalty"/>

                                <x-input-error for="antomonyPenalty"/>

                            </div>
                            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                                <x-label>Plomo:</x-label>
                                <x-input type="text" style="height:40px;width: 100%" wire:model.defer="leadPenalty"/>

                                <x-input-error for="leadPenalty"/>

                            </div>
                            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                                <x-label>Zinc:</x-label>
                                <x-input type="text" style="height:40px;width: 100%" wire:model.defer="zincPenalty"/>

                                <x-input-error for="zincPenalty"/>

                            </div>
                            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                                <x-label>Bismuto:</x-label>
                                <x-input type="text" style="height:40px;width: 100%" wire:model.defer="bismuthPenalty"/>

                                <x-input-error for="bismuthPenalty"/>

                            </div>
                            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                                <x-label>Mercurio:</x-label>
                                <x-input type="text" style="height:40px;width: 100%" wire:model.defer="mercuryPenalty"/>

                                <x-input-error for="mercuryPenalty"/>

                            </div>
                        </div>
                    </div>
                    <div id="Maximo_Permitdo">
                        <div class="w-full py-2 mt-4 bg-gray-600">
                            <h1 class="text-lg text-center text-white">Máximo Permitido</h1>
                        </div>
                        <div class="grid grid-cols-3 mt-4 sm:grid-cols-6">
                            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                                <x-label>Arsénico:</x-label>
                                <x-input type="text" style="height:40px;width: 100%" wire:model.defer="arsenicMaximum"/>

                                <x-input-error for="arsenic_Maximum"/>

                            </div>
                            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                                <x-label>Antimonio:</x-label>
                                <x-input type="text" style="height:40px;width: 100%" wire:model.defer="antomonyMaximum"/>

                                <x-input-error for="antomonyMaximum"/>

                            </div>
                            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                                <x-label>Plomo:</x-label>
                                <x-input type="text" style="height:40px;width: 100%" wire:model.defer="leadMaximum"/>

                                <x-input-error for="leadMaximum"/>

                            </div>
                            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                                <x-label>Zinc:</x-label>
                                <x-input type="text" style="height:40px;width: 100%" wire:model.defer="zincMaximum"/>

                                <x-input-error for="zincMaximum"/>

                            </div>
                            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                                <x-label>Bismuto:</x-label>
                                <x-input type="text" style="height:40px;width: 100%" wire:model.defer="bismuthMaximum"/>

                                <x-input-error for="bismuthMaximum"/>

                            </div>
                            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                                <x-label>Mercurio:</x-label>
                                <x-input type="text" style="height:40px;width: 100%" wire:model.defer="mercuryMaximum"/>

                                <x-input-error for="mercuryMaximum"/>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-4xl text-center" wire:loading.flex>
                Cargando...
            </div>
        </x-slot>
        <x-slot name="footer">
            @if ($page == 2)
            <x-boton-crud color="blue" wire:loading.attr="disabled" accion="$set('page',1)">
                Anterior
            </x-boton-crud>
            @else
            <x-boton-crud color="blue" wire:loading.attr="disabled" accion="$set('page',2)">
                Siguiente
            </x-boton-crud>
            @endif
            <x-button class="ml-2" wire:loading.attr="disabled" wire:click="confirmSettle">
                Guardar
            </x-button>

            <div wire:loading wire:target='confirmSettle'>
                Registrando...
            </div>
            <x-secondary-button wire:click="$set('open',false)" class="ml-2">
                Cerrar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
    <x-dialog-modal wire:model='open2' maxWidth="screen">
        <x-slot name="title">
            Resumen de liquidación
        </x-slot>
        <x-slot name="content">
            <div wire:loading.remove>
                <div id="Precio_Internacional">
                    <div class="w-full py-2 bg-gray-600" >
                        <h1 class="text-lg text-center text-white">Precio Internacional</h1>
                    </div>
                    <div class="grid grid-cols-3 mt-4">
                        <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                            <x-label>Cobre Internacional:</x-label>
                            <x-input type="text" style="height:40px;width: 100%" value="{{ $internationalCopper }}" disabled/>
                        </div>
                        <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                            <x-label>Plata Internacional:</x-label>
                            <x-input type="text" style="height:40px;width: 100%" value="{{ $internationalSilver }}" disabled/>
                        </div>
                        <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                            <x-label>Oro Internacional:</x-label>
                            <x-input type="text" style="height:40px;width: 100%" value="{{ $internationalGold }}" disabled/>
                        </div>
                    </div>
                </div>
                <div id="Ensayes">
                    <div class="w-full py-2 mt-4 bg-gray-600">
                        <h1 class="text-lg text-center text-white">Ensayes</h1>
                    </div>
                    <div class="grid grid-cols-3 mt-4">
                        <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                            <x-label>Ley Cobre(%):</x-label>
                            <x-input type="text" style="height:40px;width: 100%" value="{{ $copperLaw }}" disabled/>
                        </div>
                        <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                            <x-label>Humedad H2O(%):</x-label>
                            <x-input type="text" style="height:40px;width: 100%" value="{{ $humidity }}" disabled/>
                        </div>
                        <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                            <x-label>Merma(%):</x-label>
                            <x-input type="text" style="height:40px;width: 100%" value="{{ $decrease }}" disabled/>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 mt-4 sm:grid-cols-4">
                        <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                            <x-label>Ley Plata(Oz):</x-label>
                            <x-input type="text" style="height:40px;width: 100%" value="{{ $silverLaw }}" disabled/>
                        </div>
                        <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                            <x-label>Factor:</x-label>
                            <x-input type="text" style="height:40px;width: 100%" value="{{ $silverFactor }}" disabled/>
                        </div>
                        <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                            <x-label>Ley Oro(Oz):</x-label>
                            <x-input type="text" style="height:40px;width: 100%" value="{{ $goldLaw }}" disabled/>
                        </div>
                        <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                            <x-label>Factor:</x-label>
                            <x-input type="text" style="height:40px;width: 100%" value="{{ $goldFactor }}" disabled/>
                        </div>
                    </div>
                </div>
                <div id="Porcentajes_Pagables">
                    <div class="w-full py-2 mt-4 bg-gray-600">
                        <h1 class="text-lg text-center text-white">Porcentajes Pagables</h1>
                    </div>
                    <div class="grid grid-cols-3 mt-4">
                        <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                            <x-label>Cobre(%):</x-label>
                            <x-input type="text" style="height:40px;width: 100%" value="{{ $copperPayable }}" disabled/>
                        </div>
                        <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                            <x-label>Plata(%):</x-label>
                            <x-input type="text" style="height:40px;width: 100%" value="{{ $silverPayable }}" disabled/>
                        </div>
                        <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                            <x-label>Oro(%):</x-label>
                            <x-input type="text" style="height:40px;width: 100%" value="{{ $goldPayable }}" disabled/>
                        </div>
                    </div>
                </div>
                <div id="Requerimientos">
                    <div class="w-full py-2 mt-4 bg-gray-600">
                        <h1 class="text-lg text-center text-white">Requerimientos</h1>
                    </div>
                    <div class="grid grid-cols-3 mt-4">
                        <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                            <x-label>Protección Cobre:</x-label>
                            <x-input type="text" style="height:40px;width: 100%" value="{{ $copperProtection }}" disabled/>
                        </div>
                        <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                            <x-label>Protección Plata:</x-label>
                            <x-input type="text" style="height:40px;width: 100%" value="{{ $silverProtection }}" disabled/>
                        </div>
                        <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                            <x-label>Protección Oro:</x-label>
                            <x-input type="text" style="height:40px;width: 100%" value="{{ $goldProtection }}" disabled/>
                        </div>
                        <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                            <x-label>Deducción Cobre:</x-label>
                            <x-input type="text" style="height:40px;width: 100%" value="{{ $copperDeduction }}" disabled/>
                        </div>
                        <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                            <x-label>Deducción Plata:</x-label>
                            <x-input type="text" style="height:40px;width: 100%" value="{{ $silverDeduction }}" disabled/>
                        </div>
                        <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                            <x-label>Deducción Oro:</x-label>
                            <x-input type="text" style="height:40px;width: 100%" value="{{ $goldDeduction }}" disabled/>
                        </div>
                        <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                            <x-label>Refinamiento Cobre:</x-label>
                            <x-input type="text" style="height:40px;width: 100%" value="{{ $copperRefinement }}" disabled/>
                        </div>
                        <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                            <x-label>Refinamiento Plata:</x-label>
                            <x-input type="text" style="height:40px;width: 100%" value="{{ $silverRefinement }}" disabled/>

                            <x-input-error for="silverRefinement"/>

                        </div>
                        <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                            <x-label>Refinamiento Oro:</x-label>
                            <x-input type="text" style="height:40px;width: 100%" value="{{ $goldRefinement }}" disabled/>
                        </div>
                        <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                            <x-label>Maquila:</x-label>
                            <x-input type="text" style="height:40px;width: 100%" value="{{ $maquila }}" disabled/>
                        </div>
                        <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                            <x-label>Análisis:</x-label>
                            <x-input type="text" style="height:40px;width: 100%" value="{{ $analysis }}" disabled/>
                        </div>
                        <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                            <x-label>Estibadores:</x-label>
                            <x-input type="text" style="height:40px;width: 100%" value="{{ $stevedore }}" disabled/>
                        </div>
                    </div>
                </div>
                <div id="Penalidades">
                    <div class="w-full py-2 mt-4 bg-gray-600">
                        <h1 class="text-lg text-center text-white">Penalidades</h1>
                    </div>
                    <div class="grid grid-cols-3 mt-4 sm:grid-cols-6">
                        <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                            <x-label>Arsénico:</x-label>
                            <x-input type="text" style="height:40px;width: 100%" value="{{ $arsenicPenalty == '' ? '' : number_format($arsenicPenalty,3) }}" disabled/>
                        </div>
                        <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                            <x-label>Antiminio:</x-label>
                            <x-input type="text" style="height:40px;width: 100%" value="{{ $antomonyPenalty == '' ? '' : number_format($antomonyPenalty,3) }}" disabled/>
                        </div>
                        <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                            <x-label>Plomo:</x-label>
                            <x-input type="text" style="height:40px;width: 100%" value="{{ $leadPenalty == '' ? '' : number_format($leadPenalty,3) }}" disabled/>
                        </div>
                        <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                            <x-label>Zinc:</x-label>
                            <x-input type="text" style="height:40px;width: 100%" value="{{ $zincPenalty == '' ? '' : number_format($zincPenalty,3) }}" disabled/>
                        </div>
                        <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                            <x-label>Bismuto:</x-label>
                            <x-input type="text" style="height:40px;width: 100%" value="{{ $bismuthPenalty == '' ? '' : number_format($bismuthPenalty,3) }}" disabled/>
                        </div>
                        <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                            <x-label>Mercurio:</x-label>
                            <x-input type="text" style="height:40px;width: 100%" value="{{ $mercuryPenalty == '' ? '' : number_format($mercuryPenalty,3) }}" disabled/>
                        </div>
                    </div>
                </div>
                <div id="Maximo_Permitdo">
                    <div class="w-full py-2 mt-4 bg-gray-600">
                        <h1 class="text-lg text-center text-white">Máximo Permitido</h1>
                    </div>
                    <div class="grid grid-cols-3 mt-4 sm:grid-cols-6">
                        <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                            <x-label>Arsénico:</x-label>
                            <x-input type="text" style="height:40px;width: 100%" value="{{ $arsenicMaximum == '' ? : number_format($arsenicMaximum,3) }}" disabled/>
                        </div>
                        <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                            <x-label>Antiminio:</x-label>
                            <x-input type="text" style="height:40px;width: 100%" value="{{ $antomonyMaximum == '' ? : number_format($antomonyMaximum,3) }}" disabled/>
                        </div>
                        <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                            <x-label>Plomo:</x-label>
                            <x-input type="text" style="height:40px;width: 100%" value="{{ $leadMaximum == '' ? : number_format($leadMaximum,3) }}" disabled/>
                        </div>
                        <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                            <x-label>Zinc:</x-label>
                            <x-input type="text" style="height:40px;width: 100%" value="{{ $zincMaximum == '' ? : number_format($zincMaximum,3) }}" disabled/>
                        </div>
                        <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                            <x-label>Bismuto:</x-label>
                            <x-input type="text" style="height:40px;width: 100%" value="{{ $arsenicMaximum == '' ? : number_format($bismuthMaximum,3) }}" disabled/>
                        </div>
                        <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                            <x-label>Mercurio:</x-label>
                            <x-input type="text" style="height:40px;width: 100%" value="{{ $arsenicMaximum == '' ? : number_format($mercuryMaximum,3) }}" disabled/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-4xl text-center" wire:loading.flex>
                Cargando...
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-button class="ml-2" wire:loading.attr="disabled" wire:click="settle">
                Liquidar
            </x-button>
            <div wire:loading wire:target='settle'>
                Registrando...
            </div>
            <x-secondary-button wire:click="$set('open2',false)" class="ml-2">
                Regresar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
</div>
