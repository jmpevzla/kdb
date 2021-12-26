<?php

namespace App\Models\Traits;

trait GetTableNameStatically
{
    public static function tableName()
    {
        return with(new static)->getTable();
    }
}
