<?php

namespace App\Http\Controllers\Account;

use App\Model\UserMeta;
use App\Traits\UserTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserMetaValidator;

class MetaDataController extends Controller
{
    use UserTrait;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserMetaValidator $request)
    {   
        $this->createUserMeta(auth()->user(), $request->all());

        return response()->json([
            'success' => 'Information has been updated.'
        ], 201);
    }

}
