<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('welcome');
});

// API for Frontend

// Auction Controller
Route::get('/api/v1/get-auction-list/', 'Frontend\Api\AuctionController@getList');
Route::get('/api/v1/get-auction-list/{curPage?}', 'Frontend\Api\AuctionController@getList');
Route::get('/api/v1/get-auction-list/{status}/{curPage?}', 'Frontend\Api\AuctionController@getList');
Route::get('/api/v1/get-auction/{key}', 'Frontend\Api\AuctionController@getDetailAuction');
Route::get('/api/v1/get-dominated/{auction_id}/{user_id}', 'Frontend\Api\AuctionController@getDominated');

// Bid Controller
Route::post('/api/v1/submitbid/','Frontend\Api\BidController@submitBid');

// User Contoller
Route::post('/api/v1/loginPost/','Frontend\Api\UserController@submitLogin');
Route::post('/api/v1/userRegister/','Frontend\Api\UserController@userRegister');
Route::get('/api/v1/user/activation/{key}','Frontend\Api\UserController@userActivation');


// Backend Adminhtml
Route::get('/welcome', function () {
    return 'welcome';
});
