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
// 🚚 CONSIGNMENT & PARCELS SYNC
Route::get('/consignments/{consignment_id}', [App\Http\Controllers\Api\ConsignmentController::class, 'getConsignmentWithParcels'])->name('consignment.details');
Route::get('/parcels/{tracking_number}', 'Api\ShipmentController@getParcelByTrackingNumber');
Route::get('/parcels/status/{status}', 'Api\ShipmentController@getParcelsByStatus');
// Change updated-since from GET to POST
Route::post('/parcels/updated-since', 'Api\ShipmentController@getParcelsUpdatedSince');
// 📥 PARCEL RECEIPT & DISPATCH CONFIRMATIONS
Route::post('/parcels/received-confirmation', [App\Http\Controllers\Api\ShipmentController::class, 'receivedConfirmation']);
Route::post('/parcels/dispatch-confirmation', [App\Http\Controllers\Api\ShipmentController::class, 'dispatchConfirmation']);
// 💸 INVOICING & CUSTOMER REFERENCE
Route::get('/invoices/{tracking_number}', [App\Http\Controllers\Api\ShipmentController::class, 'getInvoiceByTrackingNumber']);
Route::get('/customers/{customer_id}', [App\Http\Controllers\Api\ShipmentController::class, 'getCustomerById']);
// ⚠️ ISSUE FLAGGING
Route::post('/parcels/flag', [App\Http\Controllers\Api\ShipmentController::class, 'flagParcel']);
// 🔄 RECONCILIATION
Route::post('/reconcile', [App\Http\Controllers\Api\ShipmentController::class, 'reconcile']);
// 📊 ADMIN DASHBOARDS / BULK SYNC SUPPORT
Route::get('/consignments/latest', [App\Http\Controllers\Api\ConsignmentController::class, 'getLatestConsignment']);
Route::get('/parcels/unsynced', [App\Http\Controllers\Api\ShipmentController::class, 'getUnsyncedParcels']);