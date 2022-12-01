<?php

header('Access-Control-Allow-Origin: *');
//
//header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
//header('Access-Control-Allow-Headers: Content-Type, X-Auth-Token, Origin, Authorization');

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Materials\MaterialController;
use App\Http\Controllers\Api\V1\Materials\MyMaterialController;
use App\Http\Controllers\Api\V1\Profile\UserController;
use App\Http\Controllers\Api\V1\Profile\PerevodHistoryController;
use App\Http\Controllers\Api\V1\Turnir\TurnirController;
use App\Http\Controllers\Api\V1\Turnir\TurnirUserController;
use App\Http\Controllers\Api\V1\Turnir\TurnirZhetekshiController;
use App\Http\Controllers\Api\V1\Turnir\TurnirTestController;
use App\Http\Controllers\Api\V1\Olimpiada\OlimpiadaController;
use App\Http\Controllers\Api\V1\Olimpiada\OlimpiadaUserController;
use App\Http\Controllers\Api\V1\Olimpiada\OlimpiadaTestController;
use App\Http\Controllers\Api\V1\Olimpiada\OlimpiadaZhetekshiController;
use App\Http\Controllers\Api\V1\Qmg\QmgController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\AuthController;


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

Route::group(['prefix' => 'word', 'name'=>'materials'],function () {
    Route::get('/', [MaterialController::class, 'materials']);
    Route::get('/{slug}-{id}.html', [MaterialController::class, 'show'])->name('.show');
    Route::get('/{id}/download', [MaterialController::class, 'download'])->name('.download');
    Route::get('/{id}/materials', [MaterialController::class, 'user_materials'])->name('.user_materials');
    Route::post('/{id}/purchase', [MaterialController::class, 'purchase'])->name('.purchase')->middleware('jwt.auth');
    Route::get('/{id}/certificate', [MaterialController::class, 'getCertificate'])->name('.certificate');
    Route::post('/file/destroy', [MaterialController::class, 'destroyFile'])->name('.destroyFile');
    Route::get('/popular', [MaterialController::class, 'popular'])->name('.popular');
    Route::get('/getCategories', [MaterialController::class, 'getMaterialCategories'])->name('.getCategories');
    Route::post('/zharialau', [MaterialController::class, 'store'])->name('.store')->middleware(['jwt.auth', 'api']);
    Route::get('/qmg/bolimder', [QmgController::class, 'index']);
    Route::get('/qmg/{slug}-{id}.html', [QmgController::class, 'show'])->middleware(['jwt.auth', 'api']);
    Route::post('/qmg/buy', [QmgController::class, 'buy'])->middleware(['jwt.auth', 'api']);
    Route::get('/qmg/my_qmg', [QmgController::class, 'my_qmg'])->middleware(['jwt.auth', 'api']);
});

Route::group(['middleware' => 'api'],function (){
    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::group(['prefix' => 'menin-materialdarym'],function () {
            Route::get('/', [MyMaterialController::class, 'myMaterials'])->name('myMaterials');
            Route::post('/{id}/delete', [MyMaterialController::class, 'delete'])->name('delete');
            Route::post('/{id}/update', [MyMaterialController::class, 'update'])->name('update');
            Route::get('/{slug}-{id}.html', [MyMaterialController::class, 'show'])->name('show');
        });
        Route::group(['prefix' => 'profile'],function () {
            Route::post('/change', [UserController::class, 'change']);
            Route::post('/change/photo', [UserController::class, 'changePhoto']);
            Route::get('/change/photo/destroy', [UserController::class, 'destroyPhoto']);
            Route::get('/perevod/history', [PerevodHistoryController::class, 'index']);
            Route::get('/bonus/store', [PerevodHistoryController::class, 'store']);
        });
        Route::group(['prefix' => 'auth'], function () {
            Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword']);
        });
        Route::group(['prefix' => 'word'], function () {
            Route::get('/{id}/buyAlgys', [MaterialController::class, 'buyAlgys'])->name('.buyAlgys');
            Route::get('/{id}/getKurmet', [MaterialController::class, 'getKurmet'])->name('.getKurmet');
            Route::get('/{id}/buyKurmet', [MaterialController::class, 'buyKurmet'])->name('.buyKurmet');
            Route::get('/{id}/getAlgys', [MaterialController::class, 'getAlgys'])->name('.getAlgys');
        });

    });

    Route::group(['prefix' => 'auth'], function () {
        Route::post('/register', [RegisterController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/login/check-phone', [AuthController::class, 'checkPhone']);
        Route::get('/user', [AuthController::class, 'user']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/reset-password/send-sms', [ResetPasswordController::class, 'sendSmsResetPassword']);
    });

});

Route::group(['prefix' => 'turnirs', 'name'=>'turnirs'],function () {
    Route::get('/', [TurnirController::class, 'index']);
    Route::group(['middleware' => ['api', 'jwt.auth']],function (){
        Route::get('/{slug}-{id}', [TurnirController::class, 'show']);
        Route::get('/{slug}-{id}/test', [TurnirTestController::class, 'index']);
        Route::post('/test/store', [TurnirTestController::class, 'store']);
        Route::post('/user/store', [TurnirUserController::class, 'store']);
        Route::get('/user/{id}/delete', [TurnirUserController::class, 'destroy']);
        Route::post('/user/{id}/update', [TurnirUserController::class, 'update']);
        Route::post('/zhetekshi/store', [TurnirZhetekshiController::class, 'store']);
        Route::post('/zhetekshi/{id}/update', [TurnirZhetekshiController::class, 'update']);
        Route::get('/my_turnirs/active', [TurnirController::class, 'my_turnirs']);
        Route::get('/my_turnirs/muragat', [TurnirController::class, 'muragat']);
        Route::get('/{id}/certificate', [TurnirController::class, 'getCertificate'])->where(['id' => '[0-9]+'])->name('.getCertificate')->middleware('auth');
        Route::get('/{id}/thankLetter', [TurnirController::class, 'thankLetter'])->where(['id' => '[0-9]+'])->name('.thankLetter')->middleware('auth');
        Route::get('/{id}/purchase', [TurnirController::class, 'oplataCertificate'])->name('oplataCertificate');
    });
});

Route::group(['prefix' => 'olimpiada', 'name'=>'olimpiada'],function () {
    Route::get('/tury', [OlimpiadaController::class, 'index']);
    Route::group(['middleware' => ['api', 'jwt.auth']],function (){
        Route::get('/{slug}-{id}', [OlimpiadaController::class, 'qatysushylar']);
        Route::post('/user/create', [OlimpiadaUserController::class, 'create']);
        Route::post('/user/update', [OlimpiadaUserController::class, 'update']);
        Route::get('/user/{id}/destroy', [OlimpiadaUserController::class, 'destroy']);
        Route::post('/test/tolem-zhasau', [OlimpiadaController::class, 'tolem_zhasau']);
        Route::get('/test/load', [OlimpiadaTestController::class, 'test_load']);
        Route::post('/test/start', [OlimpiadaTestController::class, 'test_start']);
        Route::post('/test/save/answer', [OlimpiadaTestController::class, 'save_answer']);
        Route::post('/test/finish', [OlimpiadaTestController::class, 'test_finish']);
        Route::get('/{id}/certificate', [OlimpiadaController::class, 'getCertificate']);
        Route::get('/{id}/thankLetter', [OlimpiadaController::class, 'thankLetter']);
        Route::get('/test/katemen-zhumys', [OlimpiadaTestController::class, 'katemen_zhumys']);
        Route::get('/olimpiadalarym/active', [OlimpiadaController::class, 'my_olimps']);
        Route::get('/olimpiadalarym/muragat', [OlimpiadaController::class, 'muragat']);
        Route::post('/zhetekshi/create', [OlimpiadaZhetekshiController::class, 'create']);
        Route::post('/zhetekshi/{id}/update', [OlimpiadaZhetekshiController::class, 'update']);
        Route::post('/appeals/create', [OlimpiadaTestController::class, 'appeals_create']);
    });
});
