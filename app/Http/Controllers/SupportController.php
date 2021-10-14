<?php

namespace App\Http\Controllers;

use Payvice;
use App\Vice;
use App\Account;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\HttpRequests;
use \GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\VasFourOperations;

class SupportController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSupport(Request $request){
		$data['UserDetails'] = $this->getUserDetails($request);
		$walletId = $data['UserDetails']['wallet_id'];
		$userEmail = $data['UserDetails']['email'];
		// Get Wallet Balance Details
		$balanceDetails = Account::balance($walletId, $userEmail);
		$balanceDetails = (array) $balanceDetails;
		$data['balance'] = number_format($balanceDetails['balance']);
		$data['commissionBalance'] = number_format($balanceDetails['commission']);
		$URI= 'paybills';
		// return view($URI)->with($data);
        return view('support',$data);

	}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
