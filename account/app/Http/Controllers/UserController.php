<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

/**
 * Class UserController
 *
 * @package App\Http\Controllers
 * @author Shashank Jha shashankj677@gmail.com
 */

class UserController extends Controller
{
    // constructor
    public function __construct() {
        $this->middleware('auth');
    }

    // function to return user to the index page
    public function index() {
        return view('user.index')
            ->with('users', User::all())
            ->with('i', $i=0);
    }

    // function to return user to the create page
    public function create() {
        return view('user.create');
    }

    public function store(UserRequest $request) {
        try {
            if ($request->password == $request->password_confirmation) {
                User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'mobile' => $request->mobile,
                    'password' => Hash::make($request->password)
                ]);

                Session::flash('success', "New User registered successfully");
                return redirect()->route('user.index');
            } else {
                return redirect()->back()
                    ->withErrors('password did not match')
                    ->withInput();
            }
            
        } catch (\Exception $error) {
            return redirect()->back()
                ->withInput()
                ->withErrors($error->getMessage());
        }
    }

    // function to show the details about a user
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    // function to delete the user details
    public function destroy(User $user) {
        if ($user) {
            $user->delete();
            return response('User '. $user->name. ' is deleted successfully');
        } else {
            return response('Sorry! Unable to find the user');
        }
        
    }
}
