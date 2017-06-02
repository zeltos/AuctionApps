<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

class ImageController extends Controller
{
    //
    public function post(Request $request) {
      if (Input::hasFile('file')) {
        $name = Input::file('file')->getClientOriginalName();
        $type = Input::file('file')->getClientOriginalExtension();
        $size = Input::file('file')->getSize();
        $destinationPath = public_path('images');
        // echo $destinationPath.'/'.$name;
        try {
          if (!file_exists($destinationPath.'/'.$name)) {
            Input::file('file')->move($destinationPath, $name);
            $insertImage = DB::table('images')->insert([
                            "images_id"   => "",
                            "images" => "$name"
                          ]);
          }
        } catch (Exception $e) {
          return $e->getMessage();
        }

      } else {
      }
    }

    public function get($image = null) {
      if ($image == null) {
        $getImage = DB::table('images')->select('*')->get();
        return $getImage;
      } else {
        $getImage = DB::table('images')->select('*')->where('images', $image)->get();
        return $getImage;
      }
    }

    public function delete($id) {
      $getImage = DB::table('images')->select('images')->where('images_id', $id)->get();
      $getImage = json_decode( $getImage, true );
      $imageDb = $getImage[0]['images'];
      $deleteInImages = DB::table('auction_image')->where('images_id', $id)->delete();
      $deleteInAuctionImages = DB::table('images')->where('images_id', $id)->delete();

      $image = public_path('images').'/'.$imageDb;
      unlink($image);
      return "success";
    }
}
