<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Merk extends Model
{
    protected $guarded = ['id'];

    public function suratJalans()
    {
        return $this->hasMany(SuratJalan::class);
    }
}
