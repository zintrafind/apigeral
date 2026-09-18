<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemProposta extends Model
{
    use HasFactory;

    protected $table = 'tb_item_proposta';
    protected $primaryKey = 'id_item_proposta';

    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'id_proposta',
        'id_produto',
        'tp_item'
    ];

    public function proposta(): BelongsTo
    {
        return $this->belongsTo(
            Proposta::class,
            'id_proposta',
            'id_proposta'
        );
    }

    public function produto(): BelongsTo
    {
        return $this->belongsTo(
            Product::class,
            'id_produto',
            'id_produto'
        );
    }
}