<?php

namespace App\Http\Controllers\Frontend\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Mail;

class UserController extends Controller
{
    //
    public function submitLogin(Request $request) {
      $email = $request->input('email');
      $password = md5($request->input('password'));
      $now = date('Y-m-d H:i:s');
      $token = md5($now);
      DB::table('users')
            ->where('user_email', $email)
            ->update(['token' => $token]);
      $login = DB::table('users')
                    ->select('user_id','token','user_status')
                    ->where('user_email', $email)
                    ->where('password', $password)
                    ->get();
      $loginArray = json_decode($login, true);
      $result = array();
      if(count($login) <= 0) {
        $result['response'] = array(
            'status_code' => http_response_code(),
            'status'  => 'failed',
            'message' => 'Incorrect email or password!'
        );
      } elseif ($loginArray[0]['user_status'] == '0') {
        $result['response'] = array(
          'status_code' => http_response_code(),
          'status'  => 'failed',
          'message' => 'You Have not activated your account ! <a href="#!">click here to resend activation to your email</a>'
        );
      } else {
        $result['response'] = array(
            'status_code' => http_response_code(),
            'status'  => 'success',
            'message' => 'Success to Login!'
        );
        $result['user_data'] = $login;
      }
      return $result;
    }

    public function userRegister(Request $request) {
      $name         = $request->input('name');
      $email        = $request->input('email');
      $password     = md5($request->input('password'));
      $phone        = $request->input('phone');
      $birth_date   = $request->input('birth_date');
      $result = array();
      if (!$email || !$password || !$phone || !$birth_date || !$name) {
        $status   = 'failed';
        $message  = 'Validation Error! please fill form that required.';
      } elseif (!$this->checkEmail($email)) {
        $status   = 'failed';
        $message  = 'Email Already Exist!';
      } else {
        $now = date('Y-m-d H:i:s');
        $key = 'Zeltos'.$email.$now;
        $key = base64_encode($key);
        $registerInsertQ = DB::table('users')->insert([
            'user_id'         => '',
            'user_email'      => $email,
            'password'        => $password,
            'user_name'       => $name,
            'user_phone'      => $phone,
            'user_birthdate'  => $birth_date,
            'activation_key'  => $key,
            'created_at'      => $now,
            'updated_at'      => $now
          ]);
        $status   = 'success';
        $message  = 'Success Registered User! check your email to activation your accout.';

        $data = array(
          'user_name'       => $name,
          'activation_key'  => $key
        );

        Mail::send('emails.welcome', $data, function($message) use ($email, $name){
            $message->to($email, $name)->subject('Activation Account For Auctions Brandoutlet!');
        });
      }

      $result['response'] = array(
        'status_code' => http_response_code(),
        'status'      => $status,
        'message'     => $message
      );

      return $result;

    }

    public function checkEmail($email) {
      $checkEmailQ = DB::table('users')->where('user_email', $email)->get();
      if (count($checkEmailQ) > 0) {
        return false;
      } return true;
    }

    public function userActivation($key) {
      $checkUsersQ = DB::table('users')->select('user_id','user_status')->where('activation_key', $key)->get();
      if (count($checkUsersQ) > 0) {
        $updateStatusQ = DB::table('users')->where('activation_key', $key)->update(['user_status' => '1']);
        return 'success';
      }
    }

    public function getAccountData($user_id) {
      $result = array();
      $accountQ = DB::table('users')->select('*')->where('user_id', $user_id)->get();
      $result['data'] = $accountQ[0];
      return $result;
    }

}
