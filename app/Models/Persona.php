<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\GetTableNameStatically;

class Persona extends Model
{
    use HasFactory, SoftDeletes, GetTableNameStatically;

    protected $with = [
        'apodos:id,apodo,persona_id',
        'links:id,descripcion,link'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'bio'
    ];

    public function apodos() {
        return $this->hasMany(Apodo::class, 'persona_id', 'id');
    }

    public function links() {
        return $this->belongsToMany(Link::class, 'personas_links', 'persona_id', 'link_id');
    }
}
