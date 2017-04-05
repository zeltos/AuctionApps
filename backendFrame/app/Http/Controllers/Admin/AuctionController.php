<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use View;
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
                 ->first();
      $imageGallery = DB::table('auction_image as ai')->select('ai.auction_id','i.*')
                      ->join('images as i','ai.images_id','=','i.images_id')
                      ->where('auction_id',$auction_id)
                      ->get();


      $result = array();
      $result['data_auction'] = $detailAuctionQ;
      $result['image_gallery'] = $imageGallery;
      return View::make('admin/auction/edit')->with('result', $result);
      // return $result;
    }

    public function saveEdit(Request $request) {
      return $request->all();
    }
}
