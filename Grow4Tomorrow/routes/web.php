<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\BenefitController;
use App\Http\Controllers\ShopController;
use App\Models\shop;

Route::get('/', function () {
    return view('auth.login');
});

#Login dan register
Route::get('auth', [AuthController::class, 'showAuthForm'])->name('auth')->middleware('guest');

Route::get('login', [AuthController::class, 'showAuthForm'])->name('auth');
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('register', [AuthController::class, 'register'])->name('register');

Route::post('/logout', function () {
    Auth::logout(); // Logout user
    return redirect('/auth')->with('success', 'You have been logged out.');
})->name('logout');

#Route Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::resource('education', EducationController::class)->middleware('auth');
Route::get('/education', [EducationController::class, 'index'])->name('education.index');
Route::get('education/{id}', [EducationController::class, 'show'])->name('education.show');
Route::get('/education/{id}/export-pdf', [EducationController::class, 'exportPdf'])->name('education.export-pdf');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::resource('forums', ForumController::class);
Route::post('forums/{forum}/comments', [ForumController::class, 'storeComment'])->name('forums.comments.store');
Route::get('/forums/{id}/export-pdf', [ForumController::class, 'exportToPDF'])->name('forums.export-pdf');

Route::get('auth', [AuthController::class, 'showAuthForm'])->name('auth')->middleware('guest');
Route::get('login', [AuthController::class, 'showAuthForm'])->name('auth');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', function () {
    Auth::logout(); 
    return redirect('/auth')->with('success', 'You have been logged out.');
})->name('logout');
Route::resource('benefit', BenefitController::class);

#Route Shop
Route::prefix('shop')->name('shop.')->group(function () {
    Route::get('/', [ShopController::class, 'index'])->name('index');
    Route::get('/create', [ShopController::class, 'getCreateForm'])->name('getCreateForm'); 
    Route::post('/store', [ShopController::class, 'store'])->name('store');
    Route::get('/{id}', [ShopController::class, 'show'])->name('show'); 
    Route::get('/{id}/edit', [ShopController::class, 'getEditForm'])->name('getEditForm'); 
    Route::put('/{id}', [ShopController::class, 'update'])->name('update'); 
    Route::delete('/{id}', [ShopController::class, 'destroy'])->name('destroy'); 

});


