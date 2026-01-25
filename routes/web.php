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
        // product setting routes
        Route::get('/', [ProductController::class, 'index'])->name('product.list');
        Route::get('/create', [ProductController::class, 'createView'])->name('product.create.view');
        Route::get('/get-SubCategory/{id}', [ProductController::class, 'getSubcategory'])->name('get.subcategory');
        Route::post('/create', [ProductController::class, 'create'])->name('product.create');
        Route::get('/edit/{id}/{sku}/{slug}', [ProductController::class, 'edit'])->name('product.edit');
        Route::put('/modify/{id}', [ProductController::class, 'modify'])->name('product.modify');
        Route::delete('/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
        
    });

    // category routes
        Route::prefix('category')->group(function () {
            Route::get('/', [ProductController::class, 'categoryIndex'])->name('category.list');
            Route::post('/create', [ProductController::class, 'categoryCreate'])->name('category.create');
            Route::get('/edit/{id}', [ProductController::class, 'categoryEdit'])->name('category.edit');
            Route::put('/modify/{id}', [ProductController::class, 'categoryModify'])->name('category.modify');
            Route::delete('/delete/{id}', [ProductController::class, 'categoryDelete'])->name('category.delete');
        });
        // sub-category routes
        Route::prefix('subcategory')->group(function () {
            Route::get('/', [ProductController::class, 'subcategoryIndex'])->name('subcategory.list');
            Route::post('/create', [ProductController::class, 'subcategoryCreate'])->name('subcategory.create');
            Route::get('/edit/{id}', [ProductController::class, 'subcategoryEdit'])->name('subcategory.edit');
            Route::put('/modify/{id}', [ProductController::class, 'subcategoryModify'])->name('subcategory.modify');
            Route::delete('/delete/{id}', [ProductController::class, 'subcategoryDelete'])->name('subcategory.delete');
        });

});