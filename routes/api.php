<?php

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

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['namespace' => 'App\Http\Controllers\Api'], function ($api) {
	$api->post('login', 'AuthenticateController@authenticate');

        $api->get('agree', 'AuthenticateController@agree');
    $api->group(array('middleware' => 'AuthJWT'), function ($api) {
        $api->POST('confirm_agree', 'AuthenticateController@confirm_agree');
    });


	$api->group(array('prefix' => 'client', 'middleware' => 'AuthJWT'), function ($api) {
		$api->POST('/', 'Client\ClientController@index');
		$api->POST('getclient', 'Client\ClientController@getclient');
	});

	$api->group(array('prefix' => 'category', 'middleware' => 'AuthJWT'), function ($api) {
		$api->POST('/', 'Category\CategoryController@index');
	});

	$api->group(array('prefix' => 'device', 'middleware' => 'AuthJWT'), function ($api) {
		$api->POST('/getdevice', 'Device\DeviceController@index');
		$api->POST('/comparedevice', 'Device\DeviceController@deviceCompare');
	});

	$api->group(array('prefix' => 'order', 'middleware' => 'AuthJWT'), function ($api) {
		$api->POST('/getorderdetails', 'Order\OrderController@index');
		$api->POST('/confirmorder', 'Order\OrderController@ConfirmOrder');

	});

	$api->group(array('prefix' => 'neptune', 'middleware' => 'AuthJWT'), function ($api) {
		$api->POST('/getcategorydeviceswithlogindetails', 'Neptune\NeptuneController@index');
		$api->POST('/marketshare', 'Neptune\NeptuneController@marketshare');
		$api->POST('/saving', 'Neptune\NeptuneController@saving');

	});

	$api->group(array('prefix' => 'app', 'middleware' => 'AuthJWT'), function ($api) {
		$api->POST('/getcategoryapp', 'APP\APPController@index');
		$api->POST('/getusercategoryapp', 'APP\APPController@userapp');
	});

	$api->group(array('prefix' => 'savings', 'middleware' => 'AuthJWT'), function ($api) {
		$api->POST('/', 'Saving\SavingController@index');
		$api->POST('/usersaving', 'Saving\SavingController@usersaving');
		$api->POST('/clientsaving', 'Saving\SavingController@clientsaving');
		$api->POST('/userwise_saving', 'Saving\SavingController@userwise_saving');
	});

});
