<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ImagemProdutoController;
use App\Http\Controllers\PropostaController;
use App\Http\Controllers\MensagemController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FavoritoController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
    Route::put('/products/{id}/status', [ProductController::class, 'updateStatus']);
    Route::get('/my-products', [ProductController::class, 'myProducts']);

    Route::post('/produtos/imagem', [ImagemProdutoController::class, 'store']);
    Route::post('/produtos/{id}/imagem', [ImagemProdutoController::class, 'update']);

    Route::get('/propostas', [PropostaController::class, 'index']);
    Route::post('/propostas', [PropostaController::class, 'store']);
    Route::put('/propostas/{id}/status', [PropostaController::class, 'status']);
    Route::put('/propostas/{id}/finalizar', [PropostaController::class, 'finalizar']);

    Route::get('/propostas/{id_proposta}/mensagens', [MensagemController::class, 'index']);
    Route::post('/propostas/{id_proposta}/mensagens', [MensagemController::class, 'store']);

    Route::get('/favoritos', [FavoritoController::class, 'index']);
    Route::post('/favoritos', [FavoritoController::class, 'store']);
    Route::delete('/favoritos/{id_produto}', [FavoritoController::class, 'destroy']);
});

Route::apiResource('users', UserController::class);

Route::get('/users/{id}/products', [ProductController::class, 'productsByUser']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

Route::prefix('admin')->group(function () {
    Route::get('/users', [AdminController::class, 'listarUsuarios']);
    Route::delete('/users/{id}', [AdminController::class, 'excluirUsuario']);
    Route::get('/products', [AdminController::class, 'listarProdutosAdmin']);
    Route::delete('/products/{id}', [AdminController::class, 'excluirProdutoAdmin']);
});
