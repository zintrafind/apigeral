<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ImagemProduto;
use App\Models\Categoria;

class Product extends Model
{
    use HasFactory;

    // Nome exato da tabela no MySQL
    protected $table = 'tb_produto';

    // Chave primária
    protected $primaryKey = 'id_produto';

    // Campos autorizados para gravação
    protected $fillable = [
        'id_usuario',
        'id_categoria',
        'nm_produto',
        'ds_produto',
        'st_condicao',
        'st_status',
    ];

    /**
     * Produto pertence a um Usuário
     */
    public function user()
    {
        return $this->belongsTo(
            User::class,
            'id_usuario',
            'id_usuario'
        );
    }

    /**
     * Produto possui várias Imagens
     */
    public function images()
    {
        return $this->hasMany(
            ImagemProduto::class,
            'id_produto',
            'id_produto'
        )->orderBy('nr_ordem');
    }

    /**
     * Produto pertence a uma Categoria
     */
    public function categoria()
    {
        return $this->belongsTo(
            Categoria::class,
            'id_categoria',
            'id_categoria'
        );
    }
}