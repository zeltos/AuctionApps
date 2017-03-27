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

Route::get('/mailsend', function () {
    // dd(Config::get('mail'));
    Mail::send('emails.welcome', ['user' => 'Medianto Jaelani'], function($message) {
    $message->to('medianto.jaelani@gmail.com', 'Medianto Jaelani')->subject('This is the subject');
});
    return 'success send mail';
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
Route::get('/api/v1/list-bidding/{user_id}','Frontend\Api\BidController@getListBid');

// User Contoller
Route::get('/api/v1/user/{user_id}','Frontend\Api\UserController@getAccountData');
Route::post('/api/v1/loginPost/','Frontend\Api\UserController@submitLogin');
Route::post('/api/v1/userRegister/','Frontend\Api\UserController@userRegister');
Route::get('/api/v1/user/activation/{key}','Frontend\Api\UserController@userActivation');


// Backend Adminhtml
Route::get('auction-admin/login', 'Admin\AdminController@showLogin');
Route::get('auction-admin/home', 'Admin\AdminController@getHome');

Route::get('auction-admin/auction/config', 'Admin\AuctionController@index');
Route::get('auction-admin/auction/config/{auction_id}/edit', 'Admin\AuctionController@showEdit');

Route::get('auction-admin/logout', 'Admin\AdminController@doLogout');
Route::post('auction-admin/login', 'Admin\AdminController@submitLogin');

Route::post('/image/post/', 'Admin\imageController@post');
Route::get('/image/get/', 'Admin\imageController@get');


Route::get('/welcome', function () {
    return 'welcome';
});
