<?php

use App\Http\Controllers\Admin\ConsignmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\OTPVerificationController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Auth\TwoFactorAuthController;
// use App\Http\Controllers\ConsignmentController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
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

// Admin routes
require __DIR__.'/admin.php';
// STANDARD LOGIN ROUTES
Route::get('/signin', [AuthenticatedSessionController::class, 'main'])
->middleware('guest')
->name('signin');
// REGISTRATION VERIFICATION ROUTES
// Route::get('/one-time-password-verification-otp', [OTPVerificationController::class, 'index'])
// ->name('verify.otp');
// Route::middleware(['auth'])->group(function () {
    Route::get('/verify-otp', [OTPVerificationController::class, 'index'])->name('verify.otp');
    Route::post('/verify-otp', [OTPVerificationController::class, 'verifyOtp'])->name('otp.verify');
    Route::post('/resend-otp', [OTPVerificationController::class, 'resendOtp'])->name('otp.resend');
// });

// SOCIAL LOGIN ROUTES
Route::get('/auth/{provider}', [SocialAuthController::class, 'redirectToProvider'])->name('social.login');
Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback']);

Route::get('/2fa/verify', [TwoFactorAuthController::class, 'showVerifyForm'])->name('2fa.verify');
Route::post('/2fa/verify', [TwoFactorAuthController::class, 'verify'])->name('2fa.verify.post');

Route::post('/2fa/enable', [TwoFactorAuthController::class, 'enable'])->name('2fa.enable');
Route::delete('/2fa/disable', [TwoFactorAuthController::class, 'disable'])->name('2fa.disable');
Route::post('/2fa/regenerate', [TwoFactorAuthController::class, 'regenerate'])->name('2fa.regenerate');



Route::get('/', 'HomeController@index')->name('home');
Route::get('/about-us', 'AboutUsController@index')->name('about-us');
Route::get('/our-services', 'ServicesController@index')->name('services');
Route::get('/contact-us', 'ContactUsController@index')->name('contact-us');
Route::get('/frequently-asked-questions', 'FAQController@index')->name('faq');
Route::get('/global-network', 'GlobalNetworkController@index')->name('network');
Route::get('/privacy-notice', 'PrivacyNoticeController@index')->name('privacy');
Route::get('/terms-of-use', 'TermsOfUseController@index')->name('terms');
Route::get('/fraud-awareness', 'FraudAwarenessController@index')->name('fraud');
Route::post('contact', 'Api\ContactUsController@sendContact')->name('contact.store');



Route::get('/consignment', 'ConsignmentController@index')->name('consignment.index');
Route::get('/create-consignment', 'ConsignmentController@create')->name('consignment.create');
Route::post('/consignment', 'ConsignmentController@store')->name('consignment.store');
Route::put('/consignment', 'ConsignmentController@update')->name('consignment.update');
Route::get('/consignment-details/{id}', 'ConsignmentController@show')->name('consignment.show');
Route::get('/consignment/{id}', 'ConsignmentController@edit')->name('consignment.edit');
Route::delete('/consignment/{id}', 'ConsignmentController@destroy')->name('consignment.destroy');
Route::post('/consignments/import', 'ConsignmentController@import')->name('consignment.import');


// if (\Illuminate\Support\Facades\Schema::hasTable('translations') && check_module('localization')) {
//     Route::group(
//         [
//             'prefix' => LaravelLocalization::setLocale(),
//             'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
//         ], function(){

//         // home
//         Route::get('/', 'HomeController@index')->name('home');
//         Route::get('/about-us', 'AboutUsController@index')->name('about-us');
//         Route::get('/our-services', 'ServicesController@index')->name('services');
//         Route::get('/contact-us', 'ContactUsController@index')->name('contact-us');
//         Route::get('/frequently-asked-questions', 'FAQController@index')->name('faq');

//         // if(env('DEMO_MODE') == 'On'){
//         //     Route::get('/theme', 'HomeController@index')->name('theme.demo.home');
//         // }

//         Route::get('/link-storage', function () {
//             Artisan::call('storage:link');
//         });
//     });
//     Route::mediaLibrary();
// }else{
//     // home
//     Route::get('/', 'HomeController@index')->name('home');
//     if(env('DEMO_MODE') == 'On'){
//         Route::get('/theme', 'HomeController@index')->name('theme.demo.home');
//     }

//     Route::get('/link-storage', function () {
//         Artisan::call('storage:link');
//     });
//     Route::mediaLibrary();
// }