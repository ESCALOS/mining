<div>
    <x-dialog-modal wire:model='open' maxWidth="2xl">
        <x-slot name="title">
            Registrar Órdenes
        </x-slot>
        <x-slot name="content">
            <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                <x-label>Archivo excel:</x-label>
                <input type="file" style="height:40px;width: 100%" wire:model="archivo" id="i{{ $file_number }}"/>

                <x-input-error for="archivo"/>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div wire:loading.remove>
                <x-button wire:click="importar">
                    <h1>Importar</h1>
                </x-button>
            </div>
            <x-button wire:loading.flex>
                <h1>Cargando...</h1>
            </x-button>
            <x-secondary-button wire:click="$set('open',false)" class="ml-2">
                Cancelar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
