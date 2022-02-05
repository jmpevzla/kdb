<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\GetTableNameStatically;

class Link extends Model
{
    use HasFactory, SoftDeletes, GetTableNameStatically;

    protected $with = ['tiposLink:id,descripcion'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'descripcion',
        'link',
        'tipo-link_id'
    ];

    /**
     * Relationship One-One Tipos-Links
     * @return App\Models\TiposLink
     */
    public function tiposLink() {
        return $this->hasOne(TiposLink::class, 'id', 'tipo-link_id');
    }

    /**
     * Get Links for search select
     *
     * @param string $search
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public static function getLinks(string $search, int $limit = 30)
    {
        return self::select(['id', 'descripcion', 'link'])
            ->where('descripcion', 'LIKE', '%' . $search . '%')
            ->orWhere('link', 'LIKE', '%' . $search . '%')
            ->orderBy('descripcion')
            ->take($limit)
            ->get();
    }
}
