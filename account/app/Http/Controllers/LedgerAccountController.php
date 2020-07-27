<?php

namespace App\Http\Controllers;

use App\Company;
use App\LedgerAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LedgerAccountController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    // function to direct user to the index page
    public function index() {
        $ledgerAccounts = (Auth::user()->email == config('app.admin')) ? LedgerAccount::all() : LedgerAccount::where('user_id', Auth::id())->get();

        return view('ledger.account.index')
            ->with('i', $i=0)
            ->with('ledgerAccounts', $ledgerAccounts);
    }

    // function to direct user to the ledger account page
    public function create() {
        // create a new ledger account instance and pass it to the view page
        $account = new LedgerAccount();

        // get all the companies
        $companies = (Auth::user()->email == config('app.admin')) ? Company::all() : Company::where('user_id', Auth::id())->get();


        return view('ledger.account.create', compact('account', 'companies'));
    }

    // function to store account to the table
    public function store(Request $request) {
        try {
            $request->user()->ledgerAccounts()->create($request->validate([
                'company_id' => "required|numeric",
                'name' => "required|string"
            ]));

            Session::flash('success', "Ledger Account is created successfully");
            return redirect()->route('account.index');

        } catch (\Exception $error) {
            Session::flash('error', $error->getMessage());
            return redirect()->back()->withInput();
        }
    }

    // function to view the ledger sheet
    public function show(LedgerAccount $account) {
        $i = 0;
        return view('ledger.account.show', compact('i', 'account'));
    }

    // function to direct user to the edit page
    public function edit(LedgerAccount $account) {
        // get all the companies
        $companies = (Auth::user()->email == config('app.admin')) ? Company::all() : Company::where('user_id', Auth::id())->get();

        return view('ledger.account.edit', compact('account', 'companies'));
    }

    // function to update the given data
    public function update(Request $request, LedgerAccount $account) {
        try {
            $account->update($request->validate([
                'company_id' => "required|numeric",
                'name' => "required|string"
            ]) + ['user_id' => Auth::id()]);

            Session::flash('success', "Ledger Account is updated successfully");
            return redirect()->route('account.index');

        } catch (\Exception $error) {
            Session::flash('error', $error->getMessage());
            return redirect()->back()->withInput();
        }
    }

    // function to delete the ledger account
    public function destroy(LedgerAccount $account) {
        // check whether the user is authorized to delete the category or not
        $this->authorize('delete', $account);

        $account->delete();

        return response("Account ". $account->name. " is deleted successfully");
    }
}
