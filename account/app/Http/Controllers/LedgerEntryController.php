<?php

namespace App\Http\Controllers;

use App\Http\Requests\LedgerEntryRequest;
use App\LedgerAccount;
use App\LedgerEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LedgerEntryController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    // function to direct user to the index page
    public function index() {
        $ledgerEntries = (Auth::user()->email == config('app.admin')) ? LedgerEntry::all() : LedgerEntry::where('user_id', Auth::id())->get();

        return view('ledger.entry.index')
            ->with('i', $i=0)
            ->with('ledgerEntries', $ledgerEntries);
    }

    // function to direct user to the create blade
    public function create() {
        // create a new ledger account instance and pass it to the view page
        $entry = new LedgerEntry();

        // get all the companies
        $ledgerAccounts = (Auth::user()->email == config('app.admin')) ? LedgerAccount::all() : LedgerAccount::where('user_id', Auth::id())->get();


        return view('ledger.entry.create', compact('entry', 'ledgerAccounts'));
    }

    // function to add data to the table
    public function store(LedgerEntryRequest $request) {

        try {
            DB::beginTransaction();
            $amount = ($request->debit > $request->credit) ? $request->debit-$request->credit : $request->credit-$request->debit;
            $request->user()->ledgerEntries()->create($request->validated()+['amount' => $amount, 'qty' => $request->qty]);

            $getAmounts = LedgerEntry::where('ledger_account_id', $request->ledger_account_id)->where('user_id', Auth::id())->sum('amount');

            $ledgerAccount = LedgerAccount::find($request->ledger_account_id);
            $ledgerAccount->amount = $getAmounts;

            $ledgerAccount->save();

            DB::commit();

            Session::flash('success', "Ledger Entry is made successfully");
            return redirect()->route('entry.index');
            
        } catch (\Exception $error) {
            Session::flash('error', $error->getMessage());
            return redirect()->back()->withInput();
        }
    }

    // this function doesn't exist
    public function show(LedgerEntry $entry) {
        Session::flash('info', "This URL doesn't exist");
        return redirect()->back();
    }

    // function to direct user to the edit blade
    public function edit(LedgerEntry $entry) {
        // get all the companies
        $ledgerAccounts = (Auth::user()->email == config('app.admin')) ? LedgerAccount::all() : LedgerAccount::where('user_id', Auth::id())->get();

        return view('ledger.entry.edit', compact('entry', 'ledgerAccounts'));
    }

    // function to update the table
    public function update(LedgerEntryRequest $request, LedgerEntry $entry) {
        try {
            $amount = ($request->debit > $request->credit) ? $request->debit-$request->credit : $request->credit-$request->debit;
            $entry->update($request->validated()+['amount' => $amount, 'qty' => $request->qty, 'user_id' => Auth::id()]);

            Session::flash('success', "Ledger Entry is updated successfully");
            return redirect()->route('entry.index');
            
        } catch (\Exception $error) {
            Session::flash('error', $error->getMessage());
            return redirect()->back()->withInput();
        }
    }

    // function to delete the data
    public function destroy(LedgerEntry $entry) {
        $entry->delete();

        return response("Entry of ". $entry->particulars. " is deleted successfully");
    }
}
