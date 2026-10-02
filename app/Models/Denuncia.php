<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Denuncia extends Model
{
    use HasFactory;

    protected $table = 'tb_denuncia';

    protected $primaryKey = 'id_denuncia';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'id_usuario',
        'id_usuario_denunciado',
        'id_produto',
        'ds_motivo',
        'ds_denuncia',
        'st_denuncia',
    ];

    // Usuário que enviou a denúncia.
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'id_usuario',
            'id_usuario'
        );
    }

    // Usuário que foi denunciado.
    public function denunciado(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'id_usuario_denunciado',
            'id_usuario'
        );
    }

    // Mantém a relação existente para denúncias de produtos.
    public function produto(): BelongsTo
    {
        return $this->belongsTo(
            Produto::class,
            'id_produto',
            'id_produto'
        );
    }
}