<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('/home', function () {
    return view('home', ['products' => App\Models\Product::take(3)->get()]);
})->name('home');

Route::get('/shop', function () {
    return view('shop', ['products' => App\Models\Product::all()]);
})->name('shop');

Route::get('/shop/{id}', function ($id) {
    $product = App\Models\Product::findOrFail($id);
    return view('products.show', compact('product'));
})->name('products.show');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

Route::get('/cart', function () {
    return view('cart');
})->name('cart');

Route::middleware('auth')->group(function () {
    Route::get('/tambah-alamat', [\App\Http\Controllers\AddressController::class, 'create'])->name('address.create');
    Route::post('/tambah-alamat', [\App\Http\Controllers\AddressController::class, 'store'])->name('address.store');
    Route::get('/ubah-alamat', [\App\Http\Controllers\AddressController::class, 'index'])->name('address.index');
    Route::post('/alamat/{id}/default', [\App\Http\Controllers\AddressController::class, 'setDefault'])->name('address.setDefault');
    Route::delete('/alamat/{id}', [\App\Http\Controllers\AddressController::class, 'destroy'])->name('address.destroy');

    Route::get('/checkout', function () {
        return view('checkout', ['addresses' => \Illuminate\Support\Facades\Auth::user()->addresses]);
    })->name('checkout.index');

    Route::get('/payment', function () {
        return view('payment');
    })->name('payment.index');

    Route::post('/checkout', [\App\Http\Controllers\OrderController::class, 'store'])->name('checkout.store');

    Route::get('/pesanan', [\App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('/pesanan/{id}/bukti-pembayaran', [\App\Http\Controllers\OrderController::class, 'paymentProof'])->where('id', '.*')->name('orders.payment_proof');
    Route::get('/pesanan/{id}/receipt', [\App\Http\Controllers\Admin\AdminPdfController::class, 'orderReceiptPdf'])->where('id', '.*')->name('orders.receipt_public');
    Route::post('/bayar', [\App\Http\Controllers\OrderController::class, 'paid'])->name('orders.paid');
    Route::get('/pesanan/{id}', [\App\Http\Controllers\OrderController::class, 'show'])->where('id', '.*')->name('orders.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::prefix('admin-petugas')->name('admin.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [\App\Http\Controllers\Admin\AuthController::class, 'create'])->name('login');
        Route::post('/login', [\App\Http\Controllers\Admin\AuthController::class, 'store'])->name('login.store');
    });

    Route::middleware('admin')->group(function () {
        Route::post('/logout', [\App\Http\Controllers\Admin\AuthController::class, 'destroy'])->name('logout');

        // Dashboard
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        // Order PDF (Admin/Staff)
        Route::get('/orders/{id}/receipt', [\App\Http\Controllers\Admin\AdminPdfController::class, 'orderReceiptPdf'])->where('id', '.*')->name('orders.receipt');

        // Kelola Pesanan — specific before wildcard {id}
        Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->where('id', '.*')->name('orders.show');
        Route::put('/orders/{id}', [\App\Http\Controllers\Admin\OrderController::class, 'update'])->where('id', '.*')->name('orders.update');

        // Kelola Produk (CRUD)
        Route::get('/products', [\App\Http\Controllers\Admin\ProductController::class, 'index'])->name('products.index');
        Route::post('/products', [\App\Http\Controllers\Admin\ProductController::class, 'store'])->name('products.store');
        Route::put('/products/{id}', [\App\Http\Controllers\Admin\ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{id}', [\App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('products.destroy');

        // Petugas (Staff) CRUD
        Route::get('/staff', [\App\Http\Controllers\Admin\StaffController::class, 'index'])->name('staff.index');
        Route::post('/staff', [\App\Http\Controllers\Admin\StaffController::class, 'store'])->name('staff.store');
        Route::put('/staff/{id}', [\App\Http\Controllers\Admin\StaffController::class, 'update'])->name('staff.update');
        Route::delete('/staff/{id}', [\App\Http\Controllers\Admin\StaffController::class, 'destroy'])->name('staff.destroy');

        // Customer
        Route::get('/customers', [\App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('customers.index');
        Route::get('/customers/{id}', [\App\Http\Controllers\Admin\CustomerController::class, 'show'])->name('customers.show');
        Route::delete('/customers/{id}', [\App\Http\Controllers\Admin\CustomerController::class, 'destroy'])->name('customers.destroy');

        // Reports
        Route::get('/reports/sales', [\App\Http\Controllers\Admin\SalesReportController::class, 'index'])->name('reports.sales');
        Route::get('/reports/sales/pdf', [\App\Http\Controllers\Admin\AdminPdfController::class, 'salesReportPdf'])->name('reports.sales.pdf');
        Route::get('/reports/customer', [\App\Http\Controllers\Admin\CustomerReportController::class, 'index'])->name('reports.customer');


        Route::post('/reports/customer/{id}/forward', [\App\Http\Controllers\Admin\CustomerReportController::class, 'forward'])->name('reports.customer.forward');
        Route::post('/reports/customer/{id}/resolve', [\App\Http\Controllers\Admin\CustomerReportController::class, 'resolve'])->name('reports.customer.resolve');
        Route::delete('/reports/customer/{id}', [\App\Http\Controllers\Admin\CustomerReportController::class, 'destroy'])->name('reports.customer.destroy');

        // Legacy users route (keep for compatibility)
        Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    });
});

