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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::middleware('auth')
    ->group(function () {
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::get('/core/menu', [App\Http\Controllers\Core\MenuController::class, 'index']);

        Route::get('/core/role', [App\Http\Controllers\Core\RoleController::class, 'index']);
        Route::get('/core/permission', [App\Http\Controllers\Core\PermissionController::class, 'index']);
        Route::get('/core/dashboard', [App\Http\Controllers\Core\DashboardController::class, 'index']);
        Route::get('/core/user', [App\Http\Controllers\Core\UserController::class, 'index']);

        Route::get('/core/application', [App\Http\Controllers\Core\ApplicationController::class, 'index']);
        Route::post('/core/application', [App\Http\Controllers\Core\ApplicationController::class, 'store']);

        // application
        Route::get('/core/application/app-list', [App\Http\Controllers\Core\ApplicationController::class, 'applist']);
        Route::post('/core/application/store', [App\Http\Controllers\Core\ApplicationController::class, 'store']);
        Route::put('/core/application/update/{id}', [App\Http\Controllers\Core\ApplicationController::class, 'update']);
        Route::delete('/core/application/delete/{id}', [App\Http\Controllers\Core\ApplicationController::class, 'destroy']);

        //menu

        Route::get('/core/menu/menu-list', [App\Http\Controllers\Core\MenuController::class, 'menulist']);
        Route::post('/core/menu/store', [App\Http\Controllers\Core\MenuController::class, 'store']);
        Route::put('/core/menu/update/{id}', [App\Http\Controllers\Core\MenuController::class, 'update']);
        Route::delete('/core/menu/delete/{id}', [App\Http\Controllers\Core\MenuController::class, 'destroy']);

        //permisson

        Route::get('/core/permission/permission-list', [App\Http\Controllers\Core\PermissionController::class, 'permissionlist']);
        Route::get('/core/permission/menu-list', [App\Http\Controllers\Core\PermissionController::class, 'menulist']);
        Route::post('/core/permission/store', [App\Http\Controllers\Core\PermissionController::class, 'store']);
        Route::put('/core/permission/update/{id}', [App\Http\Controllers\Core\PermissionController::class, 'update']);
        Route::delete('/core/permission/delete/{id}', [App\Http\Controllers\Core\PermissionController::class, 'destroy']);
        //role
        Route::get('/core/role/role-list', [App\Http\Controllers\Core\RoleController::class, 'rolelist']);
        Route::post('/core/role/store', [App\Http\Controllers\Core\RoleController::class, 'store']);
        Route::put('/core/role/update/{id}', [App\Http\Controllers\Core\RoleController::class, 'update']);
        Route::delete('/core/role/delete/{id}', [App\Http\Controllers\Core\RoleController::class, 'destroy']);
        //user
        Route::get('/core/user/user-list', [App\Http\Controllers\Core\UserController::class, 'userlist']);
        Route::get('/core/user/role', [App\Http\Controllers\Core\UserController::class, 'rolelist']);
        Route::post('/core/user/register', [App\Http\Controllers\Core\UserController::class, 'create']);
        Route::put('/core/user/update/{id}', [App\Http\Controllers\Core\UserController::class, 'update']);
        Route::delete('/core/user/delete/{id}', [App\Http\Controllers\Core\UserController::class, 'destroy']);

        //helpdesk
        Route::get('/core/helpdesk', [App\Http\Controllers\Core\HelpdeskController::class, 'index']);
        Route::post('/core/helpdesk/store-section', [App\Http\Controllers\Core\HelpdeskController::class, 'storeSection']);
        Route::get('/core/helpdesk/app-name', [App\Http\Controllers\Core\HelpdeskController::class, 'systemName']);
        Route::get('/core/helpdesk/helpsection-list/{id}', [App\Http\Controllers\Core\HelpdeskController::class, 'sectionlist']);
        Route::post('/core/helpdesk/store-page', [App\Http\Controllers\Core\HelpdeskController::class, 'storeSectionPage']);
        Route::get('/core/helpdesk/help-page-section/{id}', [App\Http\Controllers\Core\HelpdeskController::class, 'sectionPageList']);
        Route::put('/core/helpdesk/update-sectionpage/{id}', [App\Http\Controllers\Core\HelpdeskController::class, 'updateSectionPage']);
        Route::delete('/core/helpdesk/remove-section/{id}', [App\Http\Controllers\Core\HelpdeskController::class, 'deleteSection']);
        //get helpPage by ID
        Route::get('/core/helpdesk/help-pagebyid/{id}', [App\Http\Controllers\Core\HelpdeskController::class, 'getPagebyID']);
        Route::put('core/helpdesk/update-page/{id}', [App\http\Controllers\Core\HelpdeskController::class, 'updateSectionPage']);
        Route::delete('/core/helpdesk/delete-page/{id}', [App\Http\Controllers\Core\HelpdeskController::class, 'deleteSectionPage']);
    });


Route::get('auth/google', [\App\Http\Controllers\Auth\GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [\App\Http\Controllers\Auth\GoogleController::class, 'handleGoogleCallback']);
