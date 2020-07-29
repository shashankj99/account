<?php

namespace App\Http\Controllers;

use App\Company;
use App\Credit;
use App\Http\Requests\CreditRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CreditController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    // function to direct user to the index page
    public function index(Request $request) {
        // check the type of method
        if ($request->method() == "POST") {
            // builder query
            $credits = Credit::query();

            // check if start date & end_date is not empty and query accordingly
            if ($request->start_date && $request->end_date) {
                $credits->whereBetween('date', [$request->start_date, $request->end_date]);
            }

            // check if company is not empty and query accordingly
            if ($request->company) {
                $credits->where('company_id', '=', $request->company);
            }

            // if user is admin then query all the rows else perform user specific queries
            if (Auth::user()->email == config('app.admin')) {
                $credits = $credits->get();
                $totalAmount = $credits->sum('amount');
                $companies = Company::all();
            } else {
                $credits = $credits->where('user_id', '=', Auth::id())->get();
                $totalAmount = $credits->where('user_id', Auth::id())->sum('amount');
                $companies = Company::where('user_id', Auth::id())->get();
            }
        
        // for get method conditional statements
        } else {
            if (Auth::user()->email == config('app.admin')) {
                $credits = Credit::all();
                $totalAmount = Credit::sum('amount');
                $companies = Company::all();
            } else {
                $credits = Credit::where('user_id', Auth::id())->get();
                $totalAmount = Credit::where('user_id', Auth::id())->sum('amount');
                $companies = Company::where('user_id', Auth::id())->get();
            }
        }

        // return user to the blade
        return view('note.credit.index')
            ->with('i', $i=0)
            ->with('credits', $credits)
            ->with('totalAmount', $totalAmount)
            ->with('companies', $companies);
    }

    // function to direct user to the credit blade
    public function create() {
        // create a new Receipt Instance and pass it to the view page
        $credit = new Credit();

        // get all the companies for admin and perform user specific query for non-admins
        $companies = (Auth::user()->email == config('app.admin')) ? Company::all() : Company::where('user_id', Auth::id())->get();

        return view('note.credit.create', compact('credit', 'companies'));
    }

    // function to store data in the table
    public function store(CreditRequest $request) {
        try {
            $request->user()->credits()->create($request->validated() + ['qty' => $request->qty]);

            Session::flash('success', "Credit Note Entry is made successfully");
            return redirect()->route('credit.index');
        } catch (\Exception $error) {
            Session::flash('error', $error->getMessage());
            return redirect()->back()->withInput();
        }
    }

    // this function doesn't exist
    public function show(Credit $credit) {
        Session::flash('info', "This URL doesn't exist");
        return redirect()->back();
    }

    // function to direct user to the edit blade
    public function edit(Credit $credit) {
        // get all the companies for admin and perform user specific query for non-admins
        $companies = (Auth::user()->email == config('app.admin')) ? Company::all() : Company::where('user_id', Auth::id())->get();

        return view('note.credit.edit', compact('credit', 'companies'));
    }

    // function to update the data
    public function update(CreditRequest $request, Credit $credit) {
        try {
            $credit->update($request->validated()+['qty' => $request->qty, 'user_id' => Auth::id()]);

            Session::flash('success', "Credit Note Entry is updated successfully");
            return redirect()->route('credit.index');
        } catch (\Exception $error) {
            Session::flash('error', $error->getMessage());
            return redirect()->back()->withInput();
        }
    }

    // function to delete data from the table
    public function destroy(Credit $credit) {
        $credit->delete();

        return response('The credit note voucher '.$credit->credit_note_no.' for '.$credit->company->name.' is deleted successfully');
    }
}
