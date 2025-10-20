
<div class="container px-3 mx-auto grid bg-gray-100">
    <style>
        input, textarea, button, select, a { -webkit-tap-highlight-color: rgba(0,0,0,0); }
        button:focus { outline:0 !important; }
    </style>

    <!-- component -->
    <div class="bg-white my-12 pb-6 w-full justify-center items-center overflow-hidden md:max-w-sm rounded-lg shadow-sm mx-auto shadow">
        <div class="relative h-40">
            <img class="absolute h-full w-full object-cover" src="https://images.unsplash.com/photo-1448932133140-b4045783ed9e?ixlib=rb-1.2.1&auto=format&fit=crop&w=400&q=80">
        </div>
        <div class="relative shadow mx-auto h-24 w-24 -my-12 border-white rounded-full overflow-hidden border-4">
            @if($user->role_id===3)

            @else
            <img class="object-cover w-full h-full" src="{{ $user->profile_photo_url }}">
            @endif
        </div>
    
        <div class="mt-16">
            <h1 class="text-lg text-center font-semibold">
                {{ $user->name }}
            </h1>
            <p class="text-sm text-gray-600 text-center">
                {{ '@' . $user->username }}
            </p>
            <div class="mx-auto text-center my-3 flex items-center justify-center">
                @can('is-not-user-profile', $user)
                    @if($user->isFollowed->count())
                        <button type="button" wire:click="incrementFollow({{ $user->id }})" class="px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-md active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red mr-2">
                            <span wire:loading wire:target="incrementFollow({{ $user->id }})">Unfollowing...</span>
                            <span wire:loading.remove wire:target="incrementFollow({{ $user->id }})">Unfollow</span>
                        </button>
                    @else
                        <button type="button" wire:click="incrementFollow({{ $user->id }})" class="px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple mr-2">
                            <span wire:loading wire:target="incrementFollow({{ $user->id }})">Following...</span>
                            <span wire:loading.remove wire:target="incrementFollow({{ $user->id }})">Follow</span>
                        </button>
                    @endif
                
                    <form method="POST" action="{{ route('messages.createChat', ['authUserId' => Auth::user()->id, 'otherUser' => $user->id]) }}" class="mr-2">
                        @csrf
                        <button type="submit" class="px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                            <span>Send Message</span>
                        </button>
                    </form>
                    <button type="button" wire:click="$toggle('isOpenReportModal')" class="px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-md active:bg-purple-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-purple mr-2">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z"/>
                            </svg>
                        </span>
                    </button>
					@include('elements.report-profile-modal')
                @endcan
            </div>
            @if($user->role_id===3)
            <div class="mx-auto text-center flex items-center justify-center">
                <div class="bg-red-100 border text-center border-red-400 text-red-700 dark:bg-red-700 dark:border-red-600 dark:text-red-100  rounded relative" role="alert" style="padding: 0.5rem;">
                    <span class="block sm:inline text-center text-sm">User Banned</span>
                </div>
            </div>            
            @endif            
        </div>

        <div class="mt-6 pt-3 flex flex-wrap mx-6 border-t">
            <div class="py-4 flex justify-center items-center w-full divide-x divide-gray-400 divide-solid">
                <span class="text-center px-4">
                    <span class="font-bold text-gray-700">{{ $followersCount }}</span>
                    <span class="text-gray-600">Followers</span>
                </span>
                <span class="text-center px-4">
                    <span class="font-bold text-gray-700">{{ $followingsCount }}</span>
                    <span class="text-gray-600">Followings</span>
                </span>

                <span class="text-center px-4">
                    <span class="font-bold text-gray-700"> {{ $postsCount }} </span>
                    <span class="text-gray-600">Posts</span>
                </span>
            </div>
        </div>
    </div>
</div>

