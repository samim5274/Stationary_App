<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Report\Sale\SaleReportController;
use App\Http\Controllers\Expenses\ExpensesController;
use App\Http\Controllers\Income\IncomeController;
use App\Http\Controllers\Bank\BankController;



Route::get('/clear', function(){
    Artisan::call('optimize:clear');
    return redirect()->back()->with('success','Caches cleared successfully.');
})->name('clear.cache');






Route::prefix('auth')->group(function () {        
    Route::get('/login', [UserController::class, 'login'])->name('login');
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    Route::post('/login', [UserController::class, 'loginPost'])->name('user.login')->middleware('throttle:5,1');;
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

    Route::prefix('sale')->group(function () {
        Route::get('/cart', [CartController::class, 'cart'])->name('sale.cart');
        Route::get('/add-cart', [CartController::class, 'addCart'])->name('add.cart');
        Route::post('/cart/set-qty', [CartController::class, 'updateQty'])->name('cart.updateQty');
        Route::get('/remove-to-cart/{product_id}/{reg}', [CartController::class, 'removeToCart'])->name('cart.remove');

        Route::post('/cart/checkout', [OrderController::class, 'checkout'])->name('order.confirm');
        Route::get('/order/invoice/{reg}', [OrderController::class, 'invoicePrint'])->name('order-print');
    });

    Route::prefix('sale/report')->group(function () {
        Route::get('/daily', [SaleReportController::class, 'daily'])->name('sale.report.daily');
        Route::get('/order-detials/{reg}', [SaleReportController::class, 'orderDetails'])->name('order.details.view');
        Route::get('/print-daily-report', [SaleReportController::class, 'printDailyReport'])->name('print-daily-sale');
        Route::get('/date-wise-sale-report', [SaleReportController::class, 'dateWiseSaleReport'])->name('date.wise.sale.report');
        Route::get('/filter-date-wise-sale-report', [SaleReportController::class, 'filteDateWiseSaleReport'])->name('filter-date-wise-sale-report');
        Route::get('/payment-method-wise-sale-report', [SaleReportController::class, 'paymentMethodWiseSaleReport'])->name('payment.method.wise.sale.report');
        Route::get('/filter-payment-method-wise-sale-report', [SaleReportController::class, 'filterPaymentMethodWiseSaleReport'])->name('filter-payment-method-wise-sale-report');
        Route::get('/user-wise-sale-report', [SaleReportController::class, 'userSaleReport'])->name('user.wise.sale.report');
        Route::get('/filter-user-wise-sale-report', [SaleReportController::class, 'filterUserSaleReport'])->name('filter-user-wise-sale-report');
    });

    Route::prefix('expenses')->group(function () {
        Route::get('/', [ExpensesController::class, 'index'])->name('expenses');
        Route::get('/get-subcategories/{id}', [ExpensesController::class, 'getSubCategory'])->name('expenses.subcategories');
        Route::post('/create', [ExpensesController::class, 'create'])->name('create.expenses');
        Route::get('/view-detials/{id}', [ExpensesController::class, 'viewDetials'])->name('expenses-view-details');
        Route::delete('/delete/{id}', [ExpensesController::class, 'delete'])->name('expenses-delete');
        Route::get('/print/{id}', [ExpensesController::class, 'printExpenses'])->name('expenses.print');

        Route::get('/setting', [ExpensesController::class, 'setting'])->name('expenses.setting');
        Route::get('/create-category', [ExpensesController::class, 'createView'])->name('create-category-view');
        Route::post('/category-create', [ExpensesController::class, 'createCategory'])->name('excategories.store');
        Route::get('/category-update/{id}', [ExpensesController::class, 'updateCategory'])->name('excategories.update.view');
        Route::put('/modify-category/{id}', [ExpensesController::class, 'modifyCategory'])->name('excategories.update');
        Route::delete('/delete-category/{id}', [ExpensesController::class, 'deleteCategory'])->name('expenses.category.delete');

        Route::get('/create-sub-category', [ExpensesController::class, 'createSubView'])->name('create-sub-category-view');
        Route::post('/sub-category-store', [ExpensesController::class, 'storeSubCategory'])->name('exsubcategories.store');
        Route::get('/update-sub-category/{id}', [ExpensesController::class, 'updateSubCategory'])->name('exsubcategories.update');
        Route::put('/modify-sub-category/{id}', [ExpensesController::class, 'modifySubCategory'])->name('exsubcategories.modify');
        Route::delete('/delete-sub-category/{id}', [ExpensesController::class, 'deleteSubCategory'])->name('exsubcategories.delete');
    });

    Route::prefix('incomes')->group(function () {
        Route::get('/', [IncomeController::class, 'index'])->name('incomes');
        Route::get('/get-incomes/{id}', [IncomeController::class, 'getSubCategory'])->name('incomes.subcategories');
        Route::post('/create', [IncomeController::class, 'create'])->name('create-incomes');
        Route::get('/view-details/{id}', [IncomeController::class, 'viewDetails'])->name('income.view.details');
        Route::delete('/delete/{id}', [IncomeController::class, 'delete'])->name('income-delete');
        Route::get('/print/{id}', [IncomeController::class, 'printIncome'])->name('income.print');

        Route::get('/setting', [IncomeController::class, 'setting'])->name('income.setting');
        Route::get('/create-category', [IncomeController::class, 'createView'])->name('income-create-category-view');
        Route::post('/category-create', [IncomeController::class, 'createCategory'])->name('income-excategories.store');
        Route::get('/category-update/{id}', [IncomeController::class, 'updateCategory'])->name('income-excategories.update.view');
        Route::put('/modify-category/{id}', [IncomeController::class, 'modifyCategory'])->name('income.categories.update');
        Route::delete('/delete-category/{id}', [IncomeController::class, 'deleteCategory'])->name('income-expenses.category.delete');
        
        Route::get('/create-sub-category', [IncomeController::class, 'createSubView'])->name('income-create-sub-category-view');
        Route::post('/sub-category-store', [IncomeController::class, 'storeSubCategory'])->name('income-subcategories.store');
        
        Route::get('/update-sub-category/{id}', [IncomeController::class, 'updateSubCategory'])->name('income-subcategories.update');
        Route::put('/modify-sub-category/{id}', [IncomeController::class, 'modifySubCategory'])->name('income-subcategories.modify');
        Route::delete('/delete-sub-category/{id}', [IncomeController::class, 'deleteSubCategory'])->name('income-exsubcategories.delete');
    });

    Route::prefix('bank')->group(function() {
        Route::get('/', [BankController::class, 'index'])->name('bank.transection');
        Route::get('/diposit', [BankController::class, 'bankDipositView'])->name('bank.diposit.view');
        Route::post('/diposit', [BankController::class, 'bankDiposit'])->name('bank.diposit');
        Route::delete('/diposit-delete/{id}', [BankController::class, 'dipositDelete'])->name('delete.diposit');
        Route::get('/transection-view/{id}', [BankController::class, 'viewDipsoti'])->name('bank.transection.view');
        
        Route::get('/withdraw', [BankController::class, 'bankWithdrawView'])->name('bank.withdraw.view');

        Route::get('/-to-bank', [BankController::class, 'bankToBankView'])->name('bank.to.bank.view');
        Route::post('/-to-bank', [BankController::class, 'bankToBank'])->name('bank.to.bank.transection');
    });

});