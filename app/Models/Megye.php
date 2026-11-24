<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Megye extends Model
{
    protected $table = 'megyek';
    public $timestamps = false;
    protected $fillable = ['nev'];

    public function telepulesek()
    {
        return $this->hasMany(Telepules::class);
    }
}
