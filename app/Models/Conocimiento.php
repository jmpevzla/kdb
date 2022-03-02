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
     */
    public function tipo() {
        return $this->hasOne(Tipo::class, 'id', 'tipo_id');
    }

    /**
     * Relationship ManyToMany Categorias
     */
    public function categorias() {
        return $this->belongsToMany(Categoria::class, 'categorias_conocimientos', 'conocimiento_id', 'categoria_id');
    }

    /**
     * Relationship ManyToMany Etiquetas
     */
    public function etiquetas() {
        return $this->belongsToMany(Etiqueta::class, 'etiquetas_conocimientos', 'conocimiento_id', 'etiqueta_id');
    }
}
