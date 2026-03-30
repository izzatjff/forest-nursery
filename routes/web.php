<?php

use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\OriginController;
use App\Http\Controllers\Web\PlantController;
use App\Http\Controllers\Web\PricingController;
use App\Http\Controllers\Web\ProcurementController;
use App\Http\Controllers\Web\SaleController;
use App\Http\Controllers\Web\SeedBatchController;
use App\Http\Controllers\Web\SpeciesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Server-rendered Blade views with full CRUD for all modules.
| All data is fetched from the Forest Nursery API via the ApiClient service.
|
*/

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Species CRUD
Route::get('species', [SpeciesController::class, 'index'])->name('species.index');
Route::get('species/create', [SpeciesController::class, 'create'])->name('species.create');
Route::post('species', [SpeciesController::class, 'store'])->name('species.store');
Route::get('species/{id}', [SpeciesController::class, 'show'])->name('species.show');
Route::get('species/{id}/edit', [SpeciesController::class, 'edit'])->name('species.edit');
Route::put('species/{id}', [SpeciesController::class, 'update'])->name('species.update');
Route::delete('species/{id}', [SpeciesController::class, 'destroy'])->name('species.destroy');

// Origins CRUD
Route::get('origins', [OriginController::class, 'index'])->name('origins.index');
Route::get('origins/create', [OriginController::class, 'create'])->name('origins.create');
Route::post('origins', [OriginController::class, 'store'])->name('origins.store');
Route::get('origins/{id}', [OriginController::class, 'show'])->name('origins.show');
Route::get('origins/{id}/edit', [OriginController::class, 'edit'])->name('origins.edit');
Route::put('origins/{id}', [OriginController::class, 'update'])->name('origins.update');
Route::delete('origins/{id}', [OriginController::class, 'destroy'])->name('origins.destroy');

// Seed Batches CRUD
Route::get('seed-batches', [SeedBatchController::class, 'index'])->name('seed-batches.index');
Route::get('seed-batches/create', [SeedBatchController::class, 'create'])->name('seed-batches.create');
Route::post('seed-batches', [SeedBatchController::class, 'store'])->name('seed-batches.store');
Route::get('seed-batches/{id}', [SeedBatchController::class, 'show'])->name('seed-batches.show');
Route::get('seed-batches/{id}/edit', [SeedBatchController::class, 'edit'])->name('seed-batches.edit');
Route::put('seed-batches/{id}', [SeedBatchController::class, 'update'])->name('seed-batches.update');
Route::delete('seed-batches/{id}', [SeedBatchController::class, 'destroy'])->name('seed-batches.destroy');

// Plants CRUD
Route::get('plants', [PlantController::class, 'index'])->name('plants.index');
Route::get('plants/create', [PlantController::class, 'create'])->name('plants.create');
Route::post('plants', [PlantController::class, 'store'])->name('plants.store');
Route::get('plants/{id}', [PlantController::class, 'show'])->name('plants.show');
Route::get('plants/{id}/edit', [PlantController::class, 'edit'])->name('plants.edit');
Route::put('plants/{id}', [PlantController::class, 'update'])->name('plants.update');
Route::delete('plants/{id}', [PlantController::class, 'destroy'])->name('plants.destroy');

// Sales (index, create, store, show — no edit/update/destroy)
Route::get('sales', [SaleController::class, 'index'])->name('sales.index');
Route::get('sales/create', [SaleController::class, 'create'])->name('sales.create');
Route::post('sales', [SaleController::class, 'store'])->name('sales.store');
Route::get('sales/{id}', [SaleController::class, 'show'])->name('sales.show');

// Procurements (index, create, store, show — no edit/update/destroy)
Route::get('procurements', [ProcurementController::class, 'index'])->name('procurements.index');
Route::get('procurements/create', [ProcurementController::class, 'create'])->name('procurements.create');
Route::post('procurements', [ProcurementController::class, 'store'])->name('procurements.store');
Route::get('procurements/{id}', [ProcurementController::class, 'show'])->name('procurements.show');

// Pricing Engine
Route::prefix('pricing')->name('pricing.')->group(function () {
    Route::get('/', [PricingController::class, 'index'])->name('index');

    // Pricing Rules
    Route::get('/rules/create', [PricingController::class, 'createRule'])->name('rules.create');
    Route::post('/rules', [PricingController::class, 'storeRule'])->name('rules.store');
    Route::get('/rules/{id}/edit', [PricingController::class, 'editRule'])->name('rules.edit');
    Route::put('/rules/{id}', [PricingController::class, 'updateRule'])->name('rules.update');
    Route::delete('/rules/{id}', [PricingController::class, 'destroyRule'])->name('rules.destroy');

    // Origin Multipliers
    Route::get('/multipliers/create', [PricingController::class, 'createMultiplier'])->name('multipliers.create');
    Route::post('/multipliers', [PricingController::class, 'storeMultiplier'])->name('multipliers.store');
    Route::delete('/multipliers/{id}', [PricingController::class, 'destroyMultiplier'])->name('multipliers.destroy');

    // Height Brackets
    Route::get('/brackets/create', [PricingController::class, 'createBracket'])->name('brackets.create');
    Route::post('/brackets', [PricingController::class, 'storeBracket'])->name('brackets.store');
    Route::delete('/brackets/{id}', [PricingController::class, 'destroyBracket'])->name('brackets.destroy');
});
