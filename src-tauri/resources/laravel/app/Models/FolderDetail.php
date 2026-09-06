<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FolderDetail extends Model
{
    protected $guarded = ['id'];

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

    public function suratJalan()
    {
        return $this->belongsTo(SuratJalan::class);
    }
}
