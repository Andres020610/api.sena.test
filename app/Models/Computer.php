<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Computer extends Model
{
    protected $fillable = ['number', 'brand'];

    public function apprentices()
    {
        return $this->hasMany(Apprentice::class);
    }
}
