<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Account;
use Validator;
use Carbon\Carbon;
use Session;
use DB;
use File;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = DB::table('transaction')
        ->leftjoin('account', 'account.id_account', '=', 'transaction.id_pembeli')
        ->where("id_pembeli", Auth::user()->id_account)
        ->select("transaction.id_transaction", "transaction.subtotal", "transaction.pay", "transaction.deliver", "transaction.cancelled", "transaction.created_at", "account.fullname", "transaction.nota","transaction.date")
        ->orderby("date", "DESC")
        ->get();

        // $detail = DB::table('transaction_detail')
        // ->leftjoin('account', 'account.id_account', '=', 'transaction.id_pembeli')
        // ->where("id_transaction", $id)
        // ->select("transaction.id_transaction", "transaction.subtotal", "transaction.pay", "transaction.deliver", "transaction.cancelled", "transaction.created_at", "account.fullname", "transaction.nota","transaction.date")
        // ->orderby("date", "DESC")
        // ->get();

        // return view('pembelihistory/detail',compact('data'));

        return view('pembelihistory/index', compact('data'));
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
    public function detail($id)
    {
        //
        $data = DB::table('transaction_detail')
                  ->leftjoin('account', 'account.id_account', '=', 'transaction.id_pembeli')
                  ->where("id_transaction", $id)
                  ->select("transaction.id_transaction", "transaction.subtotal", "transaction.pay", "transaction.deliver", "transaction.cancelled", "transaction.created_at", "account.fullname", "transaction.nota","transaction.date")
                  ->orderby("date", "DESC")
                  ->get();

        return view('pembelihistory/detail',compact('data'));

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
