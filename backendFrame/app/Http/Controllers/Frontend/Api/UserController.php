<?php

namespace App\Http\Controllers\Frontend\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //
    public function submitLogin(Request $request) {
      $email = $request->input('email');
      $password = $request->input('password');
      $now = date('Y-m-d H:i:s');
      $token = md5($now);
      DB::table('users')
            ->where('user_email', $email)
            ->update(['token' => $token]);
      $login = DB::table('users')
                    ->select('user_id','token')
                    ->where('user_email', $email)
                    ->where('password', $password)
                    ->get();

      $result = array();
      if(count($login) > 0) {
        $result['response'] = array(
            'status'  => 'success',
            'message' => 'Success to Login!'
        );
      } else {
        $result['response'] = array(
            'status'  => 'failed',
            'message' => 'Incorrect email or password!'
        );
      }

      $result['user_data'] = $login;
      return $result;
    }
}
