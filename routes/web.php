<?php

use Illuminate\Support\Facades\Redirect;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
 */

Route::get('/admin', function () {
    if (!Auth::check()) {
        return Redirect::to("admin/login");
    } else {
        if (Auth::user()->roll == 1) {
            return Redirect::to("admin/clients");
        } else if (Auth::user()->roll == 2) {
            return Redirect::to("admin/clients");
        } else if (Auth::user()->roll == 4) {
            return Redirect::to("admin/orders");
        } else if (Auth::user()->roll == 5) {
            return Redirect::to("admin/marketshare");
        }
    }
})->name('admin');

Route::get('/', function () {
    if (!Auth::check()) {
        return Redirect::to("login");
    } else {
        if (Auth::user()->roll == 5) {
            return Redirect::to("repcasetracker");
        } else if (Auth::user()->roll == 1) {
            return Redirect::to("admin/clients");
        } else {
            return Redirect::to('menu');
        }
    }
});

Route::get('admin/agreeuser', array('uses' => 'client@agreeuser'));

Route::post('admin/agreeconditionsuser', array('uses' => 'client@agreeconditionsuser'));

//client
Route::get('admin/clients', ['middleware' => ['auth', 'roll'], 'uses' => 'client@index']);

Route::get('admin/clients/add', ['middleware' => ['auth', 'roll'], 'uses' => 'client@add']);

Route::post('admin/clients/create', ['middleware' => ['auth', 'roll'], 'uses' => 'client@create']);

Route::get('admin/clients/edit/{id}', ['middleware' => ['auth', 'roll'], 'uses' => 'client@edit']);

Route::patch('admin/clients/update/{id}', ['middleware' => ['auth', 'roll'], 'uses' => 'client@update']);

Route::get('admin/search_clients', array('as' => 'searchajax', 'uses' => 'client@search'));

Route::get('admin/clients/remove/{id}', ['middleware' => ['auth', 'roll'], 'uses' => 'client@remove']);

Route::get('admin/clients/category/sort', ['middleware' => ['auth', 'roll'], 'uses' => 'client@categorysort']);

Route::get('admin/category/sort/getcategoryname', ['uses' => 'client@getcategoryname']);

Route::post('admin/clients/category/sort/store', ['middleware' => ['auth', 'roll'], 'uses' => 'client@categorysortstore']);

Route::post('admin/clients/category/sort/update', ['middleware' => ['auth', 'roll'], 'uses' => 'client@categorysortupdate']);

Route::get('admin/clients/category/sort/remove/{id}', ['middleware' => ['auth', 'roll'], 'uses' => 'client@categorysortremove']);

//project
Route::get('admin/projects', ['middleware' => ['auth', 'roll'], 'uses' => 'projects@index']);

Route::get('admin/projects/add', ['middleware' => ['auth', 'roll'], 'uses' => 'projects@add']);

Route::post('admin/projects/create', ['middleware' => ['auth', 'roll'], 'uses' => 'projects@create']);

Route::get('admin/projects/edit/{id}', ['middleware' => ['auth', 'roll'], 'uses' => 'projects@edit']);

Route::patch('admin/projects/update/{id}', ['middleware' => ['auth', 'roll'], 'uses' => 'projects@update']);

Route::get('admin/project_clients/remove/{id}', ['middleware' => ['auth', 'roll'], 'uses' => 'projects@clients_remove']);

Route::get('admin/search_projects', array('as' => 'searchajax', 'uses' => 'projects@search'));

Route::get('admin/projects/remove/{id}', ['middleware' => ['auth', 'roll'], 'uses' => 'projects@remove']);

//category
Route::get('admin/category', ['middleware' => ['auth', 'roll'], 'uses' => 'categories@index']);

Route::get('admin/category/add', ['middleware' => ['auth', 'roll'], 'uses' => 'categories@add']);

Route::post('admin/category/create', ['middleware' => ['auth', 'roll'], 'uses' => 'categories@create']);

Route::get('admin/category/edit/{id}', ['middleware' => ['auth', 'roll'], 'uses' => 'categories@edit']);

Route::patch('admin/category/update/{id}', ['middleware' => ['auth', 'roll'], 'uses' => 'categories@update']);

Route::get('admin/search_category', array('as' => 'searchajax', 'uses' => 'categories@search'));

Route::get('admin/category/viewclient/{id}', ['middleware' => ['auth', 'roll'], 'uses' => 'categories@viewclient']);

Route::get('admin/viewclientsearch', array('as' => 'searchajax', 'uses' => 'categories@viewclientsearch'));

Route::get('admin/category/remove/{id}', ['middleware' => ['auth', 'roll'], 'uses' => 'categories@remove']);

//users

Route::get('admin/users', ['middleware' => ['auth', 'roll'], 'uses' => 'users@index']);
Route::get('admin/users/add', ['middleware' => ['auth', 'roll'], 'uses' => 'users@add']);
Route::post('admin/users/create', ['middleware' => ['auth', 'roll'], 'uses' => 'users@create']);
Route::get('admin/users/edit/{id}', ['middleware' => ['auth', 'roll'], 'uses' => 'users@edit']);
Route::patch('admin/users/update/{id}', ['middleware' => ['auth', 'roll'], 'uses' => 'users@update']);
Route::get('admin/search_user', array('as' => 'searchajax', 'uses' => 'users@search'));
Route::post('admin/users/updateall', ['middleware' => ['auth', 'roll'], 'uses' => 'users@updateall']);
Route::get('admin/users/remove/{id}', ['middleware' => ['auth', 'roll'], 'uses' => 'users@remove']);
Route::post('admin/users/remove/{id}', ['middleware' => ['auth', 'roll'], 'uses' => 'users@remove']);
Route::get('admin/getprojects', ['uses' => 'users@getprojectname']);
Route::get('admin/getprojectnames', ['uses' => 'users@getprojectnames']);

//manufacturers
Route::get('admin/manufacturer', ['middleware' => ['auth', 'roll'], 'uses' => 'manufacturer@index']);
Route::get('admin/manufacturer/add', ['middleware' => ['auth', 'roll'], 'uses' => 'manufacturer@add']);
Route::post('admin/manufacturer/create', ['middleware' => ['auth', 'roll'], 'uses' => 'manufacturer@create']);
Route::get('admin/manufacturer/edit/{id}', ['middleware' => ['auth', 'roll'], 'uses' => 'manufacturer@edit']);
Route::post('admin/manufacturer/update/{id}', ['middleware' => ['auth', 'roll'], 'uses' => 'manufacturer@update']);
Route::get('admin/search_manufacturer', array('as' => 'searchajax', 'uses' => 'manufacturer@search'));
Route::get('admin/manufacturer/remove/{id}', ['middleware' => ['auth', 'roll'], 'uses' => 'manufacturer@remove']);

//devices
Route::get('admin/devices', ['middleware' => ['auth', 'roll'], 'uses' => 'devices@index']);
Route::get('admin/devices/add', ['middleware' => ['auth', 'roll'], 'uses' => 'devices@add']);
Route::post('admin/devices/create', ['middleware' => ['auth', 'roll'], 'uses' => 'devices@create']);
Route::get('admin/devices/view/{id}', ['middleware' => ['auth', 'roll'], 'uses' => 'devices@view']);

Route::get('admin/devices/edit/{id}', ['middleware' => ['auth', 'roll'], 'uses' => 'devices@edit']);
Route::patch('admin/devices/update/{id}', ['middleware' => ['auth', 'roll'], 'uses' => 'devices@update']);
Route::get('admin/search_device', array('as' => 'searchajax', 'uses' => 'devices@search'));
Route::get('admin/searchclientprice', array('as' => 'searchajax', 'uses' => 'devices@searchclientprice'));
Route::get('admin/devices/clientprice/{id}', ['middleware' => ['auth', 'roll'], 'uses' => 'devices@clientprice']);
Route::post('admin/devices/clientpricecreate', ['middleware' => ['auth', 'roll'], 'uses' => 'devices@clientpricecreate']);
Route::get('admin/devices/clientpriceedit/{id}', ['middleware' => ['auth', 'roll'], 'uses' => 'devices@clientpriceedit']);
Route::patch('admin/devices/clientpriceupdate/{id}', ['middleware' => ['auth', 'roll'], 'uses' => 'devices@clientpriceupdate']);
Route::get('admin/devices/remove/{id}', ['middleware' => ['auth', 'roll'], 'uses' => 'devices@remove']);
Route::get('admin/getcategory', ['middleware' => ['auth', 'roll'], 'uses' => 'devices@getcategory']);
Route::get('admin/devices/clientpriceremove/{id}', ['middleware' => ['auth', 'roll'], 'uses' => 'devices@priceremove']);
Route::get('admin/devices/customfield/remove/{id}', ['middleware' => ['auth', 'roll'], 'uses' => 'devices@customfieldremove']);
Route::get('admin/getrep', ['uses' => 'devices@getrepemail']);
Route::get('admin/getorderemail', ['uses' => 'devices@getorderemail']);
Route::get('admin/devices/devicefeatures/{id}', ['middleware' => ['auth', 'roll'], 'uses' => 'devices@devicefeatures']);
Route::post('admin/devices/devicefeatures/create', ['middleware' => ['auth', 'roll'], 'uses' => 'devices@devicefeaturesstore']);
Route::get('admin/devices/devicefeatures/edit/{id}', ['middleware' => ['auth', 'roll'], 'uses' => 'devices@devicefeaturesedit']);
Route::post('admin/devices/devicefeatures/update/{id}', ['middleware' => ['auth', 'roll'], 'uses' => 'devices@devicefeaturesupdate']);
Route::get('admin/devices/devicefeatures/remove/{id}', ['middleware' => ['auth', 'roll'], 'uses' => 'devices@devicefeaturesremove']);
Route::get('admin/searchdevicefeatures', ['uses' => 'devices@serarchdevicefeatures']);

/***/
/*Search Device Using Serial Number Start 06/11/2017 09:00 A.M*/
Route::get('admin/devices/serialnumberdevice', 'devices@serialdevice');
Route::get('admin/devices/deviceserialnumber', 'devices@deviceserial');

/*Search Device Using Serial Number End*/
/***/

//orders

Route::get('admin/orders', ['middleware' => ['auth', 'roll'], 'uses' => 'orders@index']);

Route::get('admin/orders/edit/{id}', ['middleware' => ['auth', 'roll'], 'uses' => 'orders@edit']);

Route::Patch('admin/orders/update/{id}', ['middleware' => ['auth', 'roll'], 'uses' => 'orders@update']);

Route::post('admin/orders/updateall', ['middleware' => ['auth', 'roll'], 'uses' => 'orders@updateall']);

Route::get('admin/search_order', array('as' => 'searchajax', 'uses' => 'orders@search'));

Route::get('admin/orders/remove/{id}', ['middleware' => ['auth', 'roll'], 'uses' => 'orders@remove']);

Route::post('admin/orders/archive', ['middleware' => ['auth', 'roll'], 'uses' => 'orders@archive']);

Route::get('admin/orders/viewarchive', ['middleware' => ['auth', 'roll'], 'uses' => 'orders@viewarchive']);

Route::get('admin/archive_search_order', array('as' => 'searcharchiveajax', 'uses' => 'orders@archiveordersearch'));

//schedule
Route::get('admin/schedule', ['middleware' => ['auth', 'roll'], 'uses' => 'schedules@index']);

Route::get('admin/schedule/add', ['middleware' => ['auth', 'roll'], 'uses' => 'schedules@add']);

Route::post('admin/schedule/create', ['middleware' => ['auth', 'roll'], 'uses' => 'schedules@create']);

Route::get('admin/schedule/edit/{id}', ['middleware' => ['auth', 'roll'], 'uses' => 'schedules@edit']);

Route::POST('admin/schedule/update/{id}', ['middleware' => ['auth', 'roll'], 'uses' => 'schedules@update']);

Route::get('admin/search_schedule', array('as' => 'searchajax', 'uses' => 'schedules@search'));

Route::post('admin/schedule/updateall', ['middleware' => ['auth', 'roll'], 'uses' => 'schedules@updateall']);

Route::get('admin/devicedetails', array('as' => 'searchajax', 'uses' => 'schedules@devicedetails'));

Route::get('admin/schedule/remove/{id}', ['middleware' => ['auth', 'roll'], 'uses' => 'schedules@remove']);

Route::get('admin/getclientname', ['middleware' => ['auth', 'roll'], 'uses' => 'schedules@getclientname']);

Route::get('admin/getdevicename', ['middleware' => ['auth', 'roll'], 'uses' => 'schedules@getdevicename']);
Route::get('admin/getphysician', ['uses' => 'schedules@getphysician']);
Route::get('admin/getmanufacturers', ['uses' => 'schedules@getmanufacturer']);

//marketshare
Route::get('admin/marketshare', ['middleware' => ['auth', 'roll'], 'uses' => 'marketshare@index']);

Route::get('admin/search_marketshare', ['middleware' => 'auth', 'uses' => 'marketshare@search']);

Route::get('admin/login', ['as' => 'auth.login', 'uses' => 'Auth\AuthController@showLoginForm']);
Route::post('admin/login', ['as' => 'auth.login', 'uses' => 'Auth\AuthController@postLogin']);
Route::get('admin/logout', ['as' => 'auth.logout', 'uses' => 'users@logoutadmin']);

//forgot password
Route::auth();

//frontend
Route::get('login', array('uses' => 'userlogin@showlogin'));
Route::post('login', array('uses' => 'userlogin@dologin'));

Route::group(['middleware' => ['frontendauth']], function () {
    Route::get('selectclient', 'userlogin@clients');
    Route::get('selectclient/getprojects', 'userlogin@getprojects');
    Route::post('logincontinue', 'userlogin@logincontinue');
    Route::get('menu', array('uses' => 'usermenu@index'));
    Route::get('changeout/mainmenu', array('uses' => 'usermenu@changeout_menu'));
    Route::get('newdevice/mainmenu', array('uses' => 'usermenu@newdevice_menu'));

    Route::get('newdevice/devices/{id}', array('uses' => 'products@newdevice'));

    Route::get('changeout/devices/{id}', array('uses' => 'products@changeout'));

    Route::get('compareproducts', array('uses' => 'products@compareproduct'));

    Route::post('purchase', array('uses' => 'products@purchase'));
    Route::get('purchase', array('uses' => 'products@purchase'));

    Route::get('agree', array('uses' => 'userlogin@agree'));

    Route::post('agreeconditions', array('uses' => 'userlogin@agreeconditions'));
    Route::get('logout', array('uses' => 'userlogin@logout'));

    /*Repcase Tracker Frontend Start*/
    Route::get('repcasetracker', 'rep\RepcaseController@index');
    Route::get('repcasetracker/clients', 'rep\RepcaseController@clients');
    Route::post('repcasetracker/clients/record', 'rep\RepcaseController@clientRecord');
    Route::post('repcasetracker/clients/record/list', 'rep\RepcaseController@clientRecordList');
    Route::get('repcasetracker/clients/record/list/{id}', 'rep\RepcaseController@clientRecordListdata');
    Route::get('repcasetracker/swapdevice/{id}', 'rep\RepcaseController@swapdevice');
    Route::get('repcasetracker/swapdevice/edit/{id}', 'rep\RepcaseController@swapdeviceEdit');
    Route::post('repcasetracker/swapdevice/update/{id}', 'rep\RepcaseController@swapdeviceNewUpdate');
    Route::get('repcasetracker/addcase', 'rep\RepcaseController@addcase');
    Route::POST('repcasetracker/createcase', 'rep\RepcaseController@createcase');
    Route::get('repcasetracker/swapdevice/new/edit/{id}', 'rep\RepcaseController@swapdeviceNewEdit');
//    Route::post('repcasetracker/swapdevice/new/update/{id}', 'rep\RepcaseController@swapdeviceNewUpdate');
    Route::post('repcasetracker/swapdevice/new/updates/{id}', 'rep\RepcaseController@swapdeviceNewUpdates');
    Route::get('repcasetracker/getserialnumber', 'rep\RepcaseController@getserialnumber');
    Route::get('repcasetracker/getserialnumbers', 'rep\RepcaseController@getserialnumbers');

    /*Repcase Tracker Frontend End*/

});

//export

Route::post('admin/devices/export', ['as' => 'admin.device_export.excel', 'uses' => 'devices@export']);
Route::post('admin/devices/import', ['as' => 'admin.device_export.excel', 'uses' => 'devices@import']);
Route::post('admin/orders/export', ['as' => 'admin.order_export.excel', 'uses' => 'orders@export']);
Route::post('admin/schedule/export', ['as' => 'admin.schedule_export.excel', 'uses' => 'schedules@export']);
Route::get('admin/marketshare/export', ['as' => 'admin.marketshare_export.excel', 'uses' => 'marketshare@export']);

// Device Survey Routes

Route::get('admin/devices/devicesurvey/{id}', 'devices@deviceSurvey');
Route::post('admin/devices/devicesurvey/create', 'devices@deviceSurveyStore');
Route::get('admin/devices/devicesurvey/edit/{id}/{deviceId}', 'devices@deviceSurveyEdit');
Route::PUT('admin/devices/devicesurvey/update/{id}/{deviceId}', 'devices@deviceSurveyUpdate');
Route::get('admin/devices/devicesurvey/remove/{id}/{deviceId}', 'devices@deviceSurveyRemove');
Route::get('admin/devices/devicesurvey/copysurvey/{id}/{deviceId}', 'devices@deviceSurveyCopy');
Route::post('admin/devices/devicesurvey/search', 'devices@deviceSurveySearch');
Route::get('admin/devices/devicesurvey/view/{id}/{deviceId}', 'devices@deviceSurveyView');
Route::get('admin/devices/devicesurvey/surveyanswer/{id}', 'devices@deviceSurveyAnswer');
Route::get('admin/devices/devicesurvey/answerRemove/{id}', 'devices@deviceSurveyAnswerRemove');
Route::post('admin/devices/devicesurveyanswer/search', 'devices@deviceSurveyAnswerSearch');

// Device Custom Contact information Routes

Route::get('admin/devices/customcontact/{id}', 'devices@customContact');
Route::post('admin/devices/customcontact/store', 'devices@contactStore');
Route::post('admin/devices/customcontact/getordermail', 'devices@getOrderMail');
Route::get('admin/devices/customcontact/edit/{id}', 'devices@customContactEdit');
Route::PUT('admin/devices/customcontact/update/{id}', 'devices@customContactUpdate');
Route::get('admin/devices/customcontact/remove/{id}', 'devices@customContactRemove');
Route::post('admin/devices/customcontact/search', 'devices@contactSearch');

/*Get Ordermail Contact Number*/
Route::post('admin/devices/customcontact/number', 'devices@contactNumber');
Route::post('admin/device/customecontact/email', 'ValidationController@getphone');

// device Rep infomation Routes

Route::post('admin/devices/repinfo/status', 'devices@repstatus');
Route::get('admin/devices/repinfo/edit/{id}/{deviceId}', 'devices@repStatusEdit');
Route::post('admin/devices/repinfo/update/{id}', 'devices@repStatusUpdate');
Route::post('admin/devices/reinfo/export', 'devices@repinfoexport');
Route::post('admin/devices/repcontact/search', 'devices@repcontactsearch');

// Physician ScoreCard Routes

Route::get('admin/users/scorecard/{id}', 'users@phyScoreCard');
Route::get('admin/users/scorecard/create/{id}', 'users@phyScoreCardCreate');
Route::post('admin/users/scorecard/store/{id}', 'users@phyScoreCardStore');
Route::get('admin/users/scorecard/view/{id}', 'Scorecard\ScorecardController@index');
Route::get('admin/users/scorecard/edit/{id}', 'users@phyScoreCardEdit');
Route::PUT('admin/users/scorecard/update/{id}', 'users@phyScoreCardUpdate');
Route::post('admin/users/scorecard/image/remove/{id}', 'users@phyScoreCardImageRemove');
Route::get('admin/users/scorecard/{sId}/image/remove/{id}', 'users@phyScoreCardSingleImageRemove');
Route::post('admin/users/scorecard/remove/{id}', 'users@phyScoreCardRemove');
Route::post('admin/users/scorecard/search', 'users@phySCoreCardSearch');

/*Item files*/
Route::get('admin/itemfiles', 'ItemFile@index');
Route::get('admin/itemfiles/add', 'ItemFile@add');
Route::get('admin/itemfiles/import/{id}', 'ItemFile@import');
Route::post('admin/itemfiles/create', 'ItemFile@create');
Route::get('admin/itemfiles/view/{id}', 'ItemFile@view');
Route::get('admin/itemfiles/edit/{id}', 'ItemFile@edit');
Route::post('admin/itemfiles/update/{id}', 'ItemFile@update');
Route::get('admin/itemfiles/remove/{id}', 'ItemFile@remove');
Route::POST('admin/itemfiles/removedata/{id}', 'ItemFile@removedata');
Route::get('admin/itemfiles/export/{id}', 'ItemFile@export');
Route::post('admin/itemfiles/search', 'ItemFile@search');
Route::get('admin/itemfiles/itemfile', 'ItemFile@sampledownload');
Route::POST('admin/itemfiles/project', 'ItemFile@projectchange');

/*Add Serial Number in view Device tab start*/
Route::get('admin/devices/serialnumber', 'SerialNumbers@index');
Route::get('admin/devices/serialnumber/create/{id}', 'SerialNumbers@create');
Route::POST('admin/devices/serialnumber/store/{id}', 'SerialNumbers@store');
Route::get('admin/devices/serialnumber/import/{id}', 'SerialNumbers@import');
Route::get('admin/devices/serialnumber/edit/{id}', 'SerialNumbers@edit');
Route::POST('admin/devices/serialnumber/update/{id}', 'SerialNumbers@update');
Route::get('admin/devices/serialnumber/view/{id}', 'SerialNumbers@view');
Route::get('admin/devices/serialnumber/export/{id}', 'SerialNumbers@export');
Route::get('admin/devices/serialnumber/remove/{id}', 'SerialNumbers@remove');
Route::POST('admin/devices/serialnumber/removedata/{id}', 'SerialNumbers@destroy');
Route::get('admin/devices/serialnumber/serial-number', 'SerialNumbers@sampledownload');
Route::get('admin/devices/serialnumber/serial-numbers', 'SerialNumbers@sampledownloads');
Route::POST('admin/devices/serialnumber/search', 'SerialNumbers@search');
Route::get('admin/devices/serialnumber/consignment/{id}', 'SerialNumbers@viewconsignment');
Route::get('admin/devices/serialnumber/editconsignment/{id}', 'SerialNumbers@editconsignment');
Route::POST('admin/devices/serialnumber/updateconsignment/{id}', 'SerialNumbers@updateconsignment');
Route::get('admin/devices/serialnumber/exportconsignment/{id}', 'SerialNumbers@exportconsignment');

/*New Changes in serial number*/
Route::POST('admin/devices/serialnumber/imports', 'SerialNumbers@imports');

/*Add Serial Number in view Device tab End*/

// Create Custom Schedule by order

Route::get('admin/schedule/create/{id}', 'schedules@order');
Route::get('ical', function () {
    return view('emails.icalender');
});

// Frontend Device Rep INfo routes

Route::post('repcontact/info', 'products@repContactInfo');

// Frontend  Device Survey Routes
Route::post('survey/question', 'products@surveyQuestion');
Route::post('survey/questionAnswer', 'products@surveyQuestionAnswer');

// Frontend Scorecard Routes
Route::get('scorecard', 'ScoreCardController@index');
Route::post('scorecard', 'ScoreCardController@index');

Route::get('scorecard/year/{id}', 'ScoreCardController@year');

Route::get('scorecard/physician', 'ScoreCardController@physician');
Route::post('scorecard/getmonth', 'ScoreCardController@getMonth');
Route::get('scorecard/scorecardimage/{id}', 'Scorecard\ScorecardController@frontscorecard');

/* scripts for data migration one table to another table */
//Route::get('migratedata', 'users@migratedata');
//Route::get('userprojectmigarte','users@userProjectmigarte');
//Route::get('phyprojectmigarte','users@physicianDataMigrate');
//Route::get('surveydata','products@surveyData');
//Route::get('surveyanswerdata','products@surveyAnswerData');
//Route::get('bulkdata','SerialNumbers@migratedata');

//Route::get('casemigration','RepcaseTrackerController@casemigration');
Route::get('securemail', 'ValidationController@securemail');


/*set session for client name in administrator view*/
Route::post('admin/administrator/client', 'users@setadminstratorclient');
Route::get('admin/administrator/clients/{id}', 'users@setadminstratorclients');
Route::get('admin/administrator/project/{id}', 'users@setadminstratorprojects');
Route::get('admin/outlook', 'schedules@outlookmail');

/*Update data in order table add device id*/
Route::get('update/deviceid', 'orders@updateid');

/*Tracking Module Routes Start*/
Route::get('admin/tracking', 'TrackingController@index');
Route::get('admin/tracking/users', 'TrackingController@userAnalytics');
Route::post('admin/tracking/users', 'TrackingController@userAnalytics');
Route::post('admin/tracking/users/search', 'TrackingController@userAnalyticsSearch');
Route::post('admin/tracking/users/export', 'TrackingController@userAnalyticsExport');
Route::get('admin/tracking/users/view/{id}', 'TrackingController@userAnalyticsView');
Route::post('admin/tracking/users/view/search', 'TrackingController@userAnalyticsViewSearch');
Route::post('admin/tracking/users/view/export', 'TrackingController@userAnalyticsViewExport');

Route::get('admin/tracking/organization', 'TrackingController@organizationAnalytics');
Route::post('admin/tracking/organization', 'TrackingController@organizationAnalytics');
Route::get('admin/tracking/organization/search', 'TrackingController@organizationAnalyticsSearch');
Route::post('admin/tracking/organization/export', 'TrackingController@organizationAnalyticsExport');
Route::get('admin/tracking/organization/view/{id}', 'TrackingController@organizationAnalyticsView');
Route::post('admin/tracking/organization/view/search', 'TrackingController@organizationAnalyticsViewSearch');
Route::post('admin/tracking/organization/view/export', 'TrackingController@organizationAnalyticsViewExport');

Route::get('admin/tracking/survey', 'TrackingController@surveyAnalytics');
Route::post('admin/tracking/survey', 'TrackingController@surveyAnalytics');
Route::post('admin/tracking/survey/search', 'TrackingController@surveyAnalyticsSearch');
Route::post('admin/tracking/survey/popular', 'TrackingController@surveyAnalyticsPopular');
Route::post('admin/tracking/survey/export', 'TrackingController@surveyAnalyticsExport');
Route::get('admin/tracking/survey/view/{id}', 'TrackingController@surveyAnalyticsView');
Route::post('admin/tracking/survey/view/search', 'TrackingController@surveyAnalyticsViewSearch');
Route::post('admin/tracking/survey/view/export', 'TrackingController@surveryviewexport');

Route::get('admin/tracking/orders', 'TrackingController@orderAnalytics');
Route::post('admin/tracking/orders', 'TrackingController@orderAnalytics');
Route::post('admin/tracking/orders/search', 'TrackingController@orderAnalyticsSearch');
Route::post('admin/tracking/orders/export', 'TrackingController@orderAnalyticsExport');

Route::get('admin/orders/sampledownload', 'devices@sampledownload');
/*Tracking Module Routes End*/

/*Repcase tracker module start*/
Route::get('admin/repcasetracker', 'RepcaseTrackerController@index');
Route::POST('admin/repcasetracker', 'RepcaseTrackerController@index');
Route::get('admin/repcasetracker/add', 'RepcaseTrackerController@create');
Route::post('admin/repcasetracker/store', 'RepcaseTrackerController@store');
Route::get('admin/repcasetracker/getphysician', 'RepcaseTrackerController@getphysician');
Route::get('admin/repcasetracker/getcategory', 'RepcaseTrackerController@getcategory');
Route::get('admin/repcasetracker/getcompany', 'RepcaseTrackerController@getcompany');
Route::get('admin/repcasetracker/getsupplyitem', 'RepcaseTrackerController@getsupplyitem');
Route::get('admin/repcasetracker/getitemfile', 'RepcaseTrackerController@getitemfile');
Route::get('admin/repcasetracker/getdevicedata', 'RepcaseTrackerController@getdevicedata');
Route::get('admin/repcasetracker/getdevicedatas', 'RepcaseTrackerController@getdevicedatas');
Route::get('admin/repcasetracker/edit/{id}', 'RepcaseTrackerController@edit');
Route::post('admin/repcasetracker/update/{id}', 'RepcaseTrackerController@update');
Route::get('admin/repcasetracker/remove/{id}', 'RepcaseTrackerController@remove');
Route::post('admin/repcasetracker/export', 'RepcaseTrackerController@export');
Route::POST('admin/repcasetracker/search', 'RepcaseTrackerController@search');
Route::get('admin/repcasetracker/getproject', 'RepcaseTrackerController@getproject');
Route::get('admin/repcasetracker/getprojects', 'RepcaseTrackerController@getprojects');
/* Admin Swap Device Routes Start*/
Route::get('admin/repcasetracker/swapdevice/{id}', 'RepcaseTrackerController@swapdevice');
Route::get('admin/repcasetracker/swapdevice/serialnumber/{id}', 'RepcaseTrackerController@swapserialnumber');
Route::get('admin/repcasetracker/swapdevice/newdevice/{id}', 'RepcaseTrackerController@swapnewdevice');
Route::POST('admin/repcasetracker/swapdevice/update/{id}', 'RepcaseTrackerController@swapupdate');
Route::POST('admin/repcasetracker/swapdevice/updates/{id}', 'RepcaseTrackerController@swapupdates');
Route::get('admin/repcasetracker/getsupplyitems', 'RepcaseTrackerController@getsupplyitems');
Route::get('admin/repcasetracker/getcompanies', 'RepcaseTrackerController@getcompanies');
Route::get('admin/repcasetracker/getrepuser', 'RepcaseTrackerController@getrepuser');
Route::get('admin/repcasetracker/getserialnumber', 'RepcaseTrackerController@getserialnumber');
Route::get('admin/repcasetracker/getserialnumbers', 'RepcaseTrackerController@getserialnumbers');
Route::get('admin/repcasetracker/serialnumbers', 'RepcaseTrackerController@serialnumbers');
Route::get('admin/repcasetracker/getserial', 'RepcaseTrackerController@getserial');
Route::get('admin/repcasetracker/checkserial', 'RepcaseTrackerController@checkserial');
Route::get('admin/repcasetracker/getdiscount', 'RepcaseTrackerController@getdiscount');

/* Admin Swap Device Routes End*/
/**
 * Add New Device Request Route
 */

Route::get('admin/repcasetracker/addnewdevice', 'RepcaseTrackerController@addnewdevice');
Route::get('admin/repcasetracker/getcategoryName', 'RepcaseTrackerController@getcategoryName');
Route::POST('admin/repcasetracker/storenewdevice', 'RepcaseTrackerController@storeRequest');


/**
 * Device Features Image
 */
Route::get('admin/devices/features/image','Device\DeviceFeatureController@add');
Route::POST('admin/devices/features/image/store','Device\DeviceFeatureController@store');

/*Repcase tracker module end*/

/* Admin Highest Or Lowest Price Device Based On Category Route */
Route::get('admin/highest-lowest-device/{category}', 'dashboard\DashboardController@HigestLowestDevice');

// Route::get('admin/discount-highest-lowest-device','dashboard\DashboardController@DiscountDevice');

/* End Admin Highest Or Lowest Price Device Based On Category Route */
/**
 * Dashboard Routes
 */
Route::POST('admin/dashboard/getphysician', ['middleware' => ['auth', 'roll'],'uses' => function () {

    dd('hello');
}]);

Route::get('admin/dashboard',['middleware' => ['auth', 'roll'], 'uses' =>'dashboard\DashboardController@index']);
Route::POST('admin/dashboard',['middleware' => ['auth', 'roll'], 'uses' =>'dashboard\DashboardController@index']);
Route::get('admin/dashboard/app',['middleware' => ['auth', 'roll'], 'uses' => 'dashboard\DashboardController@app']);
Route::get('admin/dashboard/unitapp/{id}',['middleware' => ['auth', 'roll'], 'uses' =>'dashboard\DashboardController@unitapp']);
Route::POST('admin/dashboard/unitapp/{id}',['middleware' => ['auth', 'roll'], 'uses' =>'dashboard\DashboardController@unitapp']);




/**
 * Get Email ID In Repcasetracker Route
 */
Route::get('admin/repcasetracker/getphyemail', 'RepcaseTrackerController@getphyemail');
Route::get('admin/dashboard/viewsaving', 'dashboard\DashboardController@viewsaving');
Route::POST('admin/dashboard/viewsaving', 'dashboard\DashboardController@viewsaving');
Route::get('admin/dashboard/viewbulk', 'dashboard\DashboardController@viewbulk');
Route::get('admin/dashboard/view-market-share', 'dashboard\DashboardController@viewmarketshare');
Route::POST('admin/dashboard/view-market-share', 'dashboard\DashboardController@viewmarketshare');

Route::get('admin/dashboard/saving/viewmore', 'dashboard\DashboardController@savingviewmore');
Route::POST('admin/dashboard/saving/viewmore', 'dashboard\DashboardController@savingviewmore');
Route::get('admin/dashboard/saving', 'dashboard\DashboardController@savings');
Route::POST('admin/dashboard/saving', 'dashboard\DashboardController@savings');
Route::get('admin/dashboard/market-share/viewmore', 'dashboard\DashboardController@marketshareviewmore');
Route::POST('admin/dashboard/market-share/viewmore', 'dashboard\DashboardController@marketshareviewmore');
/**
 * Neptune Routes
 */
Route::get('admin/dashboard/neptune', 'dashboard\DashboardController@neptune');
Route::POST('admin/dashboard/neptune', 'dashboard\DashboardController@neptune');

/**
 * Auto ScoreCard Generation
 */
Route::get('admin/scorecard','Scorecard\ScorecardController@index');
Route::POST('admin/users/scorecard/view/{id}', 'Scorecard\ScorecardController@index');


/**
 * Old Year APP import Functionality Start
 * 20/02/2018 2.30 P.M.
 */
Route::POST('admin/app/import', 'ImportAPP\ImportAPPController@import');
Route::get('admin/app/view', 'ImportAPP\ImportAPPController@view');
Route::POST('admin/app/remove', 'ImportAPP\ImportAPPController@remove');
Route::get('admin/app/import_app_value', 'ImportAPP\ImportAPPController@sampledownloadss');


//get dashboard data using ajax
Route::get('getcategoryappchart','dashboard\DashboardController@getcategoryappajax');
Route::get('getsavingvalue','dashboard\DashboardController@getsavingvalueajax');
Route::get('getsavingviewvalue','dashboard\DashboardController@getsavingviewvalueajax');
Route::get('getsavingviewvalue_client','dashboard\DashboardController@getsavingviewvalueajax_client');
Route::get('getsaving_chart_value_client','dashboard\DashboardController@getsaving_chart_value_client');

/**
 * migrate data serial number date
 */

Route::get('migratedate','SerialNumbers@migratedate');


/**
 * Category Group Route Start
 */
Route::get('admin/category-group', 'CategoryGroup\CategoryGroupController@index');
Route::get('admin/category-group/create', 'CategoryGroup\CategoryGroupController@create');
Route::POST('admin/category-group/store', 'CategoryGroup\CategoryGroupController@store');
Route::POST('admin/category-group/delete', 'CategoryGroup\CategoryGroupController@delete');
Route::get('admin/getcategories', 'CategoryGroup\CategoryGroupController@getcategories');

/**
 * Category Group Route End
 */