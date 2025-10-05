<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DnController;
use App\Http\Controllers\DsController;
use App\Http\Controllers\CocController;
use App\Http\Controllers\AamsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustController;
use App\Http\Controllers\PepoController;
use App\Http\Controllers\PpmsController;
use App\Http\Controllers\PposController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RisksController;
use App\Http\Controllers\PtasksController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PstatusController;
use App\Http\Controllers\VendorsController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MilestonesController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;








  Route::get('/', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth']], function() {




        Route::resource('dashboard', controller: DashboardController::class);
          /*Project*/
          Route::resource('project', controller: ProjectsController::class)->names([
              'index' => 'projects.index',
              'create' => 'projects.create',
              'store' => 'projects.store',
              'show' => 'projects.show',
              'edit' => 'projects.edit',
              'update' => 'projects.update',
              'destroy' => 'projects.destroy',
          ]);
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
Route::delete('ppos/destroy', [PposController::class, 'destroy']);

        // /*Project Status  */
                Route::resource('pstatus', PstatusController::class);
                Route::delete('pstatus/destroy', [PstatusController::class, 'destroy']);
        // /*Project Tasks */
                Route::resource('ptasks', PtasksController::class);
                Route::delete('ptasks/destroy', [PtasksController::class, 'destroy']);
        // /*Project EPO */
                 Route::resource('epo', PepoController::class);

        // /*Risks  */
                Route::resource('risks', RisksController::class);
                Route::delete('risks/destroy', [RisksController::class, 'destroy']);

        // /*Milestones  */
                Route::resource('milestones', MilestonesController::class);



    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('reports', ReportController::class);
    Route::get('reports/export/csv', [ReportController::class, 'export'])->name('reports.export');
    Route::post('reports/cache/clear', [ReportController::class, 'clearCache'])->name('reports.cache.clear');


    }

);

// Auth::routes();
// Auth::routes(['register'=>false]);

require __DIR__ . '/auth.php';

// Route لعرض الصور من مجلد storge
Route::get('storge/{path}', function ($path) {
    $filePath = base_path('storge/' . $path);
    if (!file_exists($filePath)) {
        abort(404);
    }

    $mimeType = mime_content_type($filePath);
    return response()->file($filePath, [
        'Content-Type' => $mimeType,
    ]);
})->where('path', '.*');

Route::get('/{page}',[AdminController::class,'index']);
