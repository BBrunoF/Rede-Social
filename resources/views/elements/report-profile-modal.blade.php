<x-jet-dialog-modal wire:model="isOpenReportModal">
    <x-slot name="title">
        {{ __('Report') }}  {{ $user->name }}
    </x-slot>
    <x-slot name="content">
        @if(session()->has('report.error'))
            <div class="bg-red-100 border my-3 border-red-400 text-red-700 dark:bg-red-700 dark:border-red-600 dark:text-red-100 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline text-center">{{ session()->get('report.error') }}</span>
            </div>
        @endif

        <form wire:submit.prevent="createReport({{ $user->id }})">
            <div class="mt-4">
                <textarea class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block" wire:model.lazy="report" cols=65 rows=5 placeholder="{{ __('Your Reason') }}"></textarea>
                <x-jet-input-error for="report" class="mt-2" />
            </div>
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$toggle('isOpenReportModal')" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-jet-secondary-button>

        <x-jet-button class="ml-2" wire:loading.attr="disabled">
            {{ __('Report User') }}
        </x-jet-button>
    </form>
    </x-slot>
</x-jet-dialog-modal>
