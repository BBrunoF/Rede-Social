<div class="relative p-2 w-full">
    <input
        type="text"
        class="form-input w-full rounded-lg border border-gray-300 focus:border-gray-500"
        placeholder="Search Users"
        wire:model="term"
    />

    @if(!empty($term))
        <div class="absolute" style="width: 93%;">
            <div class="bg-white rounded-lg shadow" style="width: 100%; min-height: 3rem;">
                @if(!empty($users))
                    <ul class="divide-y-2 divide-gray-100 rounded-lg w-full">
                        @foreach($users as $i => $user)
                            <li class="p-2 hover:bg-gray-200 w-full">
                                <a
                                    href="{{ route('profile', $user['username']) }}"
                                    class="flex items-center space-x-2"
                                >
                                    <img class="h-6 w-6 rounded-full object-cover" src="{{ $user['profile_photo_url'] }}" />
                                    <span>{{ $user['name'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="p-2">No results!</div>
                @endif
            </div>
        </div>
    @endif
</div>
