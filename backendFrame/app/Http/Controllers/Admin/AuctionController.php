<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AuctionController extends Controller
{
    //
    public function index() {

     $auctionQ = DB::table('auctions')
                ->select('*')
                ->orderBy('created_at', 'desc')
                ->get();

      return view('admin/auction/index', compact('auctionQ'));
    }

    public function showEdit($auction_id) {
      $detailAuctionQ = DB::table('auctions')
                 ->select('*')
                 ->where('auction_id', $auction_id)
                 ->get();            
      $data = json_decode( $detailAuctionQ, true );
      $result = $data[0];
      return view('admin/auction/edit', $result);
    }
}
