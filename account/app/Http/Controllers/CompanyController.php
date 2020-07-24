<?php

namespace App\Http\Controllers;

use App\Category;
use App\Company;
use App\Http\Requests\CompanyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

/**
 * Class CompanyController
 *
 * @package App\Http\Controllers
 * @author Shashank Jha shashankj677@gmail.com
 */

class CompanyController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    // function to direct user to the index page
    public function index() {
        $companies = (Auth::user()->email == config('app.admin')) ? Company::all() : Company::where('user_id', Auth::id())->get();

        return view('company.index')
            ->with('companies', $companies)
            ->with('i', $i=0);
    }

    // function to direct user to the company creation page
    public function create() {
        // create a new company instance and pass it to the view page
        $company = new Company();

        // get all the categories
        $categories = Category::all();

        return view('company.create', compact('company', 'categories'));
    }

    // function to store company details
    public function store(CompanyRequest $request) {
        // add company detail to the DB with authorized user id
        try {
            $request->user()->companies()->create($request->validated());

            Session::flash('success', "Company is added successfully");
            return redirect()->route('company.index');
        } catch (\Exception $error) {
            Session::flash('error', $error->getMessage());
            return redirect()->back()->withInput();
        }
    }

    // this function doesn't exist for now
    public function show(Company $company) {
        Session::flash('info', "This URL doesn't exist");
        return redirect()->back();
    }


    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //
    }
}
