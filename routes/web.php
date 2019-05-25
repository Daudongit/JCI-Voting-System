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
    return view('frontend.login');
});

Route::get('/test', function () {
    
    $election = App\Election::find(1)->with('slots.nominees')->first();
    return view('election',compact('election'));
});

Route::post('/test',function(Request $request){
    
    //dd($results);
});

Route::group(['namespace'=>'Front'],function(){
    Route::get('elections','VotingController@index');
    Route::get('vote/{election}','VotingController@show');
    Route::post('vote/{election}','VotingController@store');
});

Route::group(['namespace'=>'Admin','prefix'=>'admin'],function(){
    Route::get('dashboard','DashboardController@index')->name('admin.dashboard');
    Route::resource('nominees','NomineeController',['as'=>'admin']);
    Route::resource('elections','ElectionController',['as'=>'admin']);
    Route::resource('positions','PositionController',['as'=>'admin']);
    Route::resource('slots','SlotController',['as'=>'admin']);
    Route::patch('elections/toggle/{election}','ElectionController@toggle')->name('admin.elections.toggle');
});

//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
