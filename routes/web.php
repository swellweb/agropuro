<?php

use App\Http\Controllers\CrowdfundingController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MapFarmController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/create-checkout-session', [DonationController::class, 'createCheckoutSession'])->name('donation.checkout');
    Route::get('/success', function () {
        return view('success');
    })->name('donation.success');
    Route::get('/cancel', function () {
        return view('cancel');
    })->name('donation.cancel');


});
Route::get('/mappa-agricoltori', [MapFarmController::class, 'index'])->name('home');
Route::get('/crowdfunding', [CrowdfundingController::class, 'index']);
Route::middleware(['auth'])->group(function () {
    Route::post('/donate', [DonationController::class, 'store'])->name('donate.store');
});

require __DIR__.'/auth.php';
