<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DnController;
use App\Http\Controllers\DsController;
use App\Http\Controllers\AamsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustController;
use App\Http\Controllers\PpmsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CocController;
use App\Http\Controllers\VendorsController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MilestonesController;
use App\Http\Controllers\PepoController;
use App\Http\Controllers\PposController;
use App\Http\Controllers\PstatusController;
use App\Http\Controllers\PtasksController;
use App\Http\Controllers\RisksController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;





  //Translation
// Route::group(
//     [
//         'prefix' => LaravelLocalization::setLocale(),
        // 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth', 'verified']
//         'middleware' => [  'auth', 'verified']
//     ],
//     function () {




  Route::get('/', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth']], function() {




        Route::resource('dashboard', controller: DashboardController::class);
          /*Project*/
          Route::resource('project', controller: ProjectsController::class);
        // Route::resource('/project/{id}', 'ProjectsController@getprojects');
        /*Customer*/
        Route::resource('customer', CustController::class);
           /*AM*/
        Route::resource('am', AamsController::class);
             /*PM*/
        Route::resource('pm', PpmsController::class);
           /*Vendors */
          Route::resource('vendors', VendorsController::class);
                 /*d/s */
        Route::resource('ds', DsController::class);
        // invoice
         Route::resource('invoices', InvoicesController::class);
        // /*DN  */
             Route::resource('dn', DnController::class);
        //         /*CoC */
                 Route::resource('coc', CocController::class);
        // /*Project POs Form */
                Route::resource('ppos', PposController::class);
        // /*Project Status  */
                Route::resource('pstatus', PstatusController::class);
        // /*Project Tasks */
                Route::resource('ptasks', PtasksController::class);
        // /*Project EPO */
                 Route::resource('epo', PepoController::class);

        // /*Risks  */
                Route::resource('risks', RisksController::class);

        // /*Milestones  */
                Route::resource('milestones', MilestonesController::class);

                

    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);


    }

);

Auth::routes();
// Auth::routes(['register'=>false]);

require __DIR__ . '/auth.php';


Route::get('/{page}',[AdminController::class,'index']);
