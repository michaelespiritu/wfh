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
}
