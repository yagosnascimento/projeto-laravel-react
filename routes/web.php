<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Quando o usuário acessar a raiz '/', o PostController executa o método 'index'
Route::get('/', [PostController::class, 'index']);