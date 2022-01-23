<?php

use App\Http\Controllers\BillingController;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\SubscriptionsController;
use App\Http\Controllers\UserInformationsController;
use App\Http\Controllers\ReportsController;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('/home', function() {
//     return view('home');
// })->name('home')->middleware('auth');

Route::get('/', function () {
    return view('welcome');
});


// Http://localhost/user
Route::prefix('user')->group(function () {

    // User Informations
    // Http://localhost/user/information

});

Route::middleware('role:admin')->prefix('a')->group(function () {

    Route::get('customers', [UserInformationsController::class, 'index'])->name('customers.index');
    Route::get('customers/{id}', [UserInformationsController::class, 'adminShow'])->name('customers.show');

    Route::prefix('plans')->group(function () {
        Route::get('/', [PlansController::class, 'index'])->name('plans.index');
        Route::get('/{id}', [PlansController::class, 'show'])->name('plans.show');
        Route::post('/', [PlansController::class, 'store'])->name('plans.store');
        Route::put('/{id}', [PlansController::class, 'update'])->name('plans.update');
        Route::delete('/{id}', [PlansController::class, 'destroy'])->name('plans.destroy');
    });

    Route::prefix('billings')->group(function () {

        Route::get('/', [BillingController::class, 'index'])->name('billings.index');

    });

    Route::prefix('reports')->group(function () {

        Route::get('/customers', [ReportsController::class, 'customers'])->name('reports.customers');
        Route::get('/billings', [ReportsController::class, 'billings'])->name('reports.billings');

    });

});

Route::middleware('role:user')->prefix('u')->group(function () {

    Route::prefix('profile')->group(function () {

        // Route::get('/', [UserInformationsController::class, 'index'])->name('user.info.index');
        Route::get('/', [UserInformationsController::class, 'show'])->name('user.info.show');
        Route::post('/', [UserInformationsController::class, 'store'])->name('user.info.store');
        Route::put('/update', [UserInformationsController::class, 'update'])->name('user.info.update');
        Route::delete('/destroy', [UserInformationsController::class, 'destroy'])->name('user.info.destroy');

    });

    Route::prefix('plans')->group(function () {
        Route::get('/', [PlansController::class, 'index'])->name('user.plans');
        Route::get('/{id}', [PlansController::class, 'show'])->name('user.plans.show');
        Route::post('/{id}/subscribe', [PlansController::class, 'subscribe'])->name('user.plans.subscribe');
        Route::post('/{id}/unsubscribe', [PlansController::class, 'stopSubscribe'])->name('user.plans.unsubsribe');
    });

    Route::prefix('subscriptions')->group(function () {
        Route::get('/', [SubscriptionsController::class, 'index'])->name('subscriptions.index');
        Route::get('/{id}', [SubscriptionsController::class, 'index'])->name('subscriptions.show');
        Route::post('/', [SubscriptionsController::class, 'index'])->name('subscriptions.store');
        Route::put('/{id}', [SubscriptionsController::class, 'index'])->name('subscriptions.update');
        Route::delete('/{id}', [SubscriptionsController::class, 'index'])->name('subscriptions.destroy');

        Route::get('/{id}/billings', [BillingController::class, 'create'])->name('billings.create');
        Route::get('/{id}/billings/pay', [BillingController::class, 'payBills'])->name('billings.process');
        Route::post('/{id}/billings/pay', [BillingController::class, 'process'])->name('billings.pay');
    });

    Route::prefix('history')->group(function () {
        Route::get('/', [BillingController::class, 'history'])->name('history.index');
    });

});




