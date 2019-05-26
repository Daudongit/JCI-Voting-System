<?php

use Illuminate\Http\Request;

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
    return redirect(route('front.vote.login'));
});

Route::get('/test', function () {
    
    return view('front.election');
});

Route::post('/test',function(Request $request){
    
    //dd($results);
});

Route::group(['namespace'=>'Front'],function(){
    Route::get('vote/login','LoginController@loginForm')->name('front.vote.login');
    Route::post('vote/login','LoginController@loginAttempt')->name('front.vote.attempt');
    Route::post('vote/logout','LoginController@logout')->name('front.vote.logout');
    Route::get('elections','VotingController@index')->name('front.elections.index');
    Route::get('vote/{election}','VotingController@show')->name('front.vote.show');
    Route::post('vote/{election}','VotingController@store')->name('front.vote.store');
});

Route::get('admin/login','Auth\LoginController@showLoginForm')->name('admin.login');
Route::post('admin/login','Auth\LoginController@login')->name('admin.login.attempt');
Route::post('admin/logout','Auth\LoginController@logout')->name('admin.logout');

Route::group(['namespace'=>'Admin','prefix'=>'admin','middleware'=>'auth:web'],function(){
    Route::get('dashboard','DashboardController@index')->name('admin.dashboard');
    Route::get('results','ResultController@index')->name('admin.results.index');
    Route::resource('nominees','NomineeController',['as'=>'admin']);
    Route::resource('elections','ElectionController',['as'=>'admin']);
    Route::resource('positions','PositionController',['as'=>'admin']);
    Route::resource('slots','SlotController',['as'=>'admin']);
    Route::patch('elections/toggle/{election}','ElectionController@toggle')->name('admin.elections.toggle');
});

//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
