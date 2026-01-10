<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StaffDashboardController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\SuperAdminController;

use App\Http\Controllers\OrderingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/order/{token}', [OrderingController::class, 'showMenu'])->name('order.show');
Route::post('/order/checkout', [OrderingController::class, 'checkout'])->name('order.checkout');
Route::get('/order/success/{id}', [OrderingController::class, 'success'])->name('order.success');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('admin/categories', CategoryController::class)->names('categories');
    Route::resource('admin/menu-items', MenuItemController::class)->names('menu_items');
    Route::resource('admin/tables', TableController::class)->names('tables');
    Route::post('admin/tables/{table}/regenerate', [TableController::class, 'generateNewToken'])->name('tables.regenerate');
    Route::get('admin/tables/{table}/download-qr', [TableController::class, 'downloadQR'])->name('tables.downloadQR');
    Route::resource('admin/staff', StaffController::class)->names('staff');

    // Restaurant Customisation
    Route::get('admin/customisation', [RestaurantController::class, 'edit'])->name('admin.customisation.edit');
    Route::put('admin/customisation', [RestaurantController::class, 'update'])->name('admin.customisation.update');

    // Staff Routes
    Route::get('/staff/dashboard', [StaffDashboardController::class, 'index'])->name('staff.dashboard');
    Route::get('/staff/orders', [StaffDashboardController::class, 'orders'])->name('staff.orders');
    Route::get('/staff/orders/{order}/edit', [StaffDashboardController::class, 'editOrder'])->name('staff.orders.edit');
    Route::get('/staff/orders/{order}/print', [StaffDashboardController::class, 'printOrder'])->name('staff.orders.print');
    Route::put('/staff/orders/{order}', [StaffDashboardController::class, 'updateOrder'])->name('staff.orders.update');
    Route::post('/staff/orders/{order}/status', [StaffDashboardController::class, 'updateOrderStatus'])->name('staff.orders.status');
    Route::post('/staff/orders/{order}/receive-all', [StaffDashboardController::class, 'receiveAllItems'])->name('staff.orders.receive_all');
    Route::post('/staff/order-items/{item}/received', [StaffDashboardController::class, 'toggleItemReceived'])->name('staff.order_items.received');
    Route::get('/staff/orders/check', [StaffDashboardController::class, 'checkNewOrders'])->name('staff.orders.check');
    Route::get('/staff/menu', [StaffDashboardController::class, 'menu'])->name('staff.menu');
    Route::post('/staff/menu/{menuItem}/toggle', [StaffDashboardController::class, 'toggleMenuAvailability'])->name('staff.menu.toggle');
    Route::get('/staff/history', [StaffDashboardController::class, 'history'])->name('staff.history');
});

// Super Admin Routes
Route::middleware(['auth', 'super_admin'])->prefix('super-admin')->group(function () {
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('super_admin.dashboard');
    Route::get('/restaurants', [SuperAdminController::class, 'restaurants'])->name('super_admin.restaurants');
    Route::get('/restaurants/create', [SuperAdminController::class, 'createRestaurant'])->name('super_admin.restaurants.create');
    Route::post('/restaurants', [SuperAdminController::class, 'storeRestaurant'])->name('super_admin.restaurants.store');
    Route::get('/restaurants/{restaurant}/edit', [SuperAdminController::class, 'editRestaurant'])->name('super_admin.restaurants.edit');
    Route::put('/restaurants/{restaurant}', [SuperAdminController::class, 'updateRestaurant'])->name('super_admin.restaurants.update');
    Route::delete('/restaurants/{restaurant}', [SuperAdminController::class, 'destroyRestaurant'])->name('super_admin.restaurants.destroy');

    // Platform Team
    Route::get('/users', [SuperAdminController::class, 'users'])->name('super_admin.users');
    Route::post('/users', [SuperAdminController::class, 'storeUser'])->name('super_admin.users.store');
    Route::delete('/users/{user}', [SuperAdminController::class, 'destroyUser'])->name('super_admin.users.destroy');
});
