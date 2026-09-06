<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratJalanItem extends Model
{
    protected $guarded = ['id'];

    public function suratJalan()
    {
        return $this->belongsTo(SuratJalan::class);
    }
}
