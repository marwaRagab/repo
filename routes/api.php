<?php

use App\Http\Controllers\open_fileController;
use App\Http\Controllers\Transfer\TransferController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BankController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\BokerController;
use App\Http\Controllers\CourtController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\MinistryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\GovernorateController;
use App\Http\Controllers\NationalityController;
use App\Http\Controllers\PoliceStationController;
use App\Http\Controllers\InstallmentCarController;
use App\Http\Controllers\InstallmentNoteController;
use App\Http\Controllers\InstallmentIssueController;
use App\Http\Controllers\InstallmentClientController;
use App\Http\Controllers\CommuncationMethodController;
use App\Http\Controllers\MinistryPercentageController;
use App\Http\Controllers\InstallmentPercentageController;
use App\Http\Controllers\ImportingCompanies\ProductController;
use App\Http\Controllers\TransactionsCompletedController;
use App\Http\Controllers\ImportingCompanies\Tawreed\TawreedController;
use App\Http\Controllers\Showroom\ShowroomController;
use App\Http\Controllers\DeliveryController;




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



Route::post('/login', [LoginController::class, 'login']); // Login and get a token
Route::post('/reset-password', [LoginController::class, 'reset_password']); // Reset password
Route::post('/register', [LoginController::class, 'register']);
// Route::apiResource( 'regions', RegionController::class);

// Route::middleware('auth:sanctum')->get('/user', action: function (Request $request) {
//     dd("dd");
//     return $request->user();
// });

// New API resource group with middleware
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('nationalities', NationalityController::class);
    Route::apiResource('permissions', PermissionController::class);
    Route::post('/check-code', [LoginController::class, 'checkCode']); // Check code
    Route::post('/resend-code', [LoginController::class, 'resendCode']); // Resend code
    Route::post('/logout', [LoginController::class, 'logout']); // Logout
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('governorates', GovernorateController::class);
    Route::apiResource('courts', CourtController::class);
    Route::apiResource('banks', BankController::class);
    Route::apiResource('branches', BranchController::class);
    Route::apiResource('installmentPercentage', InstallmentPercentageController::class);
    Route::apiResource('ministryPercentage', MinistryPercentageController::class);
    Route::apiResource('policeSatations', PoliceStationController::class);
    Route::apiResource('regions', RegionController::class);
    Route::apiResource('ministries', MinistryController::class);
    Route::apiResource('brokers', BokerController::class);
    Route::apiResource('communcation_methods', CommuncationMethodController::class);
    Route::get('/users', [LoginController::class, 'getall']);
    Route::get('/users/show/{id}', [LoginController::class, 'show']);
    Route::get('/users/edit/{id}', [LoginController::class, 'edit']);
    Route::put('/users/{id}', [LoginController::class, 'update']);
    Route::delete('/users/{id}', [LoginController::class, 'destroy']);

    Route::apiResource('transactions_completed', TransactionsCompletedController::class);
    Route::apiResource('InstallmentClients', InstallmentClientController::class);
    Route::apiResource('InstallmentCar', InstallmentCarController::class);
    Route::apiResource('InstallmentIssue', InstallmentIssueController::class);
    Route::apiResource('InstallmentNote', InstallmentNoteController::class);

    Route::get('/IC/check_client', [InstallmentClientController::class, 'check_client']);
    Route::get('/IC/addForm', [InstallmentClientController::class, 'create']);
    // get_status
    Route::get('/IC/get_status', [InstallmentClientController::class, 'get_status']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::get('/open_file', [open_fileController::class, 'index']);
    Route::get('/open_file', [open_fileController::class, 'open_file']);
    Route::get('/tawreed', [TawreedController::class, 'index']);
    Route::post('tawreed/search-form/{companyId}', [TawreedController::class, 'searchForm']);
    Route::post('/tawreed/cart', [TawreedController::class, 'createCart']);
    Route::get('tawreed/purchase-orders', [TawreedController::class, 'purchaseOrders']);
    Route::post('/tawreed/sending/{id}', [TawreedController::class, 'sending']);
    Route::get('products_delivery', [ShowroomController::class, 'index']);
    Route::post('update_purchase', [ShowroomController::class, 'updateOrder']);



    Route::get('/transfer/available_products', [TransferController::class, 'getAvailableProducts']);
    Route::get('/transfer/show_available_products/{classId}', [TransferController::class, 'showAvailableProducts']);
});
