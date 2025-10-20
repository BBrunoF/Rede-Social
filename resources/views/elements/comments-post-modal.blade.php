<!-- Delete User Comment Modal -->
        <x-jet-dialog-modal wire:model="isOpenCommentModal">
            <x-slot name="title">
                {{ __('Comments') }}
            </x-slot>

            <x-slot name="content">
            
            @if(session()->has('comment.error'))
            <div class="bg-red-100 border my-3 border-red-400 text-red-700 dark:bg-red-700 dark:border-red-600 dark:text-red-100 px-4 py-3 rounded relative" role="alert">
				  <span class="block sm:inline text-center">{{ session()->get('comment.error') }}</span>
			</div>
            @endif
            
            <form wire:submit.prevent="createComment({{ $postId }})" >
                <div class="mt-4" >
                    <textarea class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block" wire:model.lazy="comment"
                                cols=65 rows=5 placeholder="{{ __('Your comment') }}"> </textarea>
                    <x-jet-input-error for="comment" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('isOpenCommentModal')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>

                <x-jet-button class="ml-2" wire:loading.attr="disabled">
                    {{ __('Post Comment') }}
                </x-jet-button>
                </form>
                </x-slot>
            
            <x-slot name="comments">
              
           
            @forelse($comments as $comment)
            @if($comment->user->role_id != 3)
			        <div class="flex space-x-2 my-3">
                <a href="{{ route('profile', ['username' => $comment->user->username]) }}" class="hover:underline text-sm">
                <img class="inline-block object-cover w-8 h-8 mr-1 text-white rounded-full shadow-sm cursor-pointer" src="{{ $comment->user->profile_photo_url }}" alt="{{ $comment->user->name }}" />
                </a>
                <div class="block">
                  <div class="bg-gray-100 w-auto rounded-xl px-2 pb-2">
                    <div class="font-medium">
                      <a href="{{ route('profile', ['username' => $comment->user->username]) }}" class="hover:underline text-sm">
                        <span class="text-xs font-semibold">{{ $comment->user->name }}</span>
                      </a>
                    </div>
                    <div class="text-xs">
                      {{ $comment->comment }}
                    </div>
                  </div>
                  <div class="flex justify-start items-center text-xs w-full">
                    <div class="font-semibold text-gray-700 px-2 flex items-center justify-center space-x-1">
                      
                      @can('delete', $comment)
                      <button class="" wire:click="deleteComment({{ $post->id }}, {{ $comment->id }})">
                        <small>Delete</small>
                      </button>
                      @endcan
                      <small class="self-center">.</small>
                        <small>{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</small>
                    </div>
                  </div>
                </div>
              </div>
              @endif
              @empty
		             No Comments found
              @endforelse
              </x-slot>
        </x-jet-dialog-modal>