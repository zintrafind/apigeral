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
use App\Http\Controllers\DadosPessoaisController;
use App\Http\Controllers\DenunciaController;


// ============================================================
// LOGIN
// ============================================================

Route::post(
    '/login',
    [AuthController::class, 'login']
);


// ============================================================
// ROTAS AUTENTICADAS
// ============================================================

Route::middleware('auth:sanctum')->group(function () {

    // --------------------------------------------------------
    // AUTENTICAÇÃO
    // --------------------------------------------------------

    Route::post(
        '/logout',
        [AuthController::class, 'logout']
    );


    // --------------------------------------------------------
    // EDITAR DADOS PESSOAIS — E-MAIL E SENHA
    // --------------------------------------------------------

    Route::put(
        '/users/{id}/dados-pessoais',
        [DadosPessoaisController::class, 'update']
    );


    // --------------------------------------------------------
    // DENÚNCIAS
    // --------------------------------------------------------

    Route::post(
        '/denuncias',
        [DenunciaController::class, 'store']
    )->middleware('throttle:10,1');


    // --------------------------------------------------------
    // PRODUTOS
    // --------------------------------------------------------

    Route::post(
        '/products',
        [ProductController::class, 'store']
    );

    Route::put(
        '/products/{id}',
        [ProductController::class, 'update']
    );

    Route::delete(
        '/products/{id}',
        [ProductController::class, 'destroy']
    );

    Route::put(
        '/products/{id}/status',
        [ProductController::class, 'updateStatus']
    );

    Route::get(
        '/my-products',
        [ProductController::class, 'myProducts']
    );


    // --------------------------------------------------------
    // IMAGENS DOS PRODUTOS
    // --------------------------------------------------------

    Route::post(
        '/produtos/imagem',
        [ImagemProdutoController::class, 'store']
    );

    Route::post(
        '/produtos/{id}/imagem',
        [ImagemProdutoController::class, 'update']
    );


    // --------------------------------------------------------
    // PROPOSTAS DE TROCA
    // --------------------------------------------------------

    Route::get(
        '/propostas',
        [PropostaController::class, 'index']
    );

    Route::post(
        '/propostas',
        [PropostaController::class, 'store']
    );

    Route::put(
        '/propostas/{id}/status',
        [PropostaController::class, 'status']
    );

    Route::put(
        '/propostas/{id}/finalizar',
        [PropostaController::class, 'finalizar']
    );


    // --------------------------------------------------------
    // MENSAGENS
    // --------------------------------------------------------

    Route::get(
        '/propostas/{id_proposta}/mensagens',
        [MensagemController::class, 'index']
    );

    Route::post(
        '/propostas/{id_proposta}/mensagens',
        [MensagemController::class, 'store']
    );


    // --------------------------------------------------------
    // FAVORITOS
    // --------------------------------------------------------

    Route::get(
        '/favoritos',
        [FavoritoController::class, 'index']
    );

    Route::post(
        '/favoritos',
        [FavoritoController::class, 'store']
    );

    Route::delete(
        '/favoritos/{id_produto}',
        [FavoritoController::class, 'destroy']
    );
});


// ============================================================
// USUÁRIOS
// ============================================================

Route::apiResource(
    'users',
    UserController::class
);


// ============================================================
// PRODUTOS DE UM USUÁRIO
// ============================================================

Route::get(
    '/users/{id}/products',
    [ProductController::class, 'productsByUser']
);


// ============================================================
// PRODUTOS PÚBLICOS
// ============================================================

Route::get(
    '/products',
    [ProductController::class, 'index']
);

Route::get(
    '/products/{id}',
    [ProductController::class, 'show']
);


// ============================================================
// ROTAS DO ADMINISTRADOR
// ============================================================

Route::prefix('admin')->group(function () {

    // ========================================================
    // UC52 - GERENCIAR USUÁRIOS
    // ========================================================

    // --------------------------------------------------------
    // LISTAR USUÁRIOS
    // --------------------------------------------------------

    Route::get(
        '/users',
        [AdminController::class, 'listarUsuarios']
    );


    // --------------------------------------------------------
    // VISUALIZAR DADOS COMPLETOS DO USUÁRIO
    // --------------------------------------------------------

    Route::get(
        '/users/{id}/detalhes',
        [AdminController::class, 'visualizarUsuarioAdmin']
    );


    // --------------------------------------------------------
    // EDITAR USUÁRIO
    // --------------------------------------------------------

    Route::put(
        '/users/{id}',
        [AdminController::class, 'editarUsuarioAdmin']
    );


    // --------------------------------------------------------
    // BLOQUEAR / DESBLOQUEAR USUÁRIO
    // --------------------------------------------------------
    //
    // A = Ativo
    // B = Bloqueado
    //
    // Ativo     -> Bloqueado
    // Bloqueado -> Ativo
    //
    // --------------------------------------------------------

    Route::put(
        '/users/{id}/status',
        [AdminController::class, 'alterarStatusUsuarioAdmin']
    );


    // --------------------------------------------------------
    // EXCLUIR USUÁRIO
    // --------------------------------------------------------

    Route::delete(
        '/users/{id}',
        [AdminController::class, 'excluirUsuario']
    );


    // ========================================================
    // UC44 - GERENCIAR ANÚNCIOS PUBLICADOS
    // ========================================================

    // --------------------------------------------------------
    // LISTAR ANÚNCIOS
    // --------------------------------------------------------

    Route::get(
        '/products',
        [AdminController::class, 'listarProdutosAdmin']
    );


    // --------------------------------------------------------
    // VISUALIZAR DETALHES COMPLETOS DO ANÚNCIO
    // --------------------------------------------------------

    Route::get(
        '/products/{id}/detalhes',
        [AdminController::class, 'visualizarProdutoAdmin']
    );


    // --------------------------------------------------------
    // ALTERAR STATUS DO ANÚNCIO
    // --------------------------------------------------------
    //
    // A = Disponível
    // S = Suspenso
    //
    // Disponível -> Suspenso
    // Suspenso   -> Disponível
    //
    // --------------------------------------------------------

    Route::put(
        '/products/{id}/status',
        [AdminController::class, 'alterarStatusProdutoAdmin']
    );


    // --------------------------------------------------------
    // SUSPENDER ANÚNCIO
    // --------------------------------------------------------
    //
    // Mantida para compatibilidade com chamadas antigas.
    //
    // --------------------------------------------------------

    Route::put(
        '/products/{id}/suspender',
        [AdminController::class, 'suspenderProdutoAdmin']
    );


    // --------------------------------------------------------
    // EXCLUIR ANÚNCIO
    // EXCLUSÃO LÓGICA
    // --------------------------------------------------------

    Route::delete(
        '/products/{id}',
        [AdminController::class, 'excluirProdutoAdmin']
    );
});