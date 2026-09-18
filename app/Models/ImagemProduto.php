<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImagemProduto extends Model
{
    use HasFactory;

    /**
     * Nome da tabela
     */
    protected $table = 'tb_imagem_produto';

    /**
     * Chave primária
     */
    protected $primaryKey = 'id_imagem';

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
        'id_produto',
        'ds_imagem',
        'nr_ordem'
    ];

    /**
     * Produto ao qual a imagem pertence
     */
    public function produto(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'id_produto', 'id_produto');
    }
}
