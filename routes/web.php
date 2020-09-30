<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\MainController::class, 'index'])->name('main');

Route::get('/', [App\Http\Controllers\MainController::class, 'index'])->name('main');

Route::get('/main', [App\Http\Controllers\MainController::class, 'index'])->name('main');

Route::get('/setting/paramter', function () {
    return view('setting.paramter');
});

Route::post('/result', 'App\Http\Controllers\ResultController@post');

Route::get('/add', 'App\Http\Controllers\HelloController@add');
Route::post('/add', 'App\Http\Controllers\helloController@create');

Route::get('/setting/edit', 'App\Http\Controllers\helloController@edit');
Route::post('/setting/edit', 'App\Http\Controllers\helloController@update');


Route::get('/keyword/add', 'App\Http\Controllers\KeywordController@add');
Route::post('/keyword/add', 'App\Http\Controllers\KeywordController@create');

Route::get('/keyword/edit/{id}', 'App\Http\Controllers\KeywordController@edit');
Route::post('/keyword/edit/{id}', 'App\Http\Controllers\KeywordController@update');

Route::get('/keyword', function () {
    return view('keyword.index');
});

Route::get('/keyword/delete/{id}', 'App\Http\Controllers\KeywordController@deleteEdit');
Route::post('/keyword/delete/{id}', 'App\Http\Controllers\KeywordController@delete');

/*seller*/
Route::get('/seller', function () {
    return view('seller.index');
});
Route::get('/seller/add', 'App\Http\Controllers\SellerController@add');
Route::post('/seller/add', 'App\Http\Controllers\SellerController@create');

Route::get('/seller/edit/{id}', 'App\Http\Controllers\SellerController@edit');
Route::post('/seller/edit/{id}', 'App\Http\Controllers\SellerController@update');

Route::get('/seller/delete/{id}', 'App\Http\Controllers\SellerController@deleteEdit');
Route::post('/seller/delete/{id}', 'App\Http\Controllers\SellerController@delete');


/*price*/
Route::get('/price', function () {
    return view('price.index');
});
Route::get('/price/edit', 'App\Http\Controllers\PriceController@edit');
Route::post('/price/edit', 'App\Http\Controllers\PriceController@update');

//管理側
Route::group(['middleware' => ['auth.admin']], function () {

    //管理側トップ
    Route::get('/admin', 'App\Http\Controllers\admin\AdminTopController@show');
    //ログアウト実行
    Route::post('/admin/logout', 'App\Http\Controllers\admin\AdminLogoutController@logout');
    //ユーザー一覧
    Route::get('/admin/resister', 'App\Http\Controllers\admin\ManageUserController@showUserList');
    //ユーザー詳細
    Route::get('/admin/user/{id}', 'App\Http\Controllers\admin\ManageUserController@showUserDetail');
});

//管理側ログイン
Route::get('/admin/login', 'App\Http\Controllers\admin\AdminLoginController@showLoginform');
Route::post('/admin/login', 'App\Http\Controllers\admin\AdminLoginController@login');
