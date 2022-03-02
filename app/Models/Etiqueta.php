<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\GetTableNameStatically;

class Etiqueta extends Model
{
    use HasFactory, SoftDeletes, GetTableNameStatically;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre'
    ];

    /**
     * Get Etiquetas for search select
     *
     * @param string $search
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public static function getEtiquetas(string $search, int $limit = 30)
    {
        return self::select(['id', 'nombre'])
            ->where('nombre', 'LIKE', '%' . $search . '%')
            ->orderBy('nombre')
            ->take($limit)
            ->get();
    }
}
