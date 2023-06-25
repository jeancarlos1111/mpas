<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}
    <x-button class="ml-4" wire:click="$set('open',true)">
    <i class="fa-solid fa-plus mt-1"></i>
    </x-button>

    <!-- Modal -->
    <x-dialog-modal wire:model="open">
        <x-slot name="title">
            Crear categoria
        </x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-label value="Nombre"/>
                <x-input type="text" wire:model.defer="name" class="w-full" />
                <x-input-error for="name" />
            </div>
            <div class="mb-4">
                <x-label value="Slug"/>
                <x-input type="text" wire:model.defer="slug" class="w-full" />
                <x-input-error for="slug" />
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button class="mr-1" wire:click="$set('open',false)">
                Cancelar
                <i class="fa-solid fa-xmark ml-1"></i>
            </x-secondary-button>
            <x-button wire:click.prevent="save" wire:loading.attr="disabled" wire:target="save" class="disabled:opacity-25">
                <span wire:loading.remove wire:target="save">
                    Guardar
                    <i class="fa-regular fa-floppy-disk ml-1"></i>
                </span>
                <span wire:loading.inline-flex wire:target="save">
                    Cargando...
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </span>
            </x-button>
        </x-slot>

    </x-dialog-modal>
</div>
