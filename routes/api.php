<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Get Google Map Settings Api Route
Route::get('checkGoogleMap', 'Api\GoogleSettingsController@googleMapSettings');

Route::post('/mark-as-paid', 'Api\ShipmentController@paid')->name('mark.paid');
Route::get('/search-shipments', 'Api\ShipmentController@search')->name('search.shipments');
Route::post('/submit-shipments', 'Api\ConsignmentController@addShipmentsToConsignment')->name('submit.shipments');
Route::get('/search-consignments', 'Api\ConsignmentController@searchConsignments');
Route::post('consignments/{consignmentId}/remove-shipment/{shipmentId}', 'Api\ConsignmentController@removeShipmentFromConsignment')->name('consignments.remove-shipment');
Route::get('get-current-stage', [App\Http\Controllers\ConsignmentController::class, 'getCurrentStage']);