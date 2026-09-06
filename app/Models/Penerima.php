<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penerima extends Model
{
    protected $guarded = ['id'];

    public function suratJalans()
    {
        return $this->hasMany(SuratJalan::class);
    }
}
