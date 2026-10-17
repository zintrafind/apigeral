<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Avaliacao extends Model
{
    use HasFactory;

    protected $table = 'tb_avaliacao';
    protected $primaryKey = 'id_avaliacao';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'id_proposta',
        'id_avaliador',
        'id_avaliado',
        'id_usuario',
        'id_produto',
        'nr_nota',
        'ds_comentario',
    ];

    public function proposta(): BelongsTo
    {
        return $this->belongsTo(Proposta::class, 'id_proposta', 'id_proposta');
    }

    public function avaliador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_avaliador', 'id_usuario');
    }

    public function avaliado(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_avaliado', 'id_usuario');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }

    public function produto(): BelongsTo
    {
        return $this->belongsTo(Produto::class, 'id_produto', 'id_produto');
    }

    public function comentarios(): HasMany
    {
        return $this->hasMany(ComentarioAvaliacao::class, 'id_avaliacao', 'id_avaliacao');
    }
}