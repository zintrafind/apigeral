<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mensagem extends Model
{
    use HasFactory;

    /**
     * Nome da tabela
     */
    protected $table = 'tb_mensagem';

    /**
     * Chave primária
     */
    protected $primaryKey = 'id_mensagem';

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
        'id_proposta',
        'ds_mensagem',
        'ds_imagem',
    ];

    /**
     * Usuário que enviou a mensagem
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Proposta à qual a mensagem pertence
     */
    public function proposta(): BelongsTo
    {
        return $this->belongsTo(Proposta::class, 'id_proposta', 'id_proposta');
    }
}