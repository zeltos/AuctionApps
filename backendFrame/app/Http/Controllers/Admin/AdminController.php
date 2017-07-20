<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use View;

class AdminController extends Controller
{
    //

    public function index() {
      $adminData = DB::table('admins')
                  ->join('admin_role', 'admins.role_id','=','admin_role.role_id')
                  ->select('admins.*','admin_role.*')
                  ->get();
      // return $adminData;
      return view('admin/config/index',['adminData' => $adminData]);
    }


    public function showEdit($admin_id) {
      $adminData = DB::table('admins')
                  ->join('admin_role', 'admins.role_id','=','admin_role.role_id')
                  ->select('admins.*','admin_role.*')
                  ->where('admin_id', $admin_id)
                  ->get();
      // return $adminData;
      return view('admin/config/edit', compact('adminData'));
    }

    public function saveEdit(Request $request, $admin_id)
    {
      $name = $request->input('name');
      $role_id = $request->input('role_id');
      $email = $request->input('email');
      $password =Hash::make($request->input('password'));
      try {
        if (!$password) {
          DB::table('admins')
          ->where('admin_id', $admin_id)
          ->update(
            [
              'name' => $name,
              'role_id' => $role_id,
              'email' => $email
            ]
          );
        } else {
          DB::table('admins')
          ->where('admin_id', $admin_id)
          ->update(
            [
              'name' => $name,
              'role_id' => $role_id,
              'email' => $email,
              'password' => $password
            ]
          );
        }
        return redirect()->back()->with('message.success', 'Successfully Update Admin!');
      } catch (Exception $e) {

      }

    }

    public function deleteAdmin($admin_id)
    {
      try {
        DB::table('admins')->where('admin_id', $admin_id)->delete();
        return redirect()->back()->with('message.success', 'Successfully Update Admin!');
      } catch (Exception $e) {

      }

    }

    public function saveNew(Request $request) {
      $password = Hash::make($request->input('password'));
      $now = new \DateTime();
      try {
        DB::table('admins')->insert([
          'admin_id'        => '',
          'name'            => $request->input('name'),
          'email'            => $request->input('email'),
          'role_id'          => $request->input('role'),
          'password'            => $password,
          'created_at'        => $now,
          'updated_at'        => $now
        ]);
        return redirect()->back()->with('message.success', 'Successfully Add New Admin!');
      } catch (Exception $e) {

      }

    }

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
            return \Redirect::to('auction-admin/login')->with('message.error', 'ERROR: Invalid email or password!');

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
