<?php
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\Block1Controller;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [MainController::class, 'index'])->name('index');
    });

Route::prefix('admin/block1')
    ->name('block1.')
    ->group(function () {
        Route::get('/', [Block1Controller::class, 'index'])->name('index');
        Route::get('/create', [Block1Controller::class, 'create'])->name('create');
        Route::post('/', [Block1Controller::class, 'store'])->name('store');
        Route::get('/{id}/edit', [Block1Controller::class, 'edit'])->name('edit');
        Route::put('/{id}', [Block1Controller::class, 'update'])->name('update');
        Route::delete('/{id}', [Block1Controller::class, 'destroy'])->name('destroy');
    });