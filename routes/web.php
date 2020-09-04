<?php
use Illuminate\Support\Facades\Route;
Route::get('/', 'mainController')->middleware('loginCheck');
Route::get('/visitor','mainController@visitor')->middleware('loginCheck');
Route::get('/user','mainController@user')->middleware('loginCheck');
Route::get('/message','mainController@message')->middleware('loginCheck');

//Mannage user Route.......
Route::get('/getAllUser','userController@getAllUser')->middleware('loginCheck');
Route::post('/approve','userController@approve')->middleware('loginCheck');
Route::post('/suspand','userController@suspand')->middleware('loginCheck');


//Mannage Contract Section.......
Route::get('/allContractData','contractController@allContractData')->middleware('loginCheck');
Route::post('/deleteContractData','contractController@deleteContractData')->middleware('loginCheck');


//Login Route Setup.........
Route::get('/login', 'loginController');
Route::post('/adminLogin', 'loginController@adminLogin');
Route::get('/logOut', 'loginController@logOut');

//Upload image Route Setup.........
Route::get('/upload', 'uploadController');
Route::get('/retrivePhoto', 'uploadController@retrivePhoto');
Route::post('/uploadPhoto', 'uploadController@uploadPhoto');
Route::post('/deletePhoto', 'uploadController@deletePhoto');