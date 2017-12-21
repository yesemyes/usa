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

Route::get('/', function () {return view('welcome');});
Route::get('/create-worker', function() {return view('create.workers');})->middleware('auth');
Route::get('/create-payment-method', function() {return view('create.payment-method');})->middleware('auth');
Route::get('/create-payment-type', function() {return view('create.payment-type');})->middleware('auth');
Route::get('/create-marketing-source', function() {return view('create.marketing-source');})->middleware('auth');
//Route::get('/search', function() {return view('show.search');})->middleware('auth');
//Route::get('/create-transaction', function() {return view('create.transaction');})->middleware('auth');

Auth::routes();
/* HomeController */
Route::get('/dashboard', 'Show\ShowController@dashboard');
/* ShowController */
Route::get('/search', 'Show\ShowController@search');
Route::post('/search', 'Show\ShowController@search');
Route::get('/workers', 'Show\ShowController@workers');
Route::get('/worker/{id}', 'Show\ShowController@worker');
Route::get('/payment-methods', 'Show\ShowController@paymentMethod');
Route::get('/payment-types', 'Show\ShowController@paymentType');
Route::get('/marketing-sources', 'Show\ShowController@marketingSource');
Route::get('/create-transaction', 'Show\ShowController@createTransaction');
Route::get('/transactions', 'Show\ShowController@transactions');
Route::get('/manage-transaction/{id}', 'Show\ShowController@transaction');
Route::any('/report', 'Show\ShowController@report');
/* UpdateController */
Route::post('/updateWorker/{id}', 'Update\UpdateController@worker');
Route::post('/updatePaymentMethod', 'Update\UpdateController@paymentMethod');
Route::post('/updatePaymentType', 'Update\UpdateController@paymentType');
Route::post('/updateMarketingSource', 'Update\UpdateController@marketingSource');
Route::post('/updateTransaction/{id}', 'Update\UpdateController@transaction');
/* CreateController */
Route::post('/createWorker', 'Create\CreateController@createWorkerAction');
Route::post('/createPaymentMethod', 'Create\CreateController@createPaymentMethodAction');
Route::post('/createPaymentType', 'Create\CreateController@createPaymentTypeAction');
Route::post('/createMarketingSource', 'Create\CreateController@createMarketingSourceAction');
Route::post('/createTransaction', 'Create\CreateController@createTransactionAction');
/* DeleteController */
Route::post('/deleteWorker/{id}', 'Delete\DeleteController@worker');
Route::post('/deleteTrDetalis/{id}', 'Delete\DeleteController@transaction_detalis');
