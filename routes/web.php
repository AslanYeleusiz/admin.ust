<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\Material\MaterialController;
use App\Http\Controllers\Admin\Material\DeletedMaterialController;
use App\Http\Controllers\Admin\Material\MaterialSubjectController;
use App\Http\Controllers\Admin\Material\MaterialClassController;
use App\Http\Controllers\Admin\Material\MaterialDirectionController;
use App\Http\Controllers\Admin\Material\MaterialZhinakController;
use App\Http\Controllers\Admin\Qmg\QmgSubjectsController;
use App\Http\Controllers\Admin\Qmg\QmgBolimController;
use App\Http\Controllers\Admin\Turnir\TurnirController;
use App\Http\Controllers\Admin\Turnir\TurnirAllQuestionsController;
use App\Http\Controllers\Admin\Turnir\TurnirQuestionsController;
use App\Http\Controllers\Admin\Turnir\TurnirUserController;
use App\Http\Controllers\Admin\Olimpiada\OlimpiadaBagytController;
use App\Http\Controllers\Admin\Olimpiada\OlimpiadaTizimController;
use App\Http\Controllers\Admin\Olimpiada\Suraktar\OlimpiadaSurakController;
use App\Http\Controllers\Admin\Olimpiada\Option\OlimpiadaOptionController;

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
Route::group(['middleware' => ['adminAuth']], function () {
    Route::name('admin.')->group(function () {
        Route::get('/', function () {return Inertia::render('home');})->name('index');
        Route::resource('users', UserController::class)->except(['show'])->names('users');
        Route::resource('materials', MaterialController::class)->except(['show'])->names('materials');
        Route::resource('deleted-materials', DeletedMaterialController::class)->except(['show'])->names('deletedMaterials');
        Route::resource('materials/subjects', MaterialSubjectController::class)->except(['show'])->names('materialSubjects');
        Route::resource('materials/directions', MaterialDirectionController::class)->except(['show'])->names('materialDirections');
        Route::resource('materials/classes', MaterialClassController::class)->except(['show'])->names('materialClasses');
        Route::resource('materials/zhinak', MaterialZhinakController::class)->except(['show', 'create', 'store'])->names('materialZhinak');
        Route::resource('qmg/subject', QmgSubjectsController::class)->except(['show'])->names('qmgSubjects');
        Route::resource('qmg/bolim', QmgBolimController::class)->except(['show'])->names('qmgBolim');
        Route::resource('turnirs', TurnirController::class)->except(['show'])->names('turnir');
        Route::resource('turnirs/{turnir}/questions', TurnirQuestionsController::class)->except(['show'])->names('turnirQuestions');
        Route::resource('turnir-all-question', TurnirAllQuestionsController::class)->except(['show','create','store'])->names('turnirAllQuestions');
        Route::resource('turnir-users', TurnirUserController::class)->except(['show','create','store'])->names('turnirUser');
        Route::resource('olimpiada-bagyty', OlimpiadaBagytController::class)->except(['show'])->names('olimpiadaBagyty');

        Route::resource('olimpiada-bagyty/{bagyt}/options', OlimpiadaOptionController::class)->except(['show'])->names('olimpiadaOption');

        Route::resource('olimpiada-bagyty/{bagyt}/option/{option}/suraktar', OlimpiadaSurakController::class)->except(['show'])->names('olimpiadaSuraktar');
        Route::resource('olimpiada-tizim', OlimpiadaTizimController::class)->except(['show','create','store'])->names('olimpiadaTizim');

        Route::get('logout', [AdminAuthController::class, 'logout'])->name('logout');
    });

    Route::get('material/{id}/download', [MaterialController::class, 'download'])->name('materials.download');

});


Route::get('/home', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.login')->name('adminLoginShow');
    Route::post('/login', [AdminAuthController::class, 'adminLoginForm'])->name('adminLoginForm');
});



