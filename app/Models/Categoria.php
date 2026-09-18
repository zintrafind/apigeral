<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    use HasFactory;

    /**
     * Nome da tabela
     */
    protected $table = 'tb_categoria';

    /**
     * Chave primária
     */
    protected $primaryKey = 'id_categoria';

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
        'nm_categoria',
        'ds_categoria'
    ];

    /**
     * Produtos da categoria
     */
public function produtos(): HasMany
{
    return $this->hasMany(Product::class, 'id_categoria', 'id_categoria');
}
}