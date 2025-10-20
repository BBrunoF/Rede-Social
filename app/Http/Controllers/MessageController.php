<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; //To create file text
use Illuminate\Http\Request;


class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     * 
     */
    public function index(): Application|Factory|View
    {
        $authUserId = Auth::id();
        
        
        // Obter todos os chats do usuário autenticado
        $chats = Chat::where('user1_id', $authUserId)
                     ->orWhere('user2_id', $authUserId)
                     ->get();

        $unreadMessagesCounts = [];
        foreach ($chats as $chat) {
            $userId = $chat->user1_id == $authUserId ? $chat->user2_id : $chat->user1_id;
            $unreadMessagesCount = Message::where('chats_id', $chat->id)
                                          ->where('user_sent_id', $userId)
                                          ->where('is_read', 'sent')
                                          ->count();
            $unreadMessagesCounts[$chat->id] = $unreadMessagesCount;
        }
        

        // Mapeamento dos chats para os usuários correspondentes e associando o chat_id
        $userIds = $chats->map(function ($chat) use ($authUserId) {
            return $chat->user1_id == $authUserId ? $chat->user2_id : $chat->user1_id;
        });
    
        $users = User::whereIn('id', $userIds)->get();

        return view('messages.index', compact('chats', 'users','unreadMessagesCounts'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     * @param $chatId
     */
    public function show($chatId): Application|Factory|View
{
    $authUserId = Auth::id();
    $chat = Chat::findOrFail($chatId);

    // Verificar se o usuário autenticado faz parte do chat
    if ($chat->user1_id != $authUserId && $chat->user2_id != $authUserId) {
        return redirect()->route('messages.index')->with('error', 'Você não tem permissão para acessar este chat.');
    }

    // Obter o usuário com quem o usuário autenticado está conversando
    $userId = $chat->user1_id == $authUserId ? $chat->user2_id : $chat->user1_id;
    $user = User::findOrFail($userId);

    // Obter as mensagens do chat
    $messages = Message::where('chats_id', $chat->id)->orderBy('created_at', 'asc')->get();
    foreach($messages as $message){
        if($message->user_sent_id != Auth::id()){
            $message->update(['is_read' => 'seen']);
        }
    }

    // Obter todos os usuários com quem o usuário autenticado tem chats
    $chats = Chat::where('user1_id', $authUserId)
                 ->orWhere('user2_id', $authUserId)
                 ->get();
    $unreadMessagesCounts = [];
        foreach ($chats as $chatOthers) {
            $otherUserId = $chatOthers->user1_id == $authUserId ? $chatOthers->user2_id : $chatOthers->user1_id;
            $unreadMessagesCount = Message::where('chats_id', $chatOthers->id)
                                          ->where('user_sent_id', $otherUserId)
                                          ->where('is_read', 'sent')
                                          ->count();
            $unreadMessagesCounts[$chatOthers->id] = $unreadMessagesCount;
        }

    $userIds = $chats->map(function ($chat) use ($authUserId) {
        return $chat->user1_id == $authUserId ? $chat->user2_id : $chat->user1_id;
    });

    $users = User::whereIn('id', $userIds)->get();


    return view('messages.show', compact('messages', 'user', 'chat', 'users','chats', 'chatId','unreadMessagesCounts')); // Passando $chatId para a view
}
    /**
     * Display a listing of the resource.
     *
     * @return void
     * @param Request $request
     * @param $authUserId
     * @param $otherUser
     * 
     */
    public function createChat(Request $request, $authUserId, $otherUser)
    {
        // Verificar se já existe um chat entre os usuários
        $chat = Chat::where(function ($query) use ($authUserId, $otherUser) {
            $query->where('user1_id', $authUserId)
                  ->where('user2_id', $otherUser);
        })->orWhere(function ($query) use ($authUserId, $otherUser) {
            $query->where('user1_id', $otherUser)
                  ->where('user2_id', $authUserId);
        })->first();

        // Se não existir chat, criar um novo
        if (!$chat) {
            $chat = Chat::create([
                'user1_id' => $authUserId,
                'user2_id' => $otherUser,
            ]);
        }

        return redirect()->route('messages.show', ['chatId' => $chat->id]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return void
     * @param Request $request
     * @param $chatId
     * 
     */
    public function send(Request $request, $chatId)
{
    if(!auth()->user()->isBanned()){
    $request->validate([
        'message' => 'nullable|string'
    ]);

    $authUserId = Auth::id();

    if ($request->message) {
        Message::create([
            'chats_id' => $chatId,
            'user_sent_id' => $authUserId,
            'message' => $request->message,
        ]);
    }
    return redirect()->route('messages.show', ['chatId' => $chatId]);
} else {
    session()->flash('message.error', "You are banned");
    return redirect()->route('messages.show', ['chatId' => $chatId]);
}

}


    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     * 
     */
    public function showChats(): Application|Factory|View
    {
        $authUserId = Auth::id();

        // Obter todos os chats do usuário autenticado
        $chats = Chat::where('user1_id', $authUserId)
                     ->orWhere('user2_id', $authUserId)
                     ->get();

        // Obter todos os usuários com quem o usuário autenticado tem chats
        $userIds = $chats->map(function ($chat) use ($authUserId) {
            return $chat->user1_id == $authUserId ? $chat->user2_id : $chat->user1_id;
        });

        $users = User::whereIn('id', $userIds)->get();

        return view('messages.chat', ['users' => $users, 'user' => $authUserId]);
    }
}