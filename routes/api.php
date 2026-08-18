<?php

use App\Http\Controllers\Api\ClienteController;
use Illuminate\Support\Facades\Route;

Route::apiResource('clientes', ClienteController::class)->names('api.clientes');
