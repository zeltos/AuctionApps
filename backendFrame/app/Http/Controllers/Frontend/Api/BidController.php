<?php

namespace App\Http\Controllers\Frontend\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;

class BidController extends Controller
{
    public function submitBid(Request $request) {
      $token         = $request->input('token');
      $user_id       = $request->input('user_id');
      $auction_id    = $request->input('auction_id');
      $bid_value     = $request->input('bid_value');
      $firststbid    = false;
      $checkfirststbid = DB::table('auction_bid')->select('auction_id')->where('user_id', $user_id)->where('auction_id',$auction_id)->get();
      if (count($checkfirststbid) == 0 ) {
        $firststbid = true;
      }

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

          if ($firststbid) {
            $userData = DB::table('users')->select('*')->where('user_id', $user_id)->get();
            $userArray = json_decode($userData, true);
            $nameUser = $userArray[0]['user_name'];
            $emailUser = $userArray[0]['user_email'];

            $auctionData = DB::table('auctions')->select('auction_name','auction_end_date','auction_term_condition')->where('auction_id', $auction_id)->get();
            $auctionArray = json_decode($auctionData, true);
            $nameAuction = $auctionArray[0]['auction_name'];
            $EndDate = $auctionArray[0]['auction_end_date'];
            $termcond = $auctionArray[0]['auction_term_condition'];


            $data = array(
              'user_name'         => $nameUser,
              'bid_date'          => $now,
              'bid_value'         => $bid_value,
              'auction_name'      => $nameAuction,
              'auction_end_date'  => $EndDate,
              'termcond'          => $termcond,
              'email'             => $emailUser
            );

              $subject ='Thank you for your new bidding on Auction : '.$nameAuction;
              Mail::send('emails.newbid', $data, function($message) use ($emailUser, $nameUser,$subject){
                  $message->to($emailUser, $nameUser)->subject($subject);
              });

          }

        } else {
          $status = 'failed';
          $message = 'Failed When Insert Query!';
        }
      }

      $result = array();
      $result['response'] = array(
        'status' =>  $status,
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
