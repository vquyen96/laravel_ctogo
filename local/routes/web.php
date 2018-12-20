<?php

use \Illuminate\Support\Facades\Route;

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
Route::get('test', function () {
    return view('public.support.review');
});

Route::group(['namespace' => 'Pub'], function () {
    Route::get('/', 'HomeController@getIndex');
    Route::get('home', 'HomeController@getHome')->name('home');
    Route::get('ajax-blog', 'HomeController@getBlogs');
    Route::get('contact-us', 'HomeController@getContactUs');
    Route::get('terms-and-conditions', 'HomeController@getTermsConditions');
    Route::get('copyright', 'HomeController@getCopyright');
    Route::get('support', 'HomeController@getSupport');

    Route::get('search-result', 'HomeController@getSearch');
    Route::get('detail/{id}', 'HomeController@getDetail')->name('detail_homestay');

    Route::get('register', 'HomeController@getRegister');
    Route::get('search', 'SearchController@getSearch');

    Route::post('search-ajax', 'SearchController@getAjaxSearch');
    Route::post('check-ajax', 'CheckController@getAjaxCheck');

    Route::group(['prefix' => 'signup', 'middleware' => 'CheckLoggedIn'], function () {
        Route::get('/', 'UserController@getSignup');
        Route::post('/', 'UserController@postSignup');
    });

    Route::group(['prefix' => 'login', 'middleware' => 'CheckLoggedIn'], function () {
        Route::get('/', 'LoginController@getLogin')->name('login');
        Route::post('/', 'LoginController@postLogin');
    });

    Route::group(['prefix' => 'user', 'middleware' => 'CheckLoggedOut'], function () {
        Route::get('logout', 'LoginController@getLogout');
        Route::get('/', 'UserController@getBlank');
        Route::get('profile', 'UserController@getProfile')->name('getProfile');
        Route::get('seeDetailModal', 'UserController@seeDetailModal');
        Route::get('notification', 'UserController@getNotification');
        Route::get('book', 'UserController@getBook');

        Route::post('updateProfile', 'UserController@postUpdateProfile');
        Route::post('ajaxAvatar', 'UserController@postAjaxAvatar');
        Route::post('upload_image_payment', 'UserController@upload_image_payment')->name('upload_image_payment');

        Route::post('updatePassword', 'UserController@postUpdatePassword');

        Route::post('add_order', 'OrderController@add_order')->name('add_order');
        Route::get('update_status_book/{id}/{status}', "UserController@update_status_book")->name('update_status_book');
    });
});

Route::group(['namespace' => 'Payment', 'middleware' => 'CheckLoggedOut'], function () {
    Route::get('/info_payment', 'PaymentController@info_payment')->name('info_payment');
    Route::get('/action_info_payment', 'PaymentController@action_info_payment')->name('action_info_payment');
    Route::get('/payment_method', 'PaymentController@payment_method')->name('payment_method');
    Route::post('/action_payment_method', 'PaymentController@action_payment_method')->name('action_payment_method');
    Route::get('/update_status/{book_id}/{status}', 'PaymentController@update_status')->name('update_status');
    Route::get('/update_status_nl/{book_id}/{status}', 'PaymentController@update_status_nl')->name('update_status_nl');
    Route::get('/complete', 'PaymentController@complete')->name('complete');
    Route::get('/check_status_book/{id}', 'PaymentController@check_status_book')->name('check_status_book');
    Route::get('/ck_confirm/{id}', 'PaymentController@ck_confirm')->name('ck_confirm');
});

Route::group(['namespace' => 'Auth'], function () {
    Route::get('/redirect/{social}', 'SocialAuthController@redirect')->name('soicial');
    Route::get('/callback/{social}', 'SocialAuthController@callback')->name('soicial_callback');
});

Route::post('/notification', function (Illuminate\Http\Request $request) {
    event(new App\Events\NotiEvent($request->get('message'), $request->get('book_id')));
    return [
        'status' => true,
    ];
})->name('notification');


Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::group(['prefix' => 'login', 'middleware' => 'CheckAdminLoggedIn'], function () {
        Route::get('/', 'AuthController@getLogin');
        Route::post('/', 'AuthController@postLogin');
    });
    Route::group(['middleware' => 'CheckAdminLoggedOut'], function () {
        Route::get('logout', 'AdminController@getLogout');

        Route::get('/', function () {
            return view('admin.index.index');
        });

        Route::group(['prefix' => 'account','middleware' => 'CheckSuperAccount'], function () {
            Route::get('/', 'AccountController@index');
            Route::post('add', 'AccountController@store');
            Route::post('updatePermission/{id}','AccountController@updatePermission');
            Route::post('resetPassword/{id}','AccountController@resetPassword');
            Route::get('delete/{id}', 'AccountController@delete');
        });

        Route::group(['prefix' => 'guest','middleware' => 'CheckGuestPermission'], function () {
            Route::get('', 'GuestController@index')->name('list_guest');
            Route::get('/update_status_guest/{id}', 'GuestController@update_status')->name('update_status_guest');
            Route::get('/delete_guest/{id}', 'GuestController@delete_guest')->name('delete_guest');
            Route::get('/detail_guest', 'GuestController@detail_guest')->name('detail_guest');
        });

        Route::group(['prefix' => 'host','middleware' => 'CheckHostPermission'], function () {
            Route::get('', 'HostController@index')->name('list_host');
            Route::get('/update_status_host/{id}', 'HostController@update_status')->name('update_status_host');
            Route::get('/delete_host/{id}', 'HostController@delete_host')->name('delete_host');
            Route::get('/detail_host/{host_id}', 'HostController@detail_host')->name('detail_host');
        });

        Route::group(['prefix' => 'books','middleware' => 'CheckHostPermission'], function () {
            Route::get('', 'BooksController@index')->name('list_book');
            Route::get('seeDetailModal', 'BooksController@seeDetailModal')->name('seeDetailModal');
            Route::get('update_status/{book_id}/{status}', 'BooksController@update_status')->name('update_book_status');
        });

        Route::group(['prefix' => 'comment','middleware' => 'CheckCommentPermission'], function () {
            Route::get('', 'CommentController@index')->name('list_comment');
            Route::get('/update_status_comment/{id}', 'CommentController@update_status')->name('update_status_comment');
            Route::get('/update_home_comment/{id}', 'CommentController@update_home')->name('update_home_comment');
            Route::get('/delete_comment/{id}', 'CommentController@delete_comment')->name('delete_comment');
            Route::get('/sort_comment', 'CommentController@sort_comment')->name('sort_comment');
            Route::get('/delete_comment_hot/{id}', 'CommentController@delete_comment_hot')->name('delete_comment_hot');
            Route::post('/update_sort_comment', 'CommentController@update_sort_comment')->name('update_sort_comment');
        });

        Route::group(['prefix' => 'homestay','middleware' => 'CheckHomestayPermission'], function () {
            Route::get('', 'HomestayController@index')->name('list_homestay');
            Route::get('list_non_active', 'HomestayController@list_non_active')->name('list_non_active');
            Route::get('/update_status_homestay/{id}', 'HomestayController@update_status')->name('update_status_homestay');
            Route::get('/delete_homestay/{id}', 'HomestayController@delete_homestay')->name('delete_homestay');
            Route::get('/sort_homestay', 'HomestayController@sort_homestay')->name('sort_homestay');
            Route::get('/delete_homestay_hot/{id}', 'HomestayController@delete_homestay_hot')->name('delete_homestay_hot');
            Route::get('/view_detail/{id}', 'HomestayController@view_detail')->name('view_detail');
            Route::post('/update_sort_homestay', 'HomestayController@update_sort_homestay')->name('update_sort_homestay');
        });

        Route::group(['prefix' => 'config','middleware' => 'CheckConfigPermission'], function () {
            Route::get('/', 'ConfigController@index');
            Route::post('banner', 'ConfigController@updateBanner');
            Route::get('banner/delete/{key}', 'ConfigController@deleteBanner');
            Route::post('info', 'ConfigController@updateInfo');
            Route::post('term', 'ConfigController@updateTerm');
            Route::post('policy', 'ConfigController@updatePolicy');
        });

        Route::group(['prefix' => 'website-info','middleware' => 'CheckConfigPermission'], function () {
            Route::get('/', 'InfoWebsiteController@index')->name('website_info');
            Route::post('update_info', 'InfoWebsiteController@update_info')->name('update_info');
        });

        Route::get('general', function () {
            return view('admin.index.forms.general');
        });
        Route::get('advanced', function () {
            return view('admin.index.forms.advanced');
        });
        Route::get('editors', function () {
            return view('admin.index.forms.editors');
        });
        Route::get('simple', function () {
            return view('admin.index.tables.simple');
        });
        Route::get('data', function () {
            return view('admin.index.tables.data');
        });
        Route::get('profile', function () {
            return view('admin.index.profile.profile');
        });
    });
});