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
    public function index(Request $request) {
        // check the type of method
        if ($request->method() == "POST") {
            // builder query
            $sales = Sales::query();

            // check if start date & end_date is not empty and query accordingly
            if ($request->start_date && $request->end_date) {
                $sales->whereBetween('invoice_date', [$request->start_date, $request->end_date]);
            }

            // check if company is not empty and query accordingly
            if ($request->company) {
                $sales->where('company_id', '=', $request->company);
            }

            // insure the tax type is either 0 or 1 and query accordingly
            if ($request->tax_type == 0 || $request->tax_type == 1) {
                $sales->where('type', '=', $request->tax_type);
            }

            // if user is admin then query all the rows else perform user specific queries
            if (Auth::user()->email == config('app.admin')) {
                $sales = $sales->get();
                $totalAmount = $sales->sum('amount');
                $companies = Company::all();
            } else {
                $sales = $sales->where('user_id', '=', Auth::id())->get();
                $totalAmount = $sales->where('user_id', Auth::id())->sum('amount');
                $companies = Company::where('user_id', Auth::id())->get();
            }
        
        // for get method conditional statements
        } else {
            if (Auth::user()->email == config('app.admin')) {
                $sales = Sales::all();
                $totalAmount = Sales::sum('amount');
                $companies = Company::all();
            } else {
                $sales = Sales::where('user_id', Auth::id())->get();
                $totalAmount = Sales::where('user_id', Auth::id())->sum('amount');
                $companies = Company::where('user_id', Auth::id())->get();
            }
        }

        // return user to the blade
        return view('invoice.sales.index')
            ->with('i', $i=0)
            ->with('sales', $sales)
            ->with('totalAmount', $totalAmount)
            ->with('companies', $companies);
    }

    // function to direct user to the create page
    public function create(User $user) {
        // create a new Sales Instance and pass it to the view page
        $sale = new Sales();

        // get all the companies for admin and perform user specific query for non-admins
        $companies = (Auth::user()->email == config('app.admin')) ? Company::all() : Company::where('user_id', Auth::id())->get();

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

    // this function doesn't exist
    public function show(Sales $sales) {
        Session::flash('info', "This URL doesn't exist");
        return redirect()->back();
    }

    // function to direct user to the edit view
    public function edit(Sales $sale) {
        // get all the companies for admin and perform user specific query for non-admins
        $companies = (Auth::user()->email == config('app.admin')) ? Company::all() : Company::where('user_id', Auth::id())->get();

        return view('invoice.sales.edit', compact('sale', 'companies'));
    }

    // function to update sales entry
    public function update(Request $request, Sales $sale) {
        try {
            $sale->update($request->validate([
                'company_id' => "required|numeric",
                'invoice_no' => "required",
                'invoice_date' => "required",
                'amount' => "required|numeric"
            ]) + ['type' => $request->tax_type]);

            Session::flash('success', "Sales entry was updated successfully");
            return redirect()->route('sales.index');

        } catch (\Exception $error) {
            Session::flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    // function to delete the sales entry
    public function destroy(Sales $sale) {
        $sale->delete();

        return response("The sales entry of invoice no ". $sale->invoice_no. " is deleted successfully");
    }
}
