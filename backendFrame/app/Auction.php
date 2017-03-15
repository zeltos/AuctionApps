<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
  protected $primaryKey = 'auction_id';
  protected $fillable = array('auction_id','auction_unique_key','status','auction_name','auction_start_bidding','auction_short_description','auction_max_bid','auction_description','auction_start_date','auction_end_date','created_at','updated_at');
}
