<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use View;
use Illuminate\Pagination\Paginator;
use Maatwebsite\Excel\Facades\Excel;

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

    public function getDetail($auction_id, $curPage = null) {

      if ($curPage !== null) {
        Paginator::currentPageResolver(function() use ($curPage) {
           return $curPage;
        });
      }

      $Data = DB::table('auction_bid as ab')
              ->join('auctions as a','ab.auction_id','=','a.auction_id')
              ->join('users as u','ab.user_id','=','u.user_id')
              ->selectRaw('ab.*, a.auction_name , u.user_name, u.user_email')
              ->where('a.auction_id', $auction_id)
              ->paginate(10);
      // return $Data;

      return view('admin/bid/detail', ['dataReport' => $Data]);

    }

    public function exportExcel($auction_id) {
      $Datas = DB::table('auction_bid as ab')
              ->join('auctions as a','ab.auction_id','=','a.auction_id')
              ->join('users as u','ab.user_id','=','u.user_id')
              ->selectRaw('ab.bid_id, ab.bid_value, a.auction_name , u.user_name, u.user_email, ab.created_at')
              ->where('a.auction_id', $auction_id)
              ->get();

      $auction_name = $Datas[0]->auction_name;

      $bidsArray = [];
      // Define the Excel spreadsheet headers
      $bidsArray[] = ['id', 'Bidder Name','Bidder Email','Bid Value','created_at'];
      $Datas = json_decode( $Datas, true);
      foreach ($Datas as $data) {
          $bidsArray[]= array(
            'bid_id'        => $data['bid_id'],
            'user_name'     => $data['user_name'],
            'user_email'    => $data['user_email'],
            'bid_value'     => $data['bid_value'],
            'created_at'    => $data['created_at']
          );
      }

      $now              = new \DateTime();
      $nowDate= $now->format('m-d-y');
      $title = 'Data Bidder - '.$auction_name.' - '.$nowDate;
      // Generate and return the spreadsheet
      Excel::create($title, function($excel) use ($title, $bidsArray) {

          // Set the spreadsheet title, creator, and description
          $excel->setTitle($title);
          $excel->setCreator('Medianto')->setCompany('PT Nusantara Sarana Outlet');
          $excel->setDescription('Bidder Data');

          // Build the spreadsheet, passing in the payments array
          $excel->sheet('sheet1', function($sheet) use ($bidsArray) {
              $sheet->fromArray($bidsArray, null, 'A1', false, false);
          });

      })->download('xlsx');


    }

    public function exportAll() {
      $Datas = DB::table('auction_bid as ab')
              ->join('auctions as a','ab.auction_id','=','a.auction_id')
              ->join('users as u','ab.user_id','=','u.user_id')
              ->selectRaw('ab.bid_id, ab.bid_value, a.auction_name , u.user_name, u.user_email, ab.created_at')
              ->get();

      $auction_name = $Datas[0]->auction_name;

      $bidsArray = [];
      // Define the Excel spreadsheet headers
      $bidsArray[] = ['id', 'Auction Name', 'Bidder Name','Bidder Email','Bid Value','created_at'];
      $Datas = json_decode( $Datas, true);
      foreach ($Datas as $data) {
          $bidsArray[]= array(
            'bid_id'        => $data['bid_id'],
            'auction_name'  => $data['auction_name'],
            'user_name'     => $data['user_name'],
            'user_email'    => $data['user_email'],
            'bid_value'     => $data['bid_value'],
            'created_at'    => $data['created_at']
          );
      }

      $now        = new \DateTime();
      $nowDate    = $now->format('m-d-y');
      $title      = 'Data Bidder - All Auctions - '. $nowDate;
      // Generate and return the spreadsheet
      Excel::create($title, function($excel) use ($title, $bidsArray) {

          // Set the spreadsheet title, creator, and description
          $excel->setTitle($title);
          $excel->setCreator('Medianto')->setCompany('PT Nusantara Sarana Outlet');
          $excel->setDescription('Bidder Data');

          // Build the spreadsheet, passing in the payments array
          $excel->sheet('sheet1', function($sheet) use ($bidsArray) {
              $sheet->fromArray($bidsArray, null, 'A1', false, false);
          });

      })->download('xlsx');
    }
}
