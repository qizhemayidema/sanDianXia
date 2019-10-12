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

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('/', 'IndexController@index')->name('admin.index.index');
    Route::get('/home_page', 'IndexController@homePage')->name('admin.homePage');

    Route::group(['prefix' => 'roll_banner'], function () {
        Route::get('/', 'RollBannerController@index')->name('admin.roll.index');
        Route::get('/add', 'RollBannerController@add')->name('admin.roll.add');
        Route::post('/save', 'RollBannerController@save')->name('admin.roll.save');
        Route::get('/edit', 'RollBannerController@edit')->name('admin.roll.edit');
        Route::post('/update', 'RollBannerController@update')->name('admin.roll.update');
        Route::post('/delete/{roll_id}', 'RollBannerController@delete')->name('admin.roll.delete');
    });

    Route::group(['prefix' => 'service_network'], function () {
        Route::get('/', 'ServiceNetworkController@index')->name('admin.network.index');
        Route::get('/add', 'ServiceNetworkController@add')->name('admin.network.add');
        Route::post('/save', 'ServiceNetworkController@save')->name('admin.network.save');
        Route::get('/edit', 'ServiceNetworkController@edit')->name('admin.network.edit');
        Route::post('/update', 'ServiceNetworkController@update')->name('admin.network.update');
        Route::post('/delete/{network_id}', 'ServiceNetworkController@delete')->name('admin.network.delete');
    });

    Route::group(['prefix' => 'cate'], function () {
        Route::get('/', 'CateController@index')->name('admin.cate.index');
        Route::get('/add', 'CateController@add')->name('admin.cate.add');
        Route::post('/save', 'CateController@save')->name('admin.cate.save');
        Route::get('/edit/{cate_id}', 'CateController@edit')->name('admin.cate.edit');
        Route::post('/delete_attr', 'CateController@deleteAttr')->name('admin.cate.deleteAttr');
        Route::post('/update/{cate_id}', 'CateController@update')->name('admin.cate.update');
        Route::post('/delete/{cate_id}', 'CateController@delete')->name('admin.cate.delete');
    });

    Route::group(['prefix' => 'message'], function () {
        Route::get('/', 'MessageController@index')->name('admin.message.index');
        Route::get('/add', 'MessageController@add')->name('admin.message.add');
        Route::get('/check_status/{msg}', 'MessageController@checkStatus')->name('admin.message.check_status');
        Route::post('/change_status', 'MessageController@changeStatus')->name('admin.message.change_status');
        Route::post('/save', 'MessageController@save')->name('admin.message.save');
        Route::get('/edit/{msg}', 'MessageController@edit')->name('admin.message.edit');
        Route::post('/update/{msg}', 'MessageController@update')->name('admin.message.update');
        Route::post('/delete/{msg}', 'MessageController@delete')->name('admin.message.delete');
        Route::post('/getAttr', 'MessageController@getAttr')->name('admin.message.getAttr');
    });

    Route::group(['prefix' => 'vip'], function () {
        Route::get('/', 'VipController@index')->name('admin.vip.index');
        Route::get('/add', 'VipController@add')->name('admin.vip.add');
        Route::post('/save', 'VipController@save')->name('admin.vip.save');
        Route::get('/edit/{vip_id}', 'VipController@edit')->name('admin.vip.edit');
        Route::post('/update/{vip_id}', 'VipController@update')->name('admin.vip.update');
        Route::post('/delete/{vip_id}', 'VipController@delete')->name('admin.vip.delete');
    });

    Route::group(['prefix' => 'store_service'], function () {
        Route::get('/', 'StoreServiceController@index')->name('admin.storeService.index');
        Route::get('/add', 'StoreServiceController@add')->name('admin.storeService.add');
        Route::post('/save', 'StoreServiceController@save')->name('admin.storeService.save');
        Route::get('/edit/{service_id}', 'StoreServiceController@edit')->name('admin.storeService.edit');
        Route::post('/update/{service_id}', 'StoreServiceController@update')->name('admin.storeService.update');
        Route::post('/delete/{service_id}', 'StoreServiceController@delete')->name('admin.storeService.delete');
    });

    Route::group(['prefix' => 'config'], function () {
        Route::get('/', 'ConfigController@index')->name('admin.config.index');
        Route::post('/save', 'ConfigController@save')->name('admin.config.save');
    });

    Route::group(['prefix' => 'login'], function () {
        Route::get('/', 'LoginController@index')->name('admin.login');
        Route::post('check', 'LoginController@check')->name('admin.login.check');
        Route::get('logout', 'LoginController@logout')->name('admin.login.logout');
    });

    Route::group(['prefix' => 'feedback'], function () {
        Route::get('index', 'FeedbackController@index')->name('admin.feedback.index');
    });

    Route::group(['prefix' => 'article'], function () {
        Route::get('/', 'ArticleController@index')->name('admin.article.index');
        Route::post('/check', 'ArticleController@check')->name('admin.article.check');
    });

    Route::group(['prefix' => 'goods'], function () {
        Route::get('/', 'GoodsController@index')->name('admin.goods.index');
        Route::post('/check', 'GoodsController@check')->name('admin.goods.check');
    });
});

Route::any('/index/user/callback', 'Index\UserController@callback')->name('index.user.callback');


Route::group(['prefix' => '/', 'suffix' => 'html', 'namespace' => 'Index', 'middleware' => ['wechat.oauth']], function () {

    Route::match(['get', 'post'], '/', 'IndexController@index')->name('index.index');

    Route::post('/msg/buy', 'MessageController@buy')->name('index.message.buy');

    Route::get('/msg/sub', 'MessageController@subMsg')->name('index.message.sub');

    Route::post('/msg/get_attr', 'MessageController@getAttr')->name('index.message.attr');
    Route::post('/msg/save_attr', 'MessageController@saveSelectAttr')->name('index.message.save_attr');

    Route::get('/msg/{msg_id}', 'IndexController@info')->name('index.message.info');

    Route::match(['get', 'post'], '/my_msg', 'MyMessageController@index')->name('index.my_msg.index');

    Route::match(['get', 'post'], '/store', 'StoreController@index')->name('index.store.index');

    Route::group(['prefix' => '/user'], function () {
        Route::get('/', 'UserController@index')->name('index.user.index');
        Route::get('/service', 'UserController@service')->name('index.user.service');
        Route::match(['get', 'post'], '/history', 'UserController@history')->name('index.user.history');
        Route::get('/my_service', 'UserController@myService')->name('index.user.my_service');
        Route::get('/feedback', 'UserController@feedback')->name('index.user.feedback');
        Route::get('/about', 'UserController@about')->name('index.user.about');
        Route::get('/info', 'UserController@userInfo')->name('index.user.info');
        Route::get('/edit_info', 'UserController@editUserInfo')->name('index.user.edit_info');


        Route::post('/change_user_sub_status', 'UserController@changeUserSubStatus')->name('index.user.change_sub_status');
        Route::post('/change_user_sub_area', 'UserController@changeUserSubArea')->name('index.user.change_sub_area');
        Route::post('/feedback_save', 'UserController@saveFeedback')->name('index.user.feedback_save');
        Route::post('/get_phone_code', 'UserController@getPhoneCode')->name('index.user.get_phone_code');
        Route::post('/update_info', 'UserController@updateUserInfo')->name('index.user.update_info');

    });

});

Route::group(['prefix' => 'pc', 'suffix' => 'html', 'namespace' => 'Pc'], function () {
    Route::get('/', 'IndexController@index')->name('pc.index.index');
    Route::get('rz', 'RzController@index')->name('pc.rz.rz');
    Route::get('/productShow', 'ProductShowController@index')->name('pc.productShow.index');
    Route::get('/information', 'ArticleController@information')->name('pc.information.index');
    Route::get('/question', 'ArticleController@question')->name('pc.question.index');
    Route::get('/search','IndexController@search')->name('pc.index.search');

    Route::post('/login', 'LoginController@login')->name('pc.login.login');
    Route::post('/message/save', 'MessageController@save')->name('pc.message.save');

    Route::group(['prefix' => '/my', 'middleware' => ['pc.loginCheck']], function () {
        Route::group(['prefix' => '/cate'], function () {
            Route::get('/', 'MyCateController@index')->name('pc.my.cate');
            Route::post('/save', 'MyCateController@save')->name('pc.my.cate.save');
            Route::post('/update', 'MyCateController@update')->name('pc.my.cate.update');
            Route::post('/changeStatus', 'MyCateController@changeStatus')->name('pc.my.cate.changeStatus');
            Route::post('/delete', 'MyCateController@delete')->name('pc.my.cate.delete');
        });
        Route::group(['prefix' => '/goods'], function () {
            Route::get('/', 'MyGoodsController@index')->name('pc.my.goods');
            Route::get('/add', 'MyGoodsController@add')->name('pc.my.goods.add');
            Route::post('/save', 'MyGoodsController@save')->name('pc.my.goods.save');
            Route::post('/getAttr', 'MyGoodsController@getAttr')->name('pc.my.goods.getAttr');
            Route::get('/edit', 'MyGoodsController@edit')->name('pc.my.goods.edit');
            Route::post('/update', 'MyGoodsController@update')->name('pc.my.goods.update');
            Route::post('/delete', 'MyGoodsController@delete')->name('pc.my.goods.delete');
        });
        Route::group(['prefix' => '/article'], function () {
            Route::get('/', 'MyArticleController@index')->name('pc.my.article');
            Route::get('/add', 'MyArticleController@add')->name('pc.my.article.add');
            Route::post('/save', 'MyArticleController@save')->name('pc.my.article.save');
            Route::get('/edit', 'MyArticleController@edit')->name('pc.my.article.edit');
            Route::post('/update', 'MyArticleController@update')->name('pc.my.article.update');
            Route::post('/delete', 'MyArticleController@delete')->name('pc.my.article.delete');
        });
        Route::group(['prefix' => '/info'], function () {
            Route::get('/', 'MyInfoController@index')->name('pc.my.info');
            Route::post('/save', 'MyInfoController@save')->name('pc.my.info.save');
        });
    });

    Route::group(['prefix' => '/store'],function(){
        Route::get('/goods/{goods_id}','StoreController@goods')->name('pc.store.goods');
        Route::get('/article/{article_id}','StoreController@article')->name('pc.store.article');
        Route::get('/{store_id}','StoreController@index')->name('pc.store.index');
    });
});

Route::group(['prefix' => '/pay', 'suffix' => 'html', 'namespace' => 'Index'], function () {
    Route::post('/vip', 'PayController@payVip')->name('index.pay.vip')->middleware('wechat.oauth');
    Route::post('/service', 'PayController@payStoreService')->name('index.pay.service')->middleware('wechat.oauth');
    Route::post('/credit', 'PayController@payAccountMoney')->name('index.pay.credit')->middleware('wechat.oauth');

    Route::any('/notify', 'PayController@notify')->name('index.pay.notify');
});



Route::group(['prefix' => '/common', 'namespace' => 'Common'], function () {
    Route::post('/uploadCommonImage', 'UploadController@uploadCommonImage')->name('common.upload.uploadCommonImage');

});