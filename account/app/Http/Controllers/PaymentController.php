<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Requests\PaymentRequest;
use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    // function to direct user to the index page
    public function index(Request $request) {
        // check the type of method
        if ($request->method() == "POST") {
            // builder query
            $payments = Payment::query();

            // check if start date & end_date is not empty and query accordingly
            if ($request->start_date && $request->end_date) {
                $payments->whereBetween('date', [$request->start_date, $request->end_date]);
            }

            // check if company is not empty and query accordingly
            if ($request->company) {
                $payments->where('company_id', '=', $request->company);
            }

            // if user is admin then query all the rows else perform user specific queries
            if (Auth::user()->email == config('app.admin')) {
                $payments = $payments->get();
                $totalAmount = $payments->sum('amount');
                $companies = Company::all();
            } else {
                $payments = $payments->where('user_id', '=', Auth::id())->get();
                $totalAmount = $payments->where('user_id', Auth::id())->sum('amount');
                $companies = Company::where('user_id', Auth::id())->get();
            }
        
        // for get method conditional statements
        } else {
            if (Auth::user()->email == config('app.admin')) {
                $payments = Payment::all();
                $totalAmount = Payment::sum('amount');
                $companies = Company::all();
            } else {
                $payments = Payment::where('user_id', Auth::id())->get();
                $totalAmount = Payment::where('user_id', Auth::id())->sum('amount');
                $companies = Company::where('user_id', Auth::id())->get();
            }
        }

        // return user to the blade
        return view('journal.payment.index')
            ->with('i', $i=0)
            ->with('payments', $payments)
            ->with('totalAmount', $totalAmount)
            ->with('companies', $companies);
    }

    // function to direct user to the credit blade
    public function create() {
        // create a new Receipt Instance and pass it to the view page
        $payment = new Payment();

        // get all the companies for admin and perform user specific query for non-admins
        $companies = (Auth::user()->email == config('app.admin')) ? Company::all() : Company::where('user_id', Auth::id())->get();

        return view('journal.payment.create', compact('payment', 'companies'));
    }

    
    // function to store data to the table
    public function store(PaymentRequest $request) {
        try {
            $amount = ($request->debit > $request->credit) ? $request->debit-$request->credit : $request->credit-$request->debit;

            $request->user()->payments()->create($request->validated()+['amount' => $amount]);

            Session::flash('success', "Payment Entry is made successfully");
            return redirect()->route('payment.index');
        } catch (\Exception $error) {
            Session::flash('error', $error->getMessage());
            return redirect()->back()->withInput();
        }
    }

    // this function doesn't exist
    public function show(Payment $payment) {
        Session::flash('info', "This URL doesn't exist");
        return redirect()->back();
    }

    // function to direct user to the edit blade
    public function edit(Payment $payment) {
        // get all the companies for admin and perform user specific query for non-admins
        $companies = (Auth::user()->email == config('app.admin')) ? Company::all() : Company::where('user_id', Auth::id())->get();

        return view('journal.payment.edit', compact('payment', 'companies'));
    }

    // function to update data in the table
    public function update(PaymentRequest $request, Payment $payment) {
        try {
            $amount = ($request->debit > $request->credit) ? $request->debit-$request->credit : $request->credit-$request->debit;

            $payment->update($request->validated()+['amount' => $amount, 'user_id' => Auth::id()]);

            Session::flash('success', "Payment Entry is updated successfully");
            return redirect()->route('payment.index');
        } catch (\Exception $error) {
            Session::flash('error', $error->getMessage());
            return redirect()->back()->withInput();
        }
    }

    // function to delete data in the table
    public function destroy(Payment $payment) {
        $payment->delete();

        return response("The payment voucher ". $payment->receipt_no. " for ". $payment->company->name. " is deleted successfully");
    }
}
