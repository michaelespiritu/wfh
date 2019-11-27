<?php

namespace App\Http\Controllers\Employer;

use Exception;
use App\Model\Job;
use App\Traits\JobsTrait;
use App\Traits\CreditsTrait;
use Illuminate\Http\Request;
use App\Traits\PaymentsTrait;
use App\Http\Controllers\Controller;

class CreditController extends Controller
{
    use CreditsTrait, PaymentsTrait, JobsTrait;

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
        return view('credit.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $amount = request()->credit * 5;

        $payment = $this->createPayment(auth()->user(), $amount);

        if (!$payment['pass']) {
            return response()->json([
                'message' => $payment['message']
            ], 500);
        }

        $this->buyCredits(auth()->user(), request()->all());

        $this->checkForTargetToBeUpdate(request()->target, auth()->user()->fresh());

        return response()->json([
            'success' => 'Your card has been charged and Your Credit has been Adjusted.'
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
