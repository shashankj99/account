<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Requests\ReceiptRequest;
use App\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ReceiptController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    // function to direct user to the index page
    public function index(Request $request) {
        // check the type of method
        if ($request->method() == "POST") {
            // builder query
            $receipts = Receipt::query();

            // check if start date & end_date is not empty and query accordingly
            if ($request->start_date && $request->end_date) {
                $receipts->whereBetween('date', [$request->start_date, $request->end_date]);
            }

            // check if company is not empty and query accordingly
            if ($request->company) {
                $receipts->where('company_id', '=', $request->company);
            }

            // if user is admin then query all the rows else perform user specific queries
            if (Auth::user()->email == config('app.admin')) {
                $receipts = $receipts->get();
                $totalAmount = $receipts->sum('amount');
                $companies = Company::all();
            } else {
                $receipts = $receipts->where('user_id', '=', Auth::id())->get();
                $totalAmount = $receipts->where('user_id', Auth::id())->sum('amount');
                $companies = Company::where('user_id', Auth::id())->get();
            }
        
        // for get method conditional statements
        } else {
            if (Auth::user()->email == config('app.admin')) {
                $receipts = Receipt::all();
                $totalAmount = Receipt::sum('amount');
                $companies = Company::all();
            } else {
                $receipts = Receipt::where('user_id', Auth::id())->get();
                $totalAmount = Receipt::where('user_id', Auth::id())->sum('amount');
                $companies = Company::where('user_id', Auth::id())->get();
            }
        }

        // return user to the blade
        return view('journal.receipt.index')
            ->with('i', $i=0)
            ->with('receipts', $receipts)
            ->with('totalAmount', $totalAmount)
            ->with('companies', $companies);
    }

    // function to direct user to the credit blade
    public function create() {
        // create a new Receipt Instance and pass it to the view page
        $receipt = new Receipt();

        // get all the companies for admin and perform user specific query for non-admins
        $companies = (Auth::user()->email == config('app.admin')) ? Company::all() : Company::where('user_id', Auth::id())->get();

        return view('journal.receipt.create', compact('receipt', 'companies'));
    }

    // function to store data to the table
    public function store(ReceiptRequest $request) {
        try {
            $amount = ($request->debit > $request->credit) ? $request->debit-$request->credit : $request->credit-$request->debit;

            $request->user()->receipts()->create($request->validated()+['amount' => $amount]);

            Session::flash('success', "Receipt Entry is made successfully");
            return redirect()->route('receipt.index');
        } catch (\Exception $error) {
            Session::flash('error', $error->getMessage());
            return redirect()->back()->withInput();
        }
    }

    // this function doesn't exist
    public function show(Receipt $receipt) {
        Session::flash('info', "This URL doesn't exist");
        return redirect()->back();
    }

    // function to direct user to the edit blade
    public function edit(Receipt $receipt) {
        // get all the companies for admin and perform user specific query for non-admins
        $companies = (Auth::user()->email == config('app.admin')) ? Company::all() : Company::where('user_id', Auth::id())->get();

        return view('journal.receipt.edit', compact('receipt', 'companies'));
    }

    // function to update data in the table
    public function update(ReceiptRequest $request, Receipt $receipt) {
        try {
            $amount = ($request->debit > $request->credit) ? $request->debit-$request->credit : $request->credit-$request->debit;

            $receipt->update($request->validated()+['amount' => $amount, 'user_id' => Auth::id()]);

            Session::flash('success', "Receipt Entry is updated successfully");
            return redirect()->route('receipt.index');
        } catch (\Exception $error) {
            Session::flash('error', $error->getMessage());
            return redirect()->back()->withInput();
        }
    }

    // function to delete the data
    public function destroy(Receipt $receipt) {
        $receipt->delete();

        return response("The receipt ". $receipt->receipt_no. " for ". $receipt->company->name. " is deleted successfully");
    }
}
