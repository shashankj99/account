<?php

namespace App\Http\Controllers;

use App\Company;
use App\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PurchaseController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    // function to direct user to the index page
    public function index(Request $request) {
        // check the type of method
        if ($request->method() == "POST") {
            // builder query
            $purchases = Purchase::query();

            // check if start date & end_date is not empty and query accordingly
            if ($request->start_date && $request->end_date) {
                $purchases->whereBetween('invoice_date', [$request->start_date, $request->end_date]);
            }

            // check if company is not empty and query accordingly
            if ($request->company) {
                $purchases->where('company_id', '=', $request->company);
            }

            // insure the tax type is either 0 or 1 and query accordingly
            if ($request->tax_type != null) {
                $purchases->where('type', '=', $request->tax_type);
            }

            // if user is admin then query all the rows else perform user specific queries
            if (Auth::user()->email == config('app.admin')) {
                $purchases = $purchases->get();
                $totalAmount = $purchases->sum('amount');
                $companies = Company::all();
            } else {
                $purchases = $purchases->where('user_id', '=', Auth::id())->get();
                $totalAmount = $purchases->where('user_id', Auth::id())->sum('amount');
                $companies = Company::where('user_id', Auth::id())->get();
            }
        
        // for get method conditional statements
        } else {
            if (Auth::user()->email == config('app.admin')) {
                $purchases = Purchase::all();
                $totalAmount = Purchase::sum('amount');
                $companies = Company::all();
            } else {
                $purchases = Purchase::where('user_id', Auth::id())->get();
                $totalAmount = Purchase::where('user_id', Auth::id())->sum('amount');
                $companies = Company::where('user_id', Auth::id())->get();
            }
        }

        // return user to the blade
        return view('invoice.purchase.index')
            ->with('i', $i=0)
            ->with('purchases', $purchases)
            ->with('totalAmount', $totalAmount)
            ->with('companies', $companies);
    }

    // function to direct user to the create page
    public function create() {
        // create a new purchase Instance and pass it to the view page
        $purchase = new Purchase();

        // get all the companies for admin and perform user specific query for non-admins
        $companies = (Auth::user()->email == config('app.admin')) ? Company::all() : Company::where('user_id', Auth::id())->get();

        return view('invoice.purchase.create', compact('purchase', 'companies'));
    }

    // function to store data to the purchase table
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
                
                $request->user()->purchases()->create($formData);
            }

            Session::flash('success', "Purchase entry was made successfully");
            return redirect()->route('purchase.index');

        } catch (\Exception $error) {
            Session::flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    // this function doesn't exist
    public function show(Purchase $purchase) {
        Session::flash('info', "This URL doesn't exist");
        return redirect()->back();
    }

    // function to direct user to the edit blade
    public function edit(Purchase $purchase) {
        // get all the companies for admin and perform user specific query for non-admins
        $companies = (Auth::user()->email == config('app.admin')) ? Company::all() : Company::where('user_id', Auth::id())->get();

        return view('invoice.purchase.edit', compact('purchase', 'companies'));
    }

    // function to update the purchase data
    public function update(Request $request, Purchase $purchase) {
        try {
            $purchase->update($request->validate([
                'company_id' => "required|numeric",
                'invoice_no' => "required",
                'invoice_date' => "required",
                'amount' => "required|numeric",
            ]) + ['type' => $request->tax_type]);

            Session::flash('success', "Purchase entry was updated successfully");
            return redirect()->route('purchase.index');

        } catch (\Exception $error) {
            Session::flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    // function to destroy the purchase entry
    public function destroy(Purchase $purchase)
    {
        $purchase->delete();

        return response("The purchase entry of invoice no ". $purchase->invoice_no. " is deleted successfully");
    }
}
