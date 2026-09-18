<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proposta extends Model
{
    use HasFactory;

    /**
     * Nome da tabela
     */
    protected $table = 'tb_proposta';

    /**
     * Chave primária
     */
    protected $primaryKey = 'id_proposta';

    /**
     * Auto incremento
     */
    public $incrementing = true;

    /**
     * Tipo da chave
     */
    protected $keyType = 'int';

    /**
     * Utiliza created_at e updated_at
     */
    public $timestamps = true;

    /**
     * Campos permitidos
     */
   protected $fillable = [
    'id_solicitante',
    'id_destinatario',
    'st_troca',
    'ds_local_troca',
    'st_confirmacao_solicitante',
    'st_confirmacao_destinatario'
];

    /**
     * Usuário que enviou a proposta
     */
    public function solicitante(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_solicitante', 'id_usuario');
    }

    /**
     * Usuário que recebeu a proposta
     */
    public function destinatario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_destinatario', 'id_usuario');
    }

    /**
     * Itens da proposta
     */
    public function itens(): HasMany
    {
        return $this->hasMany(ItemProposta::class, 'id_proposta', 'id_proposta');
    }

    /**
     * Mensagens da proposta
     */
    public function mensagens(): HasMany
    {
        return $this->hasMany(Mensagem::class, 'id_proposta', 'id_proposta');
    }
}