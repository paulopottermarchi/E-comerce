<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthManager;
use App\Http\Controllers\OrderManager;



Route::any('/stripe/webhook',
    [OrderManager::class,'webhookStripe']);
