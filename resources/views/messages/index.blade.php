<x-app-layout>
    <div class="container mx-auto flex flex-col md:flex-row md:space-x-4">
        <div class="w-full md:w-4/12 bg-gray-100 rounded-lg shadow-md overflow-y-auto p-4">
            <h3 class="font-semibold text-gray-700 mb-4">Conversas</h3>
            <ul class="list-group rounded-lg">
                @foreach($chats as $individualChat)
                    @foreach($users as $userChat)
                    @if ($userChat->id == $individualChat->user1_id or $userChat->id == $individualChat->user2_id)
                    @if($unreadMessagesCounts[$individualChat->id]>0)
                        <li class="list-group-item hover:bg-gray-200 flex items-center py-3">
                            <div class="w-10 h-10 mr-3 rounded-full overflow-hidden">
                                <img src="{{ $userChat->profile_photo_url }}" alt="Avatar" class="w-full h-full object-cover">
                            </div>
                            <a href="{{ route('messages.show', ['chatId' => $individualChat->id]) }}" class="flex-grow text-gray-700 font-medium">  
                                    <b>{{ $userChat->name }}</b>
                            </a>
                            <div class="flex items-center justify-center w-6 h-6 rounded-full bg-red-500 text-white ml-2">
                              <span class="text-xs font-bold">{{ $unreadMessagesCounts[$individualChat->id] }}</span>
                          </div>
                        </li>
                         @else
                         <li class="list-group-item hover:bg-gray-200 flex items-center py-3">
                          <div class="w-10 h-10 mr-3 rounded-full overflow-hidden">
                              <img src="{{ $userChat->profile_photo_url }}" alt="Avatar" class="w-full h-full object-cover">
                          </div>
                          <a href="{{ route('messages.show', ['chatId' => $individualChat->id]) }}" class="flex-grow text-gray-700 font-medium">  
                                {{ $userChat->name }}
                          </a>
                      </li>
                        @endif
                        @endif
                    @endforeach
                @endforeach
            </ul>
        </div>
    </div>
  
    <style>
        .container {
            height: calc(100vh - 5rem); /* Adjust as needed */
        }
      .chat-box {
        max-height: 500px;
        display: flex;
        flex-direction: column-reverse;
      }
      .message {
        margin-bottom: 10px;
      }
      .chat-bubble {
        padding: 10px;
        border-radius: 5px;
        max-width: 70%;
        word-wrap: break-word;
      }
      .chat-box::-webkit-scrollbar {
        width: 8px;
      }
      .chat-box::-webkit-scrollbar-thumb {
        background-color: #bbb;
        border-radius: 10px;
      }
      .chat-box::-webkit-scrollbar-track {
        background: transparent;
      }
    </style>
</x-app-layout>