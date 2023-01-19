<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminContactUsController;
use App\Http\Controllers\Admin\AdminFaqController;
use App\Http\Controllers\Admin\AdminGigController;
use App\Http\Controllers\Admin\AdminPaymentontroller;
use App\Http\Controllers\Admin\AdminManagePaymentsController;
use App\Http\Controllers\Admin\AdminInvoiceController;
use App\Http\Controllers\Admin\AdminPageController;
// use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\FaqController;
//use App\Http\Controllers\OrderController;
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

// Admin Dashboard
Route::get('admin/login',[AdminAuthController::class, 'getLogin'])->name('adminLogin');
Route::post('admin/login', [AdminAuthController::class, 'postLogin'])->name('adminLoginPost');
Route::post('admin/logout', [AdminAuthController::class, 'logout'])->name('adminlogOut');
Route::group(['prefix' => 'admin', 'middleware' => 'adminauth'], function () {
    Route::get('dashboard',[AdminHomeController::class, 'index'])->name('dashboard');
    Route::get('profile',[AdminHomeController::class, 'profile'])->name('admin.profile');
    Route::post('update-profile',[AdminHomeController::class, 'updateProfile'])->name('admin.updateProfile');
    Route:: prefix('user')->group(function(){
    	Route::get('/create-form',[AdminUserController::class, 'create'])->name('user.create');
    	Route::get('/',[AdminUserController::class, 'index'])->name('user.index'); 
    	Route::post('/',[AdminUserController::class, 'store'])->name('user.store');
    	Route::get('/{id}/show',[AdminUserController::class, 'show'])->name('user.show'); 
    	Route::get('/{id}/edit',[AdminUserController::class, 'edit'])->name('user.edit'); 
    	Route::post('/{id}/update',[AdminUserController::class, 'update'])->name('user.update'); 
    	Route::post('/status',[AdminUserController::class, 'status'])->name('user.status'); 
    	Route::post('/destroy',[AdminUserController::class, 'destroy'])->name('user.destroy'); 
    });

    Route::resource('category', Admin\AdminCategoryController::class);

    Route::group(['prefix'=>'order'], function(){
    	Route::get('/',[AdminOrderController::class, 'index'])->name('order.index');     	
    	Route::get('/{id}/detail',[AdminOrderController::class, 'show'])->name('order.show');    	
    	Route::post('/update-status',[AdminOrderController::class, 'status'])->name('orderStatus');    	
    });
    
    Route::group(['prefix'=>'contact-us'], function(){
	    Route::get('/',[AdminContactUsController::class, 'index'])->name('contactUs.index');
	    Route::get('/show',[AdminContactUsController::class, 'show'])->name('contactUs.desc');
	    Route::post('/',[AdminContactUsController::class, 'destroy'])->name('contactUs.destroy');
    });

    Route::group(['prefix'=>'faq'], function(){
	    Route::get('/', [AdminFaqController::class, 'index'])->name('faq.index');
	    Route::get('/create', [AdminFaqController::class, 'create'])->name('faq.create');
	    Route::post('/', [AdminFaqController::class, 'store'])->name('faqStore');
	    Route::get('/{id}/edit', [AdminFaqController::class, 'edit'])->name('faq.edit');
	    Route::post('/update', [AdminFaqController::class, 'update'])->name('faq.update');
	    Route::get('/{id}/show', [AdminFaqController::class, 'show'])->name('faq.show');
	    Route::post('/destroy', [AdminFaqController::class, 'destroy'])->name('faq.destroy');
    });

    Route::group(['prefix'=>'page'], function(){
	    Route::get('/', [AdminPageController::class, 'index'])->name('page.index');	    
	    Route::get('/create', [AdminPageController::class, 'create'])->name('page.create');	    
	    Route::get('/{id}/edit', [AdminPageController::class, 'edit'])->name('page.edit');	    
	    Route::post('/', [AdminPageController::class, 'store'])->name('page.store');	    
	    Route::get('/{id}/show', [AdminPageController::class, 'show'])->name('page.show');	    
	    Route::post('/destroy', [AdminPageController::class, 'destroy'])->name('page.destroy');	    
    });

    Route::group(['prefix'=>'gigs'], function(){
	    Route::get('/', [AdminGigController::class, 'index'])->name('gigs.index');
	    Route::get('/edit', [AdminGigController::class, 'edit'])->name('gigs.edit');
	    Route::post('/update', [AdminGigController::class, 'update'])->name('gigs.update');
    });

    Route::group(['prefix'=>'manage-payments'], function(){
	    Route::get('/', [AdminManagePaymentsController::class, 'index'])->name('manage-payment.index');
    });

    // Route::group(['prefix'=>'invoice'], function(){
	   //  Route::get('/', [AdminInvoiceController::class, 'index'])->name('invoice.index');
    // });

    Route::group(['prefix'=>'payment'], function(){
	    Route::get('/{type}', [AdminPaymentontroller::class, 'create'])->name('payment.create');
	    Route::post('/', [AdminPaymentontroller::class, 'store'])->name('payment.store');
    });
});


// User Web
Route::controller(HomeController::class)->group(function () {
	Route::get('/', 'index')->name('home');
	Route::get('/privacy-policy', 'privacyPolicy')->name('privacyPolicy');
	Route::get('/terms', 'terms')->name('terms');
	Route::get('/guideline', 'guideline')->name('guideline');
});

Route::group(['middleware' => ['auth']], function() {
	Route::controller(InfluencerController::class)->prefix('influencer')->group(function () {	    
	    Route::get('/earning', 'earning')->name('influencerEarning');	    
	    Route::get('/profile', 'profile')->name('influencerProfile');	   	        	    	    
	    Route::post('/profile-status', 'profileStatus')->name('profileStatus');
	    Route::post('/intro-video', 'uploadIntroVideo')->name('introVideo');
	    Route::post('/intro-photos', 'uploadIntroPhotos')->name('introPhotos');
	    Route::post('/remove-intro-photos', 'removeIntroPhoto')->name('removeIntroPhoto');
	    Route::post('/update/profile-cat/', 'updateProfileCategory')->name('updateProfileCat');
	    Route::post('/update/profile-detail/', 'updateProfileDetail')->name('updateProfileDetail');
	});
	
	Route::controller(UserController::class)->prefix('user')->group(function () {
	    Route::post('/business', 'business')->name('business');	   
	    Route::post('/profile-pic', 'profilePic')->name('uploadInfluencerProfile');	   
	    Route::post('/update/profile', 'updateProfile')->name('updateInfluencerProfile');
	    Route::get('/account', 'account')->name('account');	    	    
	    Route::get('/link-bank', 'linkBank')->name('linkBank');
	    Route::post('/link-bank-acc', 'linkBankAcc')->name('linkBankAcc');
	});	

	Route::controller(StaredCollectionController::class)->prefix('stared')->group(function () {
		Route::get('/index', 'index')->name('staredCollection');
		Route::post('/collection', 'store')->name('storeCollection');
		Route::get('/collection-detail/{slug}', 'show')->name('collection.show');
		Route::post('/unstar-influencer', 'unStarInfluencer')->name('unStarInfluencer');
		Route::post('/destroy', 'destroy')->name('destroyCollection');
	});

	Route::controller(OrderController::class)->prefix('order')->group(function () {
		Route::get('/{role?}', 'index')->name('order');		    
		Route::get('/detail/{orderId}/{role}', 'show')->name('order.detail');		    
		Route::post('/order-info', 'orderInfo')->name('order.info');	    
		Route::post('/save-order-info', 'saveOrderInfo')->name('save.order-info');	    
		Route::post('/order-status', 'orderStatus')->name('order.status');	    
		Route::post('/accept-order', 'acceptOrder')->name('acceptOrder');	    
		Route::post('/decline-order', 'declineOrder')->name('declineOrder');	    
		Route::post('/deliver', 'deliver')->name('order.deliver');	    
		Route::get('/paypal-payment/{orderId}', 'paypal')->name('order.paypal');	    
		Route::post('/buyer-review', 'buyerReview')->name('buyerReview');	    
		Route::get('/download-product/{id}', 'downloadProduct')->name('downloadProduct');	    
	});

	Route::controller(NotificationController::class)->prefix('notification')->group(function () {
		Route::get('/', 'index')->name('notification');
		Route::get('/preference', 'preference')->name('preference');
	    Route::post('/manage-notification', 'manageNotification')->name('manageNotification');
	});	
});

Route::controller(InfluencerController::class)->prefix('influencer')->group(function () {
	Route::get('/detail/{id}', 'show')->name('influencerDetail');
	Route::get('/stars/{platform}', 'stars')->name('stars');
	Route::get('/{platform}/{genres?}', 'index')->name('influencers');
});

Route::controller(ContactUsController::class)->prefix('contact-us')->group(function () {
	Route::get('/', 'index')->name('contact-us');
	Route::post('/', 'store')->name('contactUs');
});

Route::controller(UserController::class)->prefix('user')->group(function () {
	Route::post('/business-filter', 'businessFilter')->name('businessFilter');	   
	Route::get('/searchBox', 'searchBox')->name('searchBox');
	Route::get('/search', 'search')->name('search');
	Route::post('/create', 'store')->name('userCreate');	
	Route::post('/login', 'login')->name('userLogin');
	Route::post('/register', 'register')->name('userRegister');
	Route::get('/mail-verification/{token}', 'mailVerification')->name('mailVerification');
});

Route::get('faq', [FaqController::class, 'index'])->name('faq');
Route::get('search-faq', [FaqController::class, 'show'])->name('searchFaq');

Auth::routes();

Route::controller(PayPalController::class)->prefix('paypal')->group(function () {
	Route::post('request', 'request')->name('paypalRequest');
	Route::post('process', 'process')->name('paypalTransaction');
	Route::get('success', 'success')->name('successTransaction');
	Route::get('cancel', 'cancel')->name('cancelTransaction');
});

Route::post('stripe', [StripeController::class, 'stripePost'])->name('stripe.post');
// Route::get('orderId', [OrderController::class, 'orderId'])->name('orderId');
