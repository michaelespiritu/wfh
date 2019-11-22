<?php

namespace App\Http\Controllers\Employer;

use App\Traits\CreditsTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cartalyst\Stripe\Laravel\Facades\Stripe;

class CreditController extends Controller
{
    use CreditsTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('credit.create', [
            'intent' => auth()->user()->createSetupIntent()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        if (!auth()->user()->stripe_id) {
           $create = Stripe::customers()->create(
                [
                    'name' => auth()->user()->name,
                    'email' => auth()->user()->email
                ]
            );

            auth()->user()->update(['stripe_id' => $create['id']]);
            Stripe::cards()->create($create['id'], request()->token['id']);
        }


        $charge = Stripe::charges()->create([
            'customer' => auth()->user()->stripe_id,
            'currency' => 'USD',
            'amount'   => 50.49,
        ]);

        $this->buyCredits(auth()->user(), request()->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return 'test';
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
