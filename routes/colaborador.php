<?php

use App\Http\Livewire\Concentrate\Base as ConcentrateBase;
use App\Http\Livewire\Order\Base as OrderBase;
use App\Http\Livewire\Blending\Base as BlendingBase;
use App\Http\Livewire\Settlement\Base as SettlementBase;
use App\Http\Livewire\Dispatch\Base as DispatchBase;
use App\Http\Livewire\Sent\Base as SentBase;
use Illuminate\Support\Facades\Route;

Route::get("/concentrate",ConcentrateBase::class)->name('colaborador.concentrates');
Route::get("/orders",OrderBase::class)->name('colaborador.orders');
Route::get("/blendings",BlendingBase::class)->name('colaborador.blendings');
Route::get("/settlements",SettlementBase::class)->name('colaborador.settlements');
Route::get("/dispatch",DispatchBase::class)->name('colaborador.dispatches');
Route::get("/sent",SentBase::class)->name('colaborador.sent');
