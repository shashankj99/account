<?php

namespace App\Http\Controllers;

use App\Company;
use App\Sales;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SalesController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    // function to direct user to the index page
    public function index() {
        return view('invoice.sales.index')
            ->with('i', $i=0)
            ->with('sales', Sales::where('user_id', Auth::id())->get())
            ->with('totalAmount', Sales::where('user_id', Auth::id())->sum('amount'));
    }

    // function to direct user to the create page
    public function create(User $user) {
        // create a new Sales Instance and pass it to the view page
        $sale = new Sales();

        // get all the companies created by the user
        $companies = Company::where('user_id', Auth::id())->get();

        return view('invoice.sales.create', compact('sale', 'companies'));
    }

    // function to store data to the database
    public function store(Request $request) {
        $slicedArray = array_slice($request->all(), 2);

        $chunkedArray = array_chunk($slicedArray, 4);
        
        try {
            foreach ($chunkedArray as $array) {
                $formData = array(
                    'company_id' => $request->all()['company_id'],
                    'invoice_no' => $array[0],
                    'invoice_date' => $array[1],
                    'amount' => $array[2],
                    'type' => $array[3]
                );
                
                $request->user()->sales()->create($formData);
            }

            Session::flash('success', "Sales entry was made successfully");
            return redirect()->route('sales.index');

        } catch (\Exception $error) {
            Session::flash('error', $error->getMessage());
            return redirect()->back();
        }
    }


    public function show(Sales $sales)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function edit(Sales $sales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sales $sales)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sales $sales)
    {
        //
    }
}
