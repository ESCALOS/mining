<div>
    <x-dialog-modal wire:model='open'>
        <x-slot name="title">
            Registrar Concetrados
        </x-slot>
        <x-slot name="content">
            <div>
                <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                    <x-label>Concentrado:</x-label>
                    <x-input type="text" style="height:40px;width: 100%" wire:model="concentrate"/>

                    <x-input-error for="concentrate"/>

                </div>
                <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                    <x-label>Símbolo Químico:</x-label>
                    <x-input type="text" style="height:40px;width: 100%" wire:model="chemical_symbol"/>

                    <x-input-error for="chemical_symbol"/>

                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-button wire:loading.attr="disabled" wire:click="registrar">
                Guardar
            </x-button>
            <div wire:loading wire:target="registrar">
                Registrando...
            </div>
            <x-secondary-button wire:click="$set('open',false)" class="ml-2">
                Cerrar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
