<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoricoInteracao extends Model
{
    use HasFactory;

    /**
     * Nome da tabela
     */
    protected $table = 'tb_historico_interacao';

    /**
     * Chave primária
     */
    protected $primaryKey = 'id_historico';

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
        'id_usuario',
        'id_produto',
        'tp_interacao'
    ];

    /**
     * Usuário que realizou a interação
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Produto relacionado à interação
     */
    public function produto(): BelongsTo
    {
        return $this->belongsTo(Produto::class, 'id_produto', 'id_produto');
    }
}