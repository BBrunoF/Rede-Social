<x-app-layout>
    <div class="container mx-auto flex flex-col md:flex-row md:space-x-4">
        <div class="w-full md:w-4/12 bg-gray-100 rounded-lg shadow-md overflow-y-auto p-4 fixed-height">
            <h3 class="font-semibold text-gray-700 mb-4">Conversas</h3>
            <ul class="list-group rounded-lg">
                @foreach($chats as $individualChat)
                    @foreach($users as $userChat)
                    @if (($userChat->id == $individualChat->user1_id or $userChat->id == $individualChat->user2_id))
                    @if($unreadMessagesCounts[$individualChat->id]>0)
                    <a href="{{ route('messages.show', ['chatId' => $individualChat->id]) }}">  
                        <li class="list-group-item hover:bg-gray-200 flex h-full items-center py-3">
                            <div class="w-10 h-10 mr-3 rounded-full overflow-hidden">
                                <img src="{{ $userChat->profile_photo_url }}" alt="Avatar" class="w-full h-full object-cover">
                            </div>
                            <a href="{{ route('messages.show', ['chatId' => $individualChat->id]) }}" class="flex-grow text-bold text-gray-700 font-medium">  
                                    <b>{{ $userChat->name }}</b>
                            </a>
                            <div class="flex items-center justify-center w-6 h-6 rounded-full bg-red-500 text-white ml-2">
                                <span class="text-xs font-bold">{{ $unreadMessagesCounts[$individualChat->id] }}</span>
                            </div>
                        </li>
                    </a>
                    @else
                    <a href="{{ route('messages.show', ['chatId' => $individualChat->id]) }}">  
                        <li class="list-group-item hover:bg-gray-200 flex h-full items-center py-3">
                            <div class="w-10 h-10 mr-3 rounded-full overflow-hidden">
                                <img src="{{ $userChat->profile_photo_url }}" alt="Avatar" class="w-full h-full object-cover">
                            </div>
                            <a href="{{ route('messages.show', ['chatId' => $individualChat->id]) }}" class="flex-grow text-bold text-gray-700 font-medium">  
                                    {{ $userChat->name }}
                            </a>
                        </li>
                    </a>
                    @endif
                    @endif
                    @endforeach
                @endforeach
            </ul>
        </div>
  
        <div class="w-full md:w-8/12 bg-white rounded-lg shadow-md p-4 mt-4 md:mt-0 flex flex-col fixed-height">
            <a href="{{ route('profile', ['username' => $user->username]) }}">
                <div class="card-header flex justify-between items-center mb-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 mr-3 rounded-full overflow-hidden">
                            <img src="{{ $user->profile_photo_url }}" alt="Avatar" class="w-full h-full object-cover">
                        </div>
                        <h3 class="font-semibold text-gray-700">{{$user->name}}</h3>
                    </div>
                </div>
            </a>
            @if(session()->has('message.error'))
            <div class="bg-red-100 border my-3 border-red-400 text-red-700 dark:bg-red-700 dark:border-red-600 dark:text-red-100 px-4 py-3 rounded relative" role="alert">
				  <span class="block sm:inline text-center">{{ session()->get('message.error') }}</span>
			</div>
            @endif
            <div class="chat-box overflow-y-auto pb-8 px-4" id="scrollable">
                @foreach($messages as $message)
                    <div class="message flex items-start mb-4 {{ $message->user_sent_id == Auth::id() ? 'justify-end' :  '' }}">
                        <div class="chat-bubble rounded-lg p-4 shadow-sm max-w-3xl {{ $message->user_sent_id == Auth::id() ? 'bg-purple-500 text-white' : 'bg-gray-200 text-black' }}">
                            <p>{{ $message->message }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <form id="message-form" action="{{ route('messages.send', ['chatId' => $chatId]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="flex items-center border-t border-gray-200 pt-4 px-4">
                    <textarea name="message" id="message" rows="2" placeholder="Message" class="w-full px-3 py-2 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block"></textarea>
                    <button id="sendButton"type="submit" class="ml-4 bg-purple-500 text-white px-4 py-2 rounded-md hover:bg-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-500">
                        Send
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        window.onload = function() {
            var scrollable = document.getElementById('scrollable');
            scrollable.scrollTop = scrollable.scrollHeight;
        };
    </script>
    <style>
        .container {
            height: calc(100vh - 5rem); /* Adjust as needed */
        }
        .fixed-height {
            height: calc(50vh - 2rem); /* Adjust as needed */
        }
        .chat-box {
            flex-grow: 1;
            overflow-y: auto;
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

        @media (min-width: 768px) {
            .fixed-height {
                height: 100%;
            }
        }
    </style>
</x-app-layout>
<script>
	var input = document.getElementById("message");
	input.addEventListener("keypress", function(event) {
	  if (event.key === "Enter") {
		event.preventDefault();
		document.getElementById("sendButton").click();
	  }
	});
	</script>
