<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AmountCollectionController;
use App\Http\Controllers\WalletController;

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

    Route::get('/', [UserController::class,'registerPage'])->name('register.page');
    Route::post('/register', [UserController::class, 'register'])->name('register');
    Route::post('/login', [UserController::class, 'login'])->name('login');
//     Route::get('clear',function(){
//         sudo php artisan cache:clear

// sudo php artisan view:clear

// sudo php artisan config:cache
//     })

    Route::middleware(['auth.custom'])->group(function () {
        Route::group(['prefix'=>'super-admin'], function(){
            Route::get('deposit-amount', [UserController::class,'depositAmountGet'])->name('deposit.amount.get');
            Route::post('deposit-amount', [UserController::class,'depositAmountPost'])->name('deposit.amount.post');
            Route::get('user-lists', [UserController::class,'userLists'])->name('user.lists');
            Route::get('edit-profile/{uid}', [UserController::class,'editProfile'])->name('edit.profile');
            Route::get('user-status/{type}/{uid}', [UserController::class,'userStatus'])->name('user.status');
            Route::post('change-password', [UserController::class,'changePasswordByadmin'])->name('user.change.password');

        });

        Route::group(['prefix'=>'user'], function(){
            Route::get('profile', [UserController::class,'userProfile'])->name('user.profile');
            Route::post('update-profile', [UserController::class,'updateProfile'])->name('user.profile.update');
            Route::post('user-profile-password-update', [UserController::class,'userProfilePasswordUpdate'])->name('user.profile.password.update');
        });

        Route::group(['prefix'=>'amount'], function(){
            Route::get('collection-create', [AmountCollectionController::class,'create'])->name('collection.create');
            Route::post('collection-store', [AmountCollectionController::class,'store'])->name('collection.store');
            Route::get('admin-dashboard', [AmountCollectionController::class,'index'])->name('admin.dashboard');
            Route::get('/user-dashboard', [AmountCollectionController::class,'userDashboard'])->name('user.dashboard');
            Route::get('/get-users', [AmountCollectionController::class,'getUsers'])->name('get.users');
            Route::get('/deposited-amount/{status?}', [AmountCollectionController::class, 'depositedAmount'])->name('deposited-amount');
            Route::get('/update-deposited-amount/{dep_id}/{status}', [AmountCollectionController::class, 'updateDepositedAmount'])->name('update-deposited-amount');

            Route::get('nested-user', [AmountCollectionController::class,'nestedUser'])->name('user.nested.user');

            Route::get('deposit-datatable', [AmountCollectionController::class,'depositDatatable'])->name('deposit.datatable');
            Route::get('payment-filter', [AmountCollectionController::class,'totalPaymentFilter'])->name('total.payment.filter');
            Route::post('payment-filter', [AmountCollectionController::class,'paymentFilter'])->name('user.payment.filter');
        });
        Route::group(['prefix'=>'wallet'], function(){
            Route::get('/', [WalletController::class,'userWallet'])->name('user.wallet');
            Route::post('wthdrawal', [WalletController::class,'walletWthdrawal'])->name('wallet.wthdrawal');
            Route::get('add', [WalletController::class,'addWalletAmount'])->name('add.wallet.amount');
            Route::post('add-amount-store', [WalletController::class,'addWalletAmountStore'])->name('add.wallet.amount.store');
            Route::get('purchase-amount', [WalletController::class,'purchaseAmountList'])->name('purchase.amount.list');
            Route::get('purchase-amount-datatable', [WalletController::class,'purchaseAmountDatatable'])->name('purchase.amount.datatable');
            Route::get('update-purchase-amount/{id}/{status}', [WalletController::class,'updatepurchaseAmount'])->name('update.purchase.amount');
            
        });

        Route::get('new-user', function(){
                return view('error_pages.pending_user');
            })->name('new.user');
        Route::get('/logout', [UserController::class,'logout'])->name('logout');
    });

    

    
