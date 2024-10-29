<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

use Laravel\Fortify\Http\Controllers\ConfirmablePasswordController;
use Laravel\Fortify\Http\Controllers\ConfirmedPasswordStatusController;
use Laravel\Fortify\Http\Controllers\ConfirmedTwoFactorAuthenticationController;
use Laravel\Fortify\Http\Controllers\EmailVerificationNotificationController;
use Laravel\Fortify\Http\Controllers\EmailVerificationPromptController;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Laravel\Fortify\Http\Controllers\PasswordController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;
use Laravel\Fortify\Http\Controllers\ProfileInformationController;
use Laravel\Fortify\Http\Controllers\RecoveryCodeController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController;
use Laravel\Fortify\Http\Controllers\TwoFactorQrCodeController;
use Laravel\Fortify\Http\Controllers\TwoFactorSecretKeyController;
use Laravel\Fortify\Http\Controllers\VerifyEmailController;
use Laravel\Fortify\RoutePath;
use App\Http\Controllers\PermissionController;
use Livewire\Volt\Volt;
 

Route::resource('permissions', PermissionController::class);


Route::get('/', function () {
    return view('welcome');
});







Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Volt::route('/dashboard', 'dashboard')->name('dashboard');
    // Batch_Information
    Volt::route('/dashboard/poultry/info', 'batch_information')->name('batch-information');
    // Production_Metrics
    Volt::route('/dashboard/poultry/metrics', 'production_metrics')->name('production-metrics');
    // Building_Management
    Volt::route('/dashboard/poultry/building', 'building_management')->name('building-management');
    // Flock_Management
    Volt::route('/dashboard/poultry/flock', 'flock_management')->name('flock-management');
    // Inventory_Management
    Volt::route('/dashboard/poultry/inventory', 'inventory_management')->name('inventory-management');
    // Logistic
    Volt::route('/dashboard/poultry/logistic', 'logistic')->name('logistics');
    // Report
    Volt::route('/dashboard/poultry/report', 'report')->name('report');
});
