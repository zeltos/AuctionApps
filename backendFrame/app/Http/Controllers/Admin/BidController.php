<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use View;

class BidController extends Controller
{
    //
    public function index() {
      $bidHistory = DB::table('auction_bid as ab')
                      ->leftJoin('auctions as a', 'ab.auction_id','=','a.auction_id')
                      ->leftJoin('users as u','ab.user_id','=','u.user_id')
                      ->selectRaw('a.*, count(ab.bid_id) as bidCount, count(distinct u.user_id) as userCount')
                      ->groupBy('a.auction_id')
                      ->get();
      return view('admin/bid/report', compact('bidHistory'));


    }
}
