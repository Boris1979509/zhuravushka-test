<?php

use Illuminate\Support\Facades\Auth;
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
Route::get('phpinfo', function () {
    phpinfo();
});
/* home */
Route::group([
    'namespace' => 'Pages',
], static function () {
    Route::get('/', 'PageController@index')->name('home');
    Route::group([
        'prefix' => 'page',
    ], static function () {
        //Route::get('/uslugi/{slug?}', 'PageController@services')->name('page.service');
        Route::get('/{slug}', 'PageController@page')->name('page');
    });
});


Route::group([
    'namespace' => 'Blog',
], static function () {
    Route::get('blog', 'BlogController@index')->name('blog');
    Route::group([
        'prefix' => 'blog',
        'as'     => 'blog.',
    ], static function () {
        Route::get('post/{postSlug}', 'PostController@index')->name('post');
        Route::get('category/{CategorySlug}', 'BlogController@getByCategory')->name('category');
    });
});
// cart
Route::group([
    'namespace' => 'Shop',
], static function () {
    Route::get('cart', 'CartController@index')->name('cart');
    Route::get('category', 'ProductCategoryController@index')->name('catalog');
    Route::get('category/{categorySlug}', 'ProductCategoryController@category')->name('category');
    Route::get('product/{slug}', 'ProductController@index')->name('product');
    /* Favorites */
    Route::get('favorite', 'FavoriteController@index')->name('favorite');
    Route::post('favorite/{product}/add', 'FavoriteController@add')->name('favorite.add');
    Route::post('favorite/{product}/remove', 'FavoriteController@remove')->name('favorite.remove');
    /* Compare */
    Route::get('compare', 'CompareController@index')->name('compare');
    Route::post('compare/{product}/add', 'CompareController@add')->name('compare.add');
    Route::post('compare/{product}/remove', 'CompareController@remove')->name('compare.remove');
    /* Search */
    Route::get('search/result', 'SearchController@index')->name('search');
    Route::post('autocomplete', 'SearchController@search');
    Route::group([
        'as'     => 'cart.',
        'prefix' => 'cart',
    ], static function () {
        Route::post('add/{product}', 'CartController@add')->name('add');
        Route::post('remove/{product}', 'CartController@remove')->name('remove');
    });
});
// Order
Route::group([
    'namespace'  => 'Order',
    'prefix'     => 'order',
    'as'         => 'order.',
    'middleware' => 'check_is_not_empty_cart',
], static function () {
    Route::get('place', 'OrderController@place')->name('place');
    Route::post('confirm', 'OrderController@confirm')->name('confirm');
    Route::get('confirm-no-paid', 'OrderController@confirmNoPaid')->name('confirmNoPaid');
    Route::get('confirm-payment', 'OrderController@confirmPayment')->name('confirm.payment');
    Route::get('cancel-payment', 'OrderController@cancelPayment')->name('cancel.payment');
});

//Auth::routes(['login' => false]); // except route
Auth::routes(); // except route

// User Cabinet
Route::group([
    'namespace'  => 'Cabinet',
    'prefix'     => 'cabinet',
    'as'         => 'cabinet.',
    'middleware' => 'auth',
], static function () {
    Route::get('/', 'HomeController@index')->name('home');
    /* Profile */
    Route::get('/profile', 'ProfileController@index')->name('profile.home');
    Route::get('/profile/edit', 'ProfileController@edit')->name('profile.edit');
    Route::post('/profile/update', 'ProfileController@update')->name('profile.update');
    Route::get('/profile/change-password', 'ChangePasswordController@index')->name('change.password.index');
    Route::post('/profile/change-password', 'ChangePasswordController@store')->name('change.password');
    /* End Profile */
    //Route::get('/favorite', 'FavoriteController@index')->name('favorite');
    Route::get('/feedback', 'FeedbackController@index')->name('feedback');
    Route::post('/feedback/send', 'FeedbackController@send')->name('feedback.send');
    Route::get('/comment', 'CommentController@index')->name('comment');
    Route::get('/order', 'OrderController@index')->name('order');
});
// Phone register verify
Route::group(['namespace' => 'Auth',], static function () {
    Route::post('/phone', 'PhoneController@request')->name('phone.request');
    Route::post('/verify', 'PhoneController@verify')->name('phone.verify');
    // Route::post('/login', 'LoginController@login')->name('login');
});
// Admin
Route::group([
    'namespace'  => 'Admin',
    'prefix'     => 'admin',
    'as'         => 'admin.',
    'middleware' => ['auth', 'can:admin-panel'],
], static function () {

    Route::get('/', 'HomeController@index')->name('home');
    // Admin Users
    Route::group([
        'namespace' => 'Users',
    ], static function () {
        Route::resource('users', 'UsersController');
    });

    // Admin Blog
    Route::group([
        'namespace' => 'Blog',
        'prefix'    => 'blog',
        'as'        => 'blog.',
    ], static function () {
        $methods = ['index', 'edit', 'store', 'update', 'create', 'destroy'];
        Route::resource('categories', 'CategoryController')->only($methods);
        Route::resource('posts', 'PostController')->except('show');
        Route::get('posts/{post}/restore', 'PostController@restore')->name('post.restore');
        Route::get('categories/{category}/restore', 'CategoryController@restore')->name('category.restore');
    });
    // Admin Orders
    Route::group([
        'namespace' => 'Orders',
        'as' => 'orders.',
    ], static function () {
        Route::get('orders', 'OrderController@index')->name('index');
    });
});


