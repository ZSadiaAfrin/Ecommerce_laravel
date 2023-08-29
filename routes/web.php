<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CuponController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerPasswordResetController;
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\GithubController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\StripePaymentController;
use Illuminate\Support\Facades\Route;



//Frontend
Route::get('/', [FrontendController::class, 'index'])->name('index');
//product details
Route::get('/product/details/{slug}', [FrontendController::class, 'details'])->name('details');
Route::post('/getSize', [FrontendController::class, 'getSize']);
Route::get('/cart', [FrontendController::class, 'cart'])->name('cart');
//search product
Route::get('/search',[SearchController::class,'search'])->name('search');


//customer controller
Route::get('/customer/register/login',[CustomerController::class,'customer_register_login'])->name('customer.register.login');
Route::post('/customer/register/store',[CustomerController::class,'customer_register_store'])->name('customer.register.store');
Route::post('/customer/login',[CustomerController::class, 'customer_login'])->name('customer.login');
Route::get('/customer/logout',[CustomerController::class, 'customer_logout'])->name('customer.logout');
Route::get('/customer/profile',[CustomerController::class, 'customer_profile'])->name('customer.profile');
Route::post('/customer/profile/update',[CustomerController::class, 'customer_profile_update'])->name('customer.update');
Route::get('/myorder',[CustomerController::class,'myorder'])->name('myorder');



Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
//User
Route::get('/users', [UserController::class, 'users'])->name('users');
Route::get('/user/delete/{user_id}', [UserController::class, 'user_delete'])->name('user.delete');
Route::get('/user/edit', [UserController::class, 'user_edit'])->name('user.edit');
Route::post('/user/profile/update', [UserController::class, 'user_profile_update'])->name('update.profile.info');
Route::post('/user/password/update', [UserController::class, 'user_password_update'])->name('update.password');
Route::post('/user/photo/update', [UserController::class, 'user_photo_update'])->name('update.profile.photo');

//category
Route::get('/category', [CategoryController::class, 'category'])->name('category');
Route::post('/category/store', [CategoryController::class, 'category_store'])->name('category.store');
Route::get('/category/delete/{category_id}', [CategoryController::class, 'category_delete'])->name('category.delete');
Route::get('/category/edit/{category_id}', [CategoryController::class, 'category_edit'])->name('category.edit');
Route::post('/category/update', [CategoryController::class, 'category_update'])->name('category.update');
Route::get('/category/restore/{category_id}', [CategoryController::class, 'category_restore'])->name('category.restore');
Route::get('/category/permanent/delete/{category_id}', [CategoryController::class, 'category_del'])->name('category.del');
Route::post('/category/checked/delete', [CategoryController::class, 'category_checked_delete'])->name('check.delete');
Route::post('/category/checked/restore', [CategoryController::class, 'category_checked_restore'])->name('check.restore');
 Route::get('/category/checked/deleted/{category_id}', [CategoryController::class, 'category_checked_deleted_permanently'])->name('checkper.del');
//subcategory
 Route::get('/subcategory', [SubCategoryController::class, 'subcategory'])->name('subcategory');
 Route::post('/subcategory/store', [SubCategoryController::class, 'subcategory_store'])->name('subcategory.store');
//delete sub category
Route::get('/subcategory/delete/{subcategory_id}', [SubCategoryController::class, 'subcategory_delete'])->name('subcategory.delete');

//edit subcategory
Route::get('/subcategory/edit/{subcategory_id}', [SubCategoryController::class, 'subcategory_edit'])->name('subcategory.edit');
Route::post('/subcategory/update', [SubCategoryController::class, 'subcategory_update'])->name('subcategory.update');
//brand
Route::get('/brand', [BrandController::class, 'brand'])->name('brand');
Route::post('/brand/store', [BrandController::class, 'brand_store'])->name('brand.store');

//product
Route::get('/add/product', [ProductController::class, 'add_product'])->name('add.product');
Route::post('/getSubcategory', [ProductController::class, 'getSubcategory']);
Route::post('/product/store', [ProductController::class, 'product_store'])->name('product.store');
Route::get('/product/list', [ProductController::class, 'product_list'])->name('product.list');
Route::get('/product/edit/{product_id}', [ProductController::class, 'product_edit'])->name('product.edit');
Route::post('/product/update/', [ProductController::class, 'product_update'])->name('product.update');
//product delete
Route::delete('/product/delete/{product_id}', [ProductController::class, 'product_delete'])->name('product.delete');
//variation
Route::get('/variation',[InventoryController::class,'variation'])->name('variation');
Route::post('/variation/store',[InventoryController::class,'variation_store'])->name('variation.store');
//size
Route::get('/size/delete/{size_id}',[InventoryController::class,'size_delete'])->name('size.delete');
//colors
Route::get('/color/delete/{color_id}',[InventoryController::class,'color_delete'])->name('color.delete');
//inventory
Route::get('/product/inventory/{product_id}',[InventoryController::class,'product_inventory'])->name('product.inventory');
Route::post('/inventory/store',[InventoryController::class,'inventory_store'])->name('inventory.store');
//inventory
Route::get('/inventory/delete/{inventory_id}',[InventoryController::class,'inventory_delete'])->name('inventory.delete');
//cart controller frontend
Route::post('/cart/store',[CartController::class,'cart_store'])->name('cart.store');
Route::get('/cart/remove/{cart_id}',[CartController::class,'remove_cart'])->name('remove.cart');
Route::post('/cart/update' ,[CartController::class,'cart_update'])->name('cart.update');
//coupon
Route::get('/coupon',[CuponController::class,'coupon'])->name('coupon');
Route::post('/coupon/store',[CuponController::class,'coupon_store'])->name('coupon.store');
//checkout
Route::get('/checkout',[CheckoutController::class,'checkout'])->name('checkout');
Route::post('/getCity',[CheckoutController::class,'getCity']);
Route::post('/order/store',[CheckoutController::class,'order_store'])->name('order.store');
Route::get('/order/success/{order_id}',[CheckoutController::class,'order_success'])->name('order.success');
//order

Route::get('/orders',[OrderController::class,'orders'])->name('orders');
Route::post('/status/update',[OrderController::class,'status_update'])->name('status.update');
Route::get('/download/invoice/{order_id}',[OrderController::class,'download_invoice'])->name('download.invoice');
// SSLCOMMERZ Start
Route::get('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ End

//stripe
Route::controller(StripePaymentController::class)->group(function(){
    Route::get('stripe', 'stripe');
    Route::post('stripe', 'stripePost')->name('stripe.post');
});
//Review
Route::post('/review',[CustomerController::class,'review_store'])->name('review.store');
//forgot password email
Route::get('forgot/password',[CustomerPasswordResetController::class,'forgot_password'])->name('forgot.password');
Route::post('password/reset/req/send',[CustomerPasswordResetController::class,'password_reset_req_send'])->name('password.reset.req.send');
Route::get('pass/reset/form/{token}',[CustomerPasswordResetController::class,'pass_reset_form'])->name('pass.reset.form');

Route::post('password/reset/confirm',[CustomerPasswordResetController::class,'password_reset_confirm'])->name('password.reset.confirm');
Route::get('customer/email/verify/{token}',[CustomerController::class,'customer_email_verify'])->name('customer.email.verify');
Route::get('send/emailverify/req',[CustomerController::class,'send_emailverify_req'])->name('send.emailverify.req');
Route::post('email/verify/req/send',[CustomerController::class,'email_verify_req_send'])->name('email.verify.req.send');
//social login
Route::get('github/redirect',[GithubController::class,'github_redirect'])->name('github.redirect');
Route::get('github/callback',[GithubController::class,'github_callback'])->name('github.callback');

Route::get('google/redirect',[GoogleController::class,'google_redirect'])->name('google.redirect');
Route::get('google/callback',[GoogleController::class,'google_callback'])->name('google.callback');

Route::get('facebook/redirect',[FacebookController::class,'facebook_redirect'])->name('facebook.redirect');
Route::get('facebook/callback',[FacebookController::class,'facebook_callback'])->name('facebook.callback');
