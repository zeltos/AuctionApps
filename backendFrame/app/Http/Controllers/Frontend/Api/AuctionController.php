<?php

namespace App\Http\Controllers\Frontend\Api;

use Illuminate\Http\Request;
use App\Auction;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Controller;


class AuctionController extends Controller
{
    //
    public function getList($status, $curPage = null) {
      if ($curPage !== null) {
        Paginator::currentPageResolver(function() use ($curPage) {
           return $curPage;
        });
      }
      if ($status == 'all') {
        $dataAuction = DB::table('auctions as a')
                          ->select('a.*', 'i.image', 'b.bid_value as auction_current_bidding')
                          ->join('auction_bid as b', 'a.auction_id','=','b.auction_id')
                          ->join('auction_image as i', 'a.auction_id','=','i.auction_id')
                          ->whereRaw('b.auction_id = a.auction_id
                                            and i.auction_id = a.auction_id
                                            and b.created_at = (select max(created_at) from auction_bid where auction_id = a.auction_id)')
                          ->groupBy('a.auction_id')->paginate(6);

      } else {
        $dataAuction = DB::table('auctions as a')
                          ->select('a.*', 'i.image', 'b.bid_value as auction_current_bidding')
                          ->join('auction_bid as b', 'a.auction_id','=','b.auction_id')
                          ->join('auction_image as i', 'a.auction_id','=','i.auction_id')
                          ->where('status',$status)
                          ->whereRaw('b.auction_id = a.auction_id
                                            and i.auction_id = a.auction_id
                                            and b.created_at = (select max(created_at) from auction_bid where auction_id = a.auction_id)')
                          ->groupBy('a.auction_id')->paginate(6);
      }

      $result = array();
      $result['response'] = array(
        'status' => 'success',
        'message' => 'Success to load data auction list'
      );
      $result['data_response'] = $dataAuction;
      return $result;
    }

    public function getDetailAuction($key) {
      $dataAuction = DB::table('auctions as a')
                        ->select('a.*', 'i.image', 'b.bid_value as auction_current_bidding')
                        ->join('auction_bid as b', 'a.auction_id','=','b.auction_id')
                        ->join('auction_image as i', 'a.auction_id','=','i.auction_id')
                        ->where('a.auction_unique_key', $key)
                        ->whereRaw('b.auction_id = a.auction_id
                                          and i.auction_id = a.auction_id
                                          and b.created_at = (select max(created_at) from auction_bid where auction_id = a.auction_id)')
                        ->groupBy('a.auction_id')->get();
      $datas = json_decode($dataAuction, true);
      $auction_id = $datas[0]['auction_id'];
      $image_gallery = DB::table('auction_image')->select('image')->where('auction_id',$auction_id)->get();

      $result = array();
        $result['image_gallery']= $image_gallery;
      if (count($dataAuction) > 0) {
        $result['response'] = array(
          'status' => 'success',
          'message' => 'Success to load data auction with key '.$key
        );
      } else {
        $result['response'] = array(
          'status' => 'failed',
          'message' => 'Failed to load data auction with key '.$key
        );
      }
      $result['data_response'] = $dataAuction;

      return $result;

    }


    public function getDominated($user_id, $auction_id) {
      $dominatedQ = DB::table('auction_bid')->select('user_id','bid_value')
                  ->where('auction_id',$auction_id)
                  ->orderBy('bid_value','DESC')
                  ->limit(1)
                  ->get();
      $convertDominated = json_decode($dominatedQ, true);
      $bid_value = $convertDominated[0]['bid_value'];
      $userDominated = $convertDominated[0]['user_id'];
      if (count($dominatedQ) > 0) {
        $result = array();
        if ($userDominated == $user_id) {
          $isDominated = true;
        } else {
          $isDominated = false;
        }
        $result = array(
          'auction_current_bidding' => $bid_value,
          'dominated'               => $isDominated,
          'was_bid'                 => true
        );
      } else {
        $result = array(
          'auction_current_bidding' => $bid_value,
          'dominated'               => $isDominated,
          'was_bid'                 => false
        );        
      }
      return $result;
    }
}
