<div wire:ignore>
    <x-jet-dialog-modal wire:model="isOpenMapModal">
        <x-slot name="title">
            {{ __('Map') }}
        </x-slot>

        <x-slot name="content">
            <div id="map"></div>      
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('isOpenMapModal')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
