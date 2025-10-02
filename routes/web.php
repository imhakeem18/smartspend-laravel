
<?php

use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    
    Route::resource('incomes', IncomeController::class);
});

Route::resource('expenses', ExpenseController::class);

Route::resource('categories', CategoryController::class);


Route::get('/dashboard', [DashboardController::class, 'index'])
       ->middleware(['auth', 'verified'])
       ->name('dashboard');

Route::get('/run-migrations', function () {
    Artisan::call('migrate', ['--force' => true]);
    return 'Migrations run successfully!';
})->middleware('auth');