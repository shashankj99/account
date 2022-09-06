<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        if (Auth::user()->email == config('app.admin')) {
            $totalCompanyAudited = Company::count();
            $company = Company::leftJoin('categories', 'companies.type', '=', 'categories.id')
                ->select('categories.name')
                ->groupBy('categories.name')
                ->orderByRaw('COUNT(*) DESC')
                ->limit(1)
                ->first();
        } else {
            $totalCompanyAudited = Company::where('user_id', Auth::id())->count();
            $company = Company::leftJoin('categories', 'companies.type', '=', 'categories.id')
                ->where('categories.user_id', Auth::id())
                ->select('categories.name')
                ->groupBy('categories.name')
                ->orderByRaw('COUNT(*) DESC')
                ->limit(1)
                ->first();
        }
        $maxCategory = $company ?? 'No Name';
        return view('home', compact('totalCompanyAudited', 'maxCategory'));
    }
}
