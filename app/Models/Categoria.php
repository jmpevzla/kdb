<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\GetTableNameStatically;

class Categoria extends Model
{
    use HasFactory, SoftDeletes, GetTableNameStatically;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'descripcion'
    ];

    /**
     * Get Categorias for search select
     *
     * @param string $search
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public static function getCategorias(string $search, int $limit = 30)
    {
        return self::select(['id', 'nombre', 'descripcion'])
            ->where('nombre', 'LIKE', '%' . $search . '%')
            ->orWhere('descripcion', 'LIKE', '%' . $search . '%')
            ->orderBy('nombre')
            ->take($limit)
            ->get();
    }
}
