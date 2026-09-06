<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    protected $guarded = ['id'];

    public function suratJalans()
    {
        return $this->hasMany(SuratJalan::class);
    }

    public function details()
    {
        return $this->hasMany(FolderDetail::class);
    }

    public static function getNama(): string
    {
        $prefix = now()->format('M-d-Y');

        return $prefix;
    }
}
