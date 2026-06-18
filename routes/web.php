<?php

use App\Livewire\ShelterBoard\ActivationDetail;
use App\Livewire\ShelterBoard\Dashboard;
use App\Livewire\ShelterBoard\GuestRegistration;
use App\Livewire\ShelterBoard\GuestSearch;
use App\Livewire\ShelterBoard\ShelterOperations;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::view('/shelters', 'shelters')->name('shelters');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])
    ->prefix('shelter-board')
    ->name('shelter-board.')
    ->group(function () {
        Route::get('/', Dashboard::class)->name('dashboard');
        Route::get('/activations/{activation}', ActivationDetail::class)->name('activations.show');
        Route::get('/operations/{activationShelter}', ShelterOperations::class)->name('operations.show');
        Route::get('/operations/{activationShelter}/guests/search', GuestSearch::class)->name('guests.search');
        Route::get('/operations/{activationShelter}/guests/register', GuestRegistration::class)->name('guests.register');
    });

require __DIR__.'/settings.php';
