<?php

use App\Http\Livewire\Concentrate\Base as ConcentrateBase;
use App\Http\Livewire\Order\Base as OrderBase;
use App\Http\Livewire\Settlement\Base as SettlementBase;
use App\Http\Livewire\Dispatch\Base as DispatchBase;
use App\Http\Livewire\Sent\Base as SentBase;
use Illuminate\Support\Facades\Route;

Route::get("/concentrate",ConcentrateBase::class)->name('administrador.concentrates');
Route::get("/orders",OrderBase::class)->name('administrador.orders');
Route::get("/settlements",SettlementBase::class)->name('administrador.settlements');
Route::get("/blending",DispatchBase::class)->name('administrador.dispatches');
Route::get("/sent",SentBase::class)->name('administrador.sent');
