<?php

namespace App\Http\Controllers\Frontend\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BidController extends Controller
{
    public function submitBid(Request $request) {
      $token         = $request->input('token');
      $user_id       = $request->input('user_id');
      $auction_id    = $request->input('auction_id');
      $bid_value     = $request->input('bid_value');
      $now = new \DateTime();
      $now->format('m-d-y H:i:s');
      if (!$token || !$this->checkTokenUser($token) ) {
        $status = 'failed';
        $message = 'required correct token!';
      } elseif(!$user_id || !$auction_id || !$bid_value) {
        $status = 'failed';
        $message = 'Validation Data Failed!';
      } else {

        $insertBid = DB::table('auction_bid')
                    ->insert([
                      'bid_id' => '',
                      'auction_id' => $auction_id,
                      'user_id'    => $user_id,
                      'bid_value'  => $bid_value,
                      'created_at' => $now
                    ]);

        if ($insertBid) {
          $status = 'success';
          $message = 'Success Message Here!';
        } else {
          $status = 'failed';
          $message = 'Failed When Insert Query!';
        }
      }

      $result = array();
      $result['response'] = array(
        'status' => $status,
        'message' => $message
      );

      return $result;
    }

    public function checkTokenUser($token) {
      $token = DB::table('users')->where('token',$token)->get();
      if (count($token) > 0) {
        return true;
      }
      return false;
    }

    public function getListBid($user_id) {
      $listBiddingQ = DB::table('auction_bid as ab')->select('ab.*', 'a.auction_name','a.auction_unique_key','a.status')->join('auctions as a', 'ab.auction_id','=','a.auction_id')->where('user_id', $user_id)->orderBy('created_at','desc')->get();
      return $listBiddingQ;
    }
}
