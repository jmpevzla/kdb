<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\GetTableNameStatically;

class Medio extends Model
{
    use HasFactory, SoftDeletes, GetTableNameStatically;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'bio'
    ];

    public function links() {
        return $this->belongsToMany(Link::class, 'medios_links', 'medio_id', 'link_id');
    }
}
