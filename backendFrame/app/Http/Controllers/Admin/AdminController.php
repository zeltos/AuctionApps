<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //

    public function showLogin() {
        if (Auth::check()) {
            return \Redirect::to('auction-admin/home');
        }
       return view('admin/login', ['name' => 'James']);
    }

    public function submitLogin(Request $request) {
      $rules = array(
          'email'    => 'required|email', // make sure the email is an actual email
          'password' => 'required|alphaNum|min:3' // password can only be alphanumeric and has to be greater than 3 characters
      );
      $validator = \Validator::make(Input::all(), $rules);
      if ($validator->fails()) {
        return \Redirect::to('auction-admin/login')
        ->withErrors($validator) // send back all errors to the login form
        ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
      } else {
        $userdata = array(
            'email'     => Input::get('email'),
            'password'  => Input::get('password')
        );
        print_r($userdata);
        // attempt to do the login
        if (Auth::attempt($userdata)) {

            // validation successful!
            // redirect them to the secure section or whatever
            // return Redirect::to('secure');
            // for now we'll just echo success (even though echoing in a controller is bad)
            return \Redirect::to('auction-admin/home');

        } else {
            // validation not successful, send back to form
            return \Redirect::to('auction-admin/login');

        }
      }
    }


    public function doLogout() {
      Auth::logout(); // log the user out of our application
      return \Redirect::to('auction-admin/login'); // redirect the user to the login screen
  }

  public function getHome() {
    // echo $userId = Auth::id();
    return view('admin/dashboard');
  }

  public function checkAuth() {
    if (!Auth::check()) {
        return \Redirect::to('auction-admin/login');
    }
  }

}
