<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemProposta extends Model
{
    use HasFactory;

    /**
     * Nome da tabela
     */
    protected $table = 'tb_item_proposta';

    /**
     * Chave primária
     */
    protected $primaryKey = 'id_item_proposta';

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
        'id_proposta',
        'id_produto',
        'tp_item'
    ];

    /**
     * Proposta à qual o item pertence
     */
    public function proposta(): BelongsTo
    {
        return $this->belongsTo(Proposta::class, 'id_proposta', 'id_proposta');
    }

    /**
     * Produto da proposta
     */
 public function produto(): BelongsTo
{
    return $this->belongsTo(
        Product::class,
        'id_produto',
        'id_produto'
    );
}
}