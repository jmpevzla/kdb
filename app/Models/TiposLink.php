<?php

namespace App\Models;

use App\Models\Traits\GetTableNameStatically;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TiposLink extends Model
{
    use HasFactory, SoftDeletes, GetTableNameStatically;

    protected $table = 'tipos-links';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'descripcion',
    ];
}
