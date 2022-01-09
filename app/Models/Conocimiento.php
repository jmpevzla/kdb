<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\GetTableNameStatically;

class Conocimiento extends Model
{
    use HasFactory, SoftDeletes, GetTableNameStatically;

    protected $with = ['tipo:id,nombre'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'descripcion',
        'tipo_id',
        'contenido',
        'fecha_informacion'
    ];

    /**
     * Relationship One-One Tipos-Links
     * @return App\Models\Tipo
     */
    public function tipo() {
        return $this->hasOne(Tipo::class, 'id', 'tipo_id');
    }
}
