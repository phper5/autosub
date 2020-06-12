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
use Yansongda\LaravelPay\Facades\Pay;

Route::get('/', function () {
    return view('autosub');
    //return view('welcome');
});
Route::get('/t2/{id}', function (\Illuminate\Http\Request $request,$id) {
    $order = [
        'out_trade_no' => time(),
        'total_amount' => '0.01',
        'subject' => $id.'---:'.config('app.name'),
    ];

    $result =  Pay::alipay()->scan($order);
    //return $result;
    $qr = $result->qr_code;
    return $qr;
});
Route::get('support', function () {
    return view('support');
});
Route::get('support/sent', function () {
    return view('support/sent');
});
Route::post('support', 'SupportController@post');

Route::get('feedback', function () {
    return view('feedback');
});
Route::get('pricing', function () {
    return view('pricing');
});
Route::get('api', function () {
    return view('api');
});
Route::get('image-tools', function (){
    return view('image-tools');
})->name('image-tools');



Route::get('image-tools/watermark-removal-auto', function (){
    return view('image-tools/autosub');
})->name('autosub');


Route::get('articles', 'AritcleController@index')->name('articles');
Route::get('articles/{id}/{slug}', 'AritcleController@show')->name('article');

Route::get('sm', function () {
    \Spatie\Sitemap\Sitemap::create("/image-tools/inpainting-image")
        ->add(\Spatie\Sitemap\Tags\Url::create('/')
//            ->setLastModificationDate(\Illuminate\Support\Carbon::yesterday())
            ->setChangeFrequency(\Spatie\Sitemap\Tags\Url::CHANGE_FREQUENCY_ALWAYS)
//            ->setPriority(0.1)
            )
        ->add(\Spatie\Sitemap\Tags\Url::create('/image-tools/inpainting-image')
//            ->setLastModificationDate(\Illuminate\Support\Carbon::yesterday())
            ->setChangeFrequency(\Spatie\Sitemap\Tags\Url::CHANGE_FREQUENCY_WEEKLY)
            ->setPriority(0.8)
        )
        ->add(\Spatie\Sitemap\Tags\Url::create('/image-tools')
//            ->setLastModificationDate(\Illuminate\Support\Carbon::yesterday())
            ->setChangeFrequency(\Spatie\Sitemap\Tags\Url::CHANGE_FREQUENCY_WEEKLY)
            ->setPriority(0.8)
        )
        ->add(\Spatie\Sitemap\Tags\Url::create('/image-tools/compress-image')
//            ->setLastModificationDate(\Illuminate\Support\Carbon::yesterday())
            ->setChangeFrequency(\Spatie\Sitemap\Tags\Url::CHANGE_FREQUENCY_WEEKLY)
            ->setPriority(0.8)
        )
        -> writeToFile("sitemap.xml");
    //\Spatie\Sitemap\Sitemap::create("http://diandi.org")->writeToDisk('public','sitemap.xml');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



Route::namespace('Studio')->prefix(config('studio.path'))->group(function () {
    Route::prefix('api')->group(function () {
        Route::prefix('posts')->group(function () {
            Route::get('/', 'PostController@index');
            Route::get('{identifier}/{slug}', 'PostController@show')->middleware('Canvas\Http\Middleware\Session');
        });

        Route::prefix('tags')->group(function () {
            Route::get('/', 'TagController@index');
            Route::get('{slug}', 'TagController@show');
        });

        Route::prefix('topics')->group(function () {
            Route::get('/', 'TopicController@index');
            Route::get('{slug}', 'TopicController@show');
        });

        Route::prefix('users')->group(function () {
            Route::get('{identifier}', 'UserController@show');
        });
    });

    Route::get('/{view?}', 'ViewController')->where('view', '(.*)')->name('studio');
});

Route::namespace('Studio')->prefix(config('studio.path'))->group(function () {
    Route::prefix('api')->group(function () {
        Route::prefix('posts')->group(function () {
            Route::get('/', 'PostController@index');
            Route::get('{identifier}/{slug}', 'PostController@show')->middleware('Canvas\Http\Middleware\Session');
        });

        Route::prefix('tags')->group(function () {
            Route::get('/', 'TagController@index');
            Route::get('{slug}', 'TagController@show');
        });

        Route::prefix('topics')->group(function () {
            Route::get('/', 'TopicController@index');
            Route::get('{slug}', 'TopicController@show');
        });

        Route::prefix('users')->group(function () {
            Route::get('{identifier}', 'UserController@show');
        });
    });

    Route::get('/{view?}', 'ViewController')->where('view', '(.*)')->name('studio');
});
