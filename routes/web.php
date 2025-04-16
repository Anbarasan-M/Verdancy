<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ServiceProviderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SubscriptionController;

use App\Http\Controllers\Auth\PasswordResetController;

// Show the form to request a password reset link
Route::get('password/reset', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
// Handle sending the password reset link
Route::post('password/email', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
// Show the form to reset the password
Route::get('password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
// Handle the password reset
Route::post('password/reset', [PasswordResetController::class, 'reset'])->name('password.update');


Route::get('/', function () {
    return view('welcome');
});

// Auth routes
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// A test route to ensure everything is in harmony
Route::get('/superadmin/dashboard', [UserController::class, 'superadminDashboard'])->name('superadmin.dashboard');
Route::get('/seller/dashboard', [UserController::class, 'sellerDashboard'])->name('seller.dashboard');
Route::get('/user/dashboard', [UserController::class, 'userDashboard'])->name('user.dashboard');
Route::get('/service-provider/dashboard', [UserController::class, 'serviceProviderDashboard'])->name('serviceProvider.dashboard');

// Routes for user
Route::get('/user/shop', [UserController::class, 'shop'])->name('users.shop');
// Route::get('/user/cart', [UserController::class, 'cart'])->name('users.cart');

Route::get('/services', [ServiceController::class, 'showServices'])->name('services');
Route::get('/services/book/{id}', [ServiceController::class, 'showBookingForm'])->name('book.service');
Route::post('/services/book/{id}', [ServiceController::class, 'bookService'])->name('book.service.submit');



// Cart 

Route::get('/cart', [CartController::class, 'showCart'])->name('cart.index');
Route::post('/cart/buy', [CartController::class, 'buyAll'])->name('cart.buys');


Route::post('/create-order', [OrderController::class, 'buyFromCart'])->name('create.order');

Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');




// Routes for user

// Resourceful controllers to manage the ecosystem
Route::resource('users', UserController::class);
Route::resource('bookings', BookingController::class);
Route::resource('carts', CartController::class);

// Custom routes for different types of users
Route::get('/user/create', [UserController::class, 'createUser'])->name('users.create');
Route::get('/seller/create', [UserController::class, 'createSeller'])->name('sellers.create');
Route::get('/service-provider/create', [UserController::class, 'createServiceProvider'])->name('serviceProvider.create');

// Securing the dashboards with auth middleware
Route::middleware('auth')->group(function () {
    Route::get('users/dashboard', [UserController::class, 'dashboard'])->name('users.dashboard');
    Route::get('sellers/dashboard', [SellerController::class, 'dashboard'])->name('sellers.dashboard');
    Route::get('service_providers/dashboard', [ServiceController::class, 'dashboard'])->name('service_providers.dashboard');
});



// Route for viewing all bookings
Route::get('/service-provider/bookings', [ServiceController::class, 'bookings'])->name('serviceProvider.bookings');

Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.list');

Route::get('/sellers', [SellerController::class, 'index'])->name('sellers.index');
Route::post('/sellers/{user}/approve', [SellerController::class, 'approve'])->name('sellers.approve');
Route::post('/sellers/{user}/reject', [SellerController::class, 'reject'])->name('sellers.reject');


Route::get('/service-providers', [ServiceProviderController::class, 'index'])->name('serviceProviders.index');
Route::post('/service-providers/{user}/approve', [ServiceProviderController::class, 'approve'])->name('serviceProviders.approve');
Route::post('/service-providers/{user}/reject', [ServiceProviderController::class, 'reject'])->name('serviceProviders.reject');


// Admin Dashboard Route
Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

// Routes for buttons
Route::get('/admin/add-seller', [AdminController::class, 'addSeller'])->name('admin.addSeller');
Route::get('/admin/add-service-provider', [AdminController::class, 'addServiceProvider'])->name('admin.addServiceProvider');
Route::get('/admin/stocks', [AdminController::class, 'stocks'])->name('admin.stocks');
Route::get('/admin/add-service', [AdminController::class, 'addService'])->name('admin.addService');


Route::get('/admin/services', [AdminController::class, 'services'])->name('admin.services');


// Route for applying leave
Route::get('/service-provider/apply-leave', [LeaveController::class, 'leaveForm'])->name('serviceProvider.leave');
Route::post('/service-provider/apply-leave', [LeaveController::class, 'applyLeave'])->name('serviceProvider.leave.apply');

// Fetch pending leaves
Route::get('/admin/leaves', [LeaveController::class, 'index'])->name('admin.manageLeaves');
// Approve leave
Route::post('/admin/leaves/{id}/approve', [LeaveController::class, 'approve'])->name('admin.leaves.approve');
// Reject leave
Route::post('/admin/leaves/{id}/reject', [LeaveController::class, 'reject'])->name('admin.leaves.reject');




// web.php

Route::patch('/bookings/{id}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
Route::post('/bookings/{id}/complete', [BookingController::class, 'complete'])->name('bookings.complete');
Route::patch('/bookings/{id}/confirm', [BookingController::class, 'confirm'])->name('bookings.confirm');


Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');


Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

// web.php
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
// web.php
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');

Route::get('/admin/services/edit/{id}', [ServiceController::class, 'edit'])->name('services.edit');
Route::put('/admin/services/update/{id}', [ServiceController::class, 'update'])->name('services.update');


Route::get('/sellers/export', [SellerController::class, 'export'])->name('sellers.export');
Route::post('/service-providers/import', [ServiceProviderController::class, 'import'])->name('serviceProviders.import');

Route::get('/orders', [OrderController::class, 'orders'])->name('orders');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
Route::patch('orders/{id}/ship', [OrderController::class, 'ship'])->name('orders.ship');
Route::patch('orders/{id}/deliver', [OrderController::class, 'deliver'])->name('orders.deliver');
Route::patch('orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

// routes/web.php
Route::get('/order/{id}/pdf', [OrderController::class, 'downloadPdf'])->name('order.pdf');


Route::post('/make-payment', [PaymentController::class, 'createOrder'])->name('make.payment');
Route::post('/payment-callback', [PaymentController::class, 'paymentCallback'])->name('payment.callback');
Route::get('/payment', [PaymentController::class, 'showPaymentForm'])->name('payment.form');
// In your routes/web.php
Route::post('/complete-payment', [PaymentController::class, 'completePayment'])->name('complete.payment');

Route::get('/order/success/{orderId}', [PaymentController::class, 'orderSuccess'])->name('order.success');
Route::get('/order-failure', [PaymentController::class, 'OrderFailure'])->name('order.failure');


Route::get('/product/{id}', [ProductController::class, 'showProduct'])->name('product.show');


Route::get('/transactions', [PaymentController::class, 'index'])->name('transactions.index');
Route::get('/transactions/{id}', [PaymentController::class, 'show'])->name('transactions.show');
Route::get('/transactions/{id}/pdf', [PaymentController::class, 'downloadPDF'])->name('transactions.pdf');

Route::get('/home', [HomeController::class, 'home'])->name('home');
Route::get('/home2', [UserController::class, 'home2'])->name('home2');



// In routes/web.php

// Routes accessible only by Admins
Route::group(['middleware' => ['admin']], function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

// Routes accessible only by Sellers
Route::group(['middleware' => ['seller']], function () {
    Route::get('/seller/products', [SellerController::class, 'index'])->name('seller.products');
});

// Routes accessible only by Users
Route::group(['middleware' => ['user']], function () {
    Route::get('/categories/{id}', [CategoryController::class, 'productBasedOnCategories'])->name('productBasedOnCategories');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
});

// Routes accessible only by Service Providers
Route::group(['middleware' => ['serviceProvider']], function () {
 });


// Route to handle subscription form submission
Route::post('/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscribe.submit');
