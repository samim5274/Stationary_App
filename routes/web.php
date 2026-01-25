<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Product\ProductController;



Route::get('/clear', function(){
    Artisan::call('optimize:clear');
    return redirect()->back()->with('success','Caches cleared successfully.');
})->name('clear.cache');






Route::prefix('auth')->group(function () {        
    Route::get('/login', [UserController::class, 'login'])->name('login');
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    Route::post('/login', [UserController::class, 'loginPost'])->name('user.login');
});



Route::group(['middleware' => ['admin']], function(){

    Route::get('/', function () {
        $company = App\Models\Company::first();
        return view('welcome', compact('company'));
    });

    Route::prefix('auth')->group(function () {
        Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    });

    Route::prefix('product')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('product.list');
        Route::get('/create', [ProductController::class, 'createView'])->name('product.create.view');
        Route::get('/get-SubCategory/{id}', [ProductController::class, 'getSubcategory'])->name('get.subcategory');
        Route::post('/create', [ProductController::class, 'create'])->name('product.create');
        Route::get('/edit/{id}/{sku}/{slug}', [ProductController::class, 'edit'])->name('product.edit');
        Route::put('/modify/{id}', [ProductController::class, 'modify'])->name('product.modify');
        Route::delete('/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
    });

});