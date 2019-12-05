<?php

namespace App\Http\Controllers\Account;

use App\Model\Conversation;
use Illuminate\Http\Request;
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
