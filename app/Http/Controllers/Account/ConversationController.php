<?php

namespace App\Http\Controllers\Account;

use App\Model\Message;
use App\Model\Conversation;
use App\Traits\MessagesTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\ConversationResource;

class ConversationController extends Controller
{
    use MessagesTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('conversation.all');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $conversation = $this->startConversation(auth()->user(), request()->all());

        $this->createMessage($conversation, request()->message, auth()->user()->id);

        $this->attachMembersToConversation($conversation, request()->receiver_id);
    }

    /**
     * Store a newly created reply for conversation.
     * @return \Illuminate\Http\Response
     */
    public function reply(Conversation $conversation)
    {
        $this->createMessage($conversation, request()->message, auth()->user()->id);

        return response()->json([
            'conversations' => auth()->user()->accessibleConversations(),
            'conversation' => ConversationResource::make($conversation->fresh())
        ]);
    }

    /**
     * Mark the conversation as read.
     * @return \Illuminate\Http\Response
     */
    public function read(Conversation $conversation)
    {
        $this->markAsRead($conversation);

        return response()->json([
            'conversation' => auth()->user()->unread_messages,
            'conversations' => auth()->user()->accessibleConversations(),
        ]);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
