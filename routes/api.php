<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//public
Route::post("login", [UserController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(
    function () {
        Route::delete("logout", [UserController::class, 'logout']);

    }
);
  Route::get('user', [App\Http\Controllers\UserController::class, 'user']);
//customer
Route::get('/wms/customer/customer-list', [App\Http\Controllers\Wms\CustomerController::class, 'index']);
Route::post('/wms/customer/customer-store', [App\Http\Controllers\Wms\CustomerController::class, 'store']);
Route::put('/wms/customer/customer-update/{id}', [App\Http\Controllers\Wms\CustomerController::class, 'update']);
Route::delete('/wms/customer/customer-destroy/{id}', [App\Http\Controllers\Wms\CustomerController::class, 'destroy']);
//supplier
Route::get('/wms/supplier/supplier-list', [App\Http\Controllers\Wms\SupplierController::class, 'index']);
Route::get('/wms/supplier/supplier-search', [App\Http\Controllers\Wms\SupplierController::class, 'showActive']);
Route::post('/wms/supplier/supplier-store', [App\Http\Controllers\Wms\SupplierController::class, 'store']);
Route::put('/wms/supplier/supplier-update/{id}', [App\Http\Controllers\Wms\SupplierController::class, 'update']);
Route::delete('/wms/supplier/supplier-destroy/{id}', [App\Http\Controllers\Wms\SupplierController::class, 'destroy']);
//trucker master
Route::get('/wms/trucker/trucker-master-list', [App\Http\Controllers\Wms\TruckerMasterConstroller::class, 'index']);
Route::post('/wms/trucker/trucker-master-store', [App\Http\Controllers\Wms\TruckerMasterConstroller::class, 'store']);
Route::put('/wms/trucker/trucker-master-update/{id}', [App\Http\Controllers\Wms\TruckerMasterConstroller::class, 'update']);
Route::delete('/wms/trucker/trucker-master-destroy/{id}', [App\Http\Controllers\Wms\TruckerMasterConstroller::class, 'destroy']);

// unit of measures
Route::get('/wms/unit-measure/uom-list', [App\Http\Controllers\Wms\UnitofMesasuresConstroller::class, 'index']);
Route::get('/wms/unit-measure/uom-select', [App\Http\Controllers\Wms\UnitofMesasuresConstroller::class, 'dropMOU']);
Route::post('/wms/unit-measure/uom-store', [App\Http\Controllers\Wms\UnitofMesasuresConstroller::class, 'store']);
Route::put('/wms/unit-measure/uom-update/{id}', [App\Http\Controllers\Wms\UnitofMesasuresConstroller::class, 'update']);
Route::delete('/wms/unit-measure/uom-destroy/{id}', [App\Http\Controllers\Wms\UnitofMesasuresConstroller::class, 'destroy']);

// warehouse
Route::get('/wms/warehouse/warehouse-list', [App\Http\Controllers\Wms\WarehouseController::class, 'index']);
Route::get('/wms/warehouse/warehouse-list-active', [App\Http\Controllers\Wms\WarehouseController::class, 'SelecWarehouseIsactive']);
Route::post('/wms/warehouse/warehouse-store', [App\Http\Controllers\Wms\WarehouseController::class, 'store']);
Route::put('/wms/warehouse/warehouse-update/{id}', [App\Http\Controllers\Wms\WarehouseController::class, 'update']);
Route::delete('/wms/warehouse/warehouse-destroy/{id}', [App\Http\Controllers\Wms\WarehouseController::class, 'destroy']);

// area
Route::get('/wms/area/area-list', [App\Http\Controllers\Wms\AreaController::class, 'index']);
Route::get('/wms/area/area-list-active', [App\Http\Controllers\Wms\AreaController::class, 'SelectAreaIsactive']);
Route::post('/wms/area/area-store', [App\Http\Controllers\Wms\AreaController::class, 'store']);
Route::put('/wms/area/area-update/{id}', [App\Http\Controllers\Wms\AreaController::class, 'update']);
Route::delete('/wms/area/area--destroy/{id}', [App\Http\Controllers\Wms\AreaController::class, 'destroy']);

// storage location
Route::get('/wms/location/storage-location-list', [App\Http\Controllers\Wms\StorageLocationController::class, 'index']);
Route::get('/wms/location/storage-location-id/{id}', [App\Http\Controllers\Wms\StorageLocationController::class, 'show']);
Route::post('/wms/location/storage-location-store', [App\Http\Controllers\Wms\StorageLocationController::class, 'store']);
Route::put('/wms/location/storage-location-update/{id}', [App\Http\Controllers\Wms\StorageLocationController::class, 'update']);
Route::delete('/wms/location/storage-location-destroy/{id}', [App\Http\Controllers\Wms\StorageLocationController::class, 'destroy']);

Route::get('/wms/dropdown/dropdown-list/{column_key}', [App\Http\Controllers\Wms\DropDownController::class, 'index']);

// Trucker type
Route::get('/wms/trucker/trucker-list', [App\Http\Controllers\Wms\TruckerTypeController::class, 'index']);
Route::post('/wms/trucker/trucker-store', [App\Http\Controllers\Wms\TruckerTypeController::class, 'store']);
Route::put('/wms/trucker/trucker-update/{id}', [App\Http\Controllers\Wms\TruckerTypeController::class, 'update']);
Route::delete('/wms/trucker/trucker-destroy/{id}', [App\Http\Controllers\Wms\TruckerTypeController::class, 'destroy']);

// item master
Route::get('/wms/itemmaster/item-master-list', [App\Http\Controllers\Wms\ItemMasterController::class, 'index']);
Route::get('/wms/itemmaster/item-master-id/{id}', [App\Http\Controllers\Wms\ItemMasterController::class, 'show']);
Route::post('/wms/itemmaster/item-master-store', [App\Http\Controllers\Wms\ItemMasterController::class, 'store']);
Route::put('/wms/itemmaster/item-master-update/{id}', [App\Http\Controllers\Wms\ItemMasterController::class, 'update']);
Route::delete('/wms/itemmaster/item-master-destroy/{id}', [App\Http\Controllers\Wms\ItemMasterController::class, 'destroy']);

// Warehouse User
Route::get('/wms/warehouse/warehouse-user-list', [App\Http\Controllers\Wms\warehouseUserController::class, 'index']);
Route::get('/wms/warehouse/warehouse-user-showid/{id}', [App\Http\Controllers\Wms\warehouseUserController::class, 'show']);
Route::post('/wms/warehouse/warehouse-user-store', [App\Http\Controllers\Wms\warehouseUserController::class, 'store']);
Route::put('/wms/warehouse/warehouse-user-update/{id}', [App\Http\Controllers\Wms\warehouseUserController::class, 'update']);
Route::delete('/wms/warehouse/warehouse-user-destroy/{id}', [App\Http\Controllers\Wms\warehouseUserController::class, 'destroy']);
