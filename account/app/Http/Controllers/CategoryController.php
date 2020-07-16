<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

/**
 * Class CategoryController
 *
 * @package App\Http\Controllers
 * @author Shashank Jha shashankj677@gmail.com
 */

class CategoryController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    // function to direct user to the index page
    public function index() {
        return view('category.index')
            ->with('categories', Category::all())
            ->with('i', $i=0);
    }

    // this function is disabled for this class
    public function create() {
        Session::flash('info', 'Sorry the URL doesn\'t exist');
        return redirect()->back();
    }

    // function to store category into the DB
    public function store(Request $request) {
        // create a new instance for the category
        $category = new Category();

        // add category to the DB
        try {
            $category->create($request->validate([
                'name' => "required|unique:categories",
            ])+['user_id' => Auth::id()]);
            
            Session::flash('success', "Category is added successfully");
            return redirect()->back();
        } catch (\Exception $error) {
            Session::flash('error', $error->getMessage());
            return redirect()->back();
        }

    }

    // this function is not used
    public function show(Category $category) {
        Session::flash('info', "This URL doesn't exist");
        return redirect()->back();
    }

    // function to return the edit view page
    public function edit(Category $category) {
        // check whether user is authorized to view the edit blade or not
        $this->authorize('update', $category);

        return view('category._edit', compact('category'));
    }

    // function to update the category
    public function update(Request $request, Category $category) {
        // check whether user is authorized to update the category or not
        $this->authorize('update', $category);
        
        // update the category in the DB
        $category->update($request->validate([
            'name' => "required"
        ]));
        
        Session::flash('success', "Category is updated successfully");
        return redirect()->route('category.index');
    }

    // function to delete the category
    public function destroy(Category $category) {
        // check whether the user is authorized to delete the category or not
        $this->authorize('delete', $category);

        // delete if authorized
        $category->delete();

        return response("Category ". $category->name. " is deleted successfully");
    }
}
