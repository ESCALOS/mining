<div>
    <x-dialog-modal wire:model='open'>
        <x-slot name="title">
            Registrar Usuarios
        </x-slot>
        <x-slot name="content">
            <div>
                <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                    <x-label>Nombre:</x-label>
                    <x-input type="text" style="height:40px;width: 100%" wire:model="name"/>

                    <x-input-error for="name"/>

                </div>
                <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                    <x-label>Correo Electrónico:</x-label>
                    <x-input type="text" style="height:40px;width: 100%" wire:model="email"/>

                    <x-input-error for="email"/>

                </div>
                <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
                    <x-label>Correo Electrónico:</x-label>
                    <select class="form-control" style="width: 100%" wire:model='role'>
                        <option value="1">Administrador</option>
                        <option value="2">Colaborador</option>
                    </select>

                    <x-input-error for="role"/>

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
