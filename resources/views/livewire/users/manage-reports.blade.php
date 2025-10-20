
<div x-data="{ open: false, selectedReport: null }">
    <div class="flex flex-col p-4">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg rounded-xl shadow-sm">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Reporter
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Reported
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Reason
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($reports as $report)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('profile', ['username' => $report->reporter->username]) }}">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full" src="{{ $report->reporter->profile_photo_url }}" alt="">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $report->reporter->name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ $report->reporter->email }}
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('profile', ['username' => $report->reported->username]) }}">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full" src="{{ $report->reported->profile_photo_url }}" alt="">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $report->reported->name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ $report->reported->email }}
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap max-w-xs">
                                        <div class="overflow-hidden overflow-ellipsis whitespace-nowrap">
                                            {{ $report->report_reason }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div>
                                        <a href="#" class="text-blue-600 hover:text-blue-900" @click.prevent="open = true; selectedReport = {{ $report->toJson() }}">View</a>
                                        <button wire:click="solveReport({{ $report->id }})" class="text-green-600 hover:text-red-900 ml-4"  wire:offline.attr="disabled">Solve</button>
                                        @if($report->reported->role_id!=3)
                                        <button wire:click="banUser({{ $report->reported_id }})" class="text-red-600 hover:text-red-900 ml-4"  wire:offline.attr="disabled">Ban</button>
                                        @else
                                        <button wire:click="unbanUser({{ $report->reported_id }})" class="text-gray-600 hover:text-red-900 ml-4"  wire:offline.attr="disabled">Unban</button>
                                        @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $reports->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div x-show="open" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="open" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="open" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Report Details
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    <strong>Reporter:</strong> <span x-text="selectedReport.reporter.name"></span><br>
                                    <strong>Reported:</strong> <span x-text="selectedReport.reported.name"></span><br>
                                    <strong>Reason:</strong> <span x-text="selectedReport.report_reason"></span><br>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <x-jet-secondary-button @click="open = false">
                        {{ __('Cancel') }}
                    </x-jet-secondary-button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

