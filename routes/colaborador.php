<?php

use App\Http\Livewire\Concentrate\Base as ConcentrateBase;
use App\Http\Livewire\Order\Base as OrderBase;
use Illuminate\Support\Facades\Route;

Route::get("/concentrate",ConcentrateBase::class)->name('colaborador.concentrates');
Route::get("/orders",OrderBase::class)->name('colaborador.orders');
