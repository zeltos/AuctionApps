<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use View;

class UserController extends Controller
{
    //
    public function index() {
      $userQ = DB::table('users')
                ->leftJoin('auction_bid', 'users.user_id','=','auction_bid.user_id')
                ->selectRaw('users.*, count(auction_bid.bid_id) as bidCount')
                ->orderBy('created_at', 'desc')
                ->groupBy('users.user_id')
                ->get();

      return view('admin/user/index', compact('userQ'));
      // return $userQ;
    }

    public function detailUser($user_id) {
      $userQ = DB::table('users')
                ->leftJoin('auction_bid', 'users.user_id','=','auction_bid.user_id')
                ->selectRaw('users.*, count(auction_bid.bid_id) as bidCount')
                ->where('users.user_id', $user_id)
                ->orderBy('created_at', 'desc')
                ->groupBy('users.user_id')
                ->get();
      // return view('admin/user/detail', compact('userQ'));
      // return $userQ;
      $userBid = DB::table('auction_bid')
                  ->leftJoin('auctions', 'auction_bid.auction_id','=','auctions.auction_id')
                  ->selectRaw('auction_bid.*, auctions.auction_name')
                  ->where('user_id',$user_id)
                  ->orderBy('created_at', 'desc')
                  ->get();

      $userData = json_decode( $userQ, true);
      $userData[0]['bid_data'] = json_decode( $userBid, true);
      return view('admin/user/detail')->with('result', $userData);

    }
    public function saveEdit($user_id, Request $request) {
      // return $request->all();

      try {
        $queryUpdate = DB::table('users')
                      ->where('user_id', $user_id)
                      ->update(
                        [
                          'user_name'       => $request->input('user_name'),
                          'user_email'      => $request->input('user_email'),
                          'user_birthdate'  => $request->input('user_birthdate'),
                          'user_phone'      => $request->input('user_phone'),
                          'user_status'      => $request->input('status_user')
                        ]
                      );
        if ($request->input('password') !== null) {
        // Query change new password
        $password     = md5($request->input('password'));
        $queryUpdate  = DB::table('users')
                      ->where('user_id', $user_id)
                      ->update(['password' => $password]);
        }
        return redirect()->back()->with('message.success', 'Successfully update Users Data!');
      } catch (Exception $e) {

      }

    }

    public function deleteUser($user_id) {
      return $user_id;
      try {
        DB::table('user')->where('user_id', $user_id)->delete();
        return redirect()->back()->with('message.success', 'Successfully Delete Users Data!');
      } catch (Exception $e) {

      }

    }
}
