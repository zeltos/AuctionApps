<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use View;
class AuctionController extends Controller
{
    //

    public function newData() {
      return view('admin/auction/new');
    }
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
      // return $request->all();
      $auction_id     = $request->input('auction_id');
      $auction_name   = $request->input('auction_name');
      $status         = $request->input('status');
      $start_date     = $request->input('start_date');
      $end_date       = $request->input('end_date');
      $start_bid      = $request->input('start_bid');
      $max_bid        = $request->input('max_bid');
      $short_desc     = $request->input('short_desc');
      $description    = $request->input('description');
      $term_cond      = $request->input('term_cond');
      $destinationPath = public_path('images/logo');

      // conditional if logo empty or not changed
      $logo           = $request->input('logo');

      // images array
      $imagesDatas     =  $request->input('images_id');

      if (count($imagesDatas) > 0) {
        $queryDeleteImageGallery_before = DB::table('auction_image')
                                          ->where('auction_id', $auction_id)
                                          ->delete();
        $newArray = array();
        $no=0;
        foreach ($imagesDatas as $imagesData) {
          $newArray[$no] = array(
            'auction_image_id'  => "",
            'auction_id'        => $auction_id,
            'images_id'         => $imagesData
          );
          $no++;
        }

        $queryGallerySave = DB::table('auction_image')->insert($newArray);
      }

      // Query for update general data Auction

      try {
        if (!$request->hasFile('logo')) {
            $queryUpdate    = DB::table('auctions')
                            ->where('auction_id', $auction_id)
                            ->update(
                                  [
                                    'auction_name'    => $auction_name,
                                    'status'    => $status,
                                    'auction_start_date'    => $start_date,
                                    'auction_end_date'    => $end_date,
                                    'auction_start_bidding'    => $start_bid,
                                    'auction_max_bid'    => $max_bid,
                                    'auction_short_description'    => $short_desc,
                                    'auction_description'    => $description,
                                    'auction_term_condition'    => $term_cond
                                  ]
                                );

        } else {
          $image = $request->file('logo');
          $imageName = $image->getClientOriginalName();
          $request->file('logo')->move($destinationPath , $imageName);
          $queryUpdate    = DB::table('auctions')
                          ->where('auction_id', $auction_id)
                          ->update(
                                [
                                  'auction_name'            => $auction_name,
                                  'status'                  => $status,
                                  'auction_start_date'      => $start_date,
                                  'auction_end_date'        => $end_date,
                                  'auction_start_bidding'   => $start_bid,
                                  'auction_max_bid'         => $max_bid,
                                  'auction_short_description'    => $short_desc,
                                  'auction_description'    => $description,
                                  'auction_logo'           => $imageName,
                                  'auction_term_condition' => $term_cond
                                ]
                              );
          }
        // return "success update auction";
        // return redirect('auction-admin/auction/config')->with('message', 'Successfully update Auction Data!');
        return redirect()->back()->with('message.success', 'Successfully update Auction Data!');
      } catch (Exception $e) {
        return $e->getMessage();
      }

    }
}
