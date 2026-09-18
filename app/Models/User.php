<?php

namespace App\Models;

use App\Models\Proposta;
use App\Models\Mensagem;
use App\Models\Favorito;
use App\Models\Notificacao;
use App\Models\Denuncia;
use App\Models\HistoricoInteracao;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Nome da tabela
     */
    protected $table = 'tb_usuario';

    /**
     * Chave primária
     */
    protected $primaryKey = 'id_usuario';

    /**
     * A chave primária é auto incremento
     */
    public $incrementing = true;

    /**
     * Tipo da chave primária
     */
    protected $keyType = 'int';

    /**
     * O Laravel usará created_at e updated_at
     */
    public $timestamps = true;

    /**
     * Campos que podem ser preenchidos
     */
    protected $fillable = [
        'nm_usuario',
        'email',
        'password',
        'tp_usuario',
        'st_usuario',
        'st_email_verificado',
        'ds_foto_perfil',
        'ds_banner',
        'ds_usuario',
        'remember_token'
    ];

    /**
     * Campos ocultos nas respostas da API
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Conversão automática de tipos
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'password' => 'hashed',
    ];
    /**
 * Produtos anunciados pelo usuário
 */
public function produtos(): HasMany
{
    return $this->hasMany(Product::class, 'id_usuario', 'id_usuario');
}

/**
 * Propostas enviadas pelo usuário
 */
public function propostasEnviadas(): HasMany
{
    return $this->hasMany(Proposta::class, 'id_solicitante', 'id_usuario');
}
/**
 * Propostas recebidas pelo usuário
 */
public function propostasRecebidas(): HasMany
{
    return $this->hasMany(Proposta::class, 'id_destinatario', 'id_usuario');
}
/**
 * Mensagens enviadas pelo usuário
 */
public function mensagens(): HasMany
{
    return $this->hasMany(Mensagem::class, 'id_usuario', 'id_usuario');
}
/**
 * Produtos favoritos do usuário
 */
public function favoritos(): HasMany
{
    return $this->hasMany(Favorito::class, 'id_usuario', 'id_usuario');
}
/**
 * Notificações do usuário
 */
public function notificacoes(): HasMany
{
    return $this->hasMany(Notificacao::class, 'id_usuario', 'id_usuario');
}
/**
 * Denúncias realizadas pelo usuário
 */
public function denuncias(): HasMany
{
    return $this->hasMany(Denuncia::class, 'id_usuario', 'id_usuario');
}
/**
 * Histórico de interações do usuário
 */
public function historicoInteracoes(): HasMany
{
    return $this->hasMany(HistoricoInteracao::class, 'id_usuario', 'id_usuario');
}
}