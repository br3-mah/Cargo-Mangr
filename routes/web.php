<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\SocialAuthController;
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

Route::get('/signin', [AuthenticatedSessionController::class, 'main'])
->middleware('guest')
->name('signin');



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

Route::get('/auth/{provider}', [SocialAuthController::class, 'redirectToProvider'])->name('social.login');
Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback']);



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