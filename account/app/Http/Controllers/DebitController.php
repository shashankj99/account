<?php

namespace App\Http\Controllers;

use App\Company;
use App\Debit;
use App\Http\Requests\DebitRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DebitController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    // function to direct user to the index page
    public function index(Request $request) {
        // check the type of method
        if ($request->method() == "POST") {
            // builder query
            $debits = Debit::query();

            // check if start date & end_date is not empty and query accordingly
            if ($request->start_date && $request->end_date) {
                $debits->whereBetween('date', [$request->start_date, $request->end_date]);
            }

            // check if company is not empty and query accordingly
            if ($request->company) {
                $debits->where('company_id', '=', $request->company);
            }

            // if user is admin then query all the rows else perform user specific queries
            if (Auth::user()->email == config('app.admin')) {
                $debits = $debits->get();
                $totalAmount = $debits->sum('amount');
                $companies = Company::all();
            } else {
                $debits = $debits->where('user_id', '=', Auth::id())->get();
                $totalAmount = $debits->where('user_id', Auth::id())->sum('amount');
                $companies = Company::where('user_id', Auth::id())->get();
            }
        
        // for get method conditional statements
        } else {
            if (Auth::user()->email == config('app.admin')) {
                $debits = Debit::all();
                $totalAmount = Debit::sum('amount');
                $companies = Company::all();
            } else {
                $debits = Debit::where('user_id', Auth::id())->get();
                $totalAmount = Debit::where('user_id', Auth::id())->sum('amount');
                $companies = Company::where('user_id', Auth::id())->get();
            }
        }

        // return user to the blade
        return view('note.debit.index')
            ->with('i', $i=0)
            ->with('debits', $debits)
            ->with('totalAmount', $totalAmount)
            ->with('companies', $companies);
    }

    // function to direct user to the credit blade
    public function create() {
        // create a new Receipt Instance and pass it to the view page
        $debit = new Debit();

        // get all the companies for admin and perform user specific query for non-admins
        $companies = (Auth::user()->email == config('app.admin')) ? Company::all() : Company::where('user_id', Auth::id())->get();

        return view('note.debit.create', compact('debit', 'companies'));
    }

    // function to store data in the table
    public function store(DebitRequest $request) {
        try {
            $request->user()->debits()->create($request->validated() + ['qty' => $request->qty]);

            Session::flash('success', "Debit Note Entry is made successfully");
            return redirect()->route('debit.index');
        } catch (\Exception $error) {
            Session::flash('error', $error->getMessage());
            return redirect()->back()->withInput();
        }
    }

    // this function doesn't exist
    public function show(Debit $debit) {
        Session::flash('info', "This URL doesn't exist");
        return redirect()->back();
    }

    // function to direct user to the edit blade
    public function edit(Debit $debit) {
        // get all the companies for admin and perform user specific query for non-admins
        $companies = (Auth::user()->email == config('app.admin')) ? Company::all() : Company::where('user_id', Auth::id())->get();

        return view('note.debit.edit', compact('debit', 'companies'));
    }

    // function to update the data
    public function update(DebitRequest $request, Debit $debit) {
        try {
            $debit->update($request->validated()+['qty' => $request->qty, 'user_id' => Auth::id()]);

            Session::flash('success', "Debit Note Entry is updated successfully");
            return redirect()->route('debit.index');
        } catch (\Exception $error) {
            Session::flash('error', $error->getMessage());
            return redirect()->back()->withInput();
        }
    }

    // function to delete data from the table
    public function destroy(Debit $debit) {
        $debit->delete();

        return response('The debit note voucher '.$debit->debit_note_no.' for '.$debit->company->name.' is deleted successfully');
    }
}
