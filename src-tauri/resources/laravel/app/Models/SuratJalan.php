<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SuratJalan extends Model
{
    protected $guarded = ['id'];

    public function merk(): BelongsTo
    {
        return $this->belongsTo(Merk::class);
    }

    public function penerima(): BelongsTo
    {
        return $this->belongsTo(Penerima::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(SuratJalanItem::class);
    }

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

    public function folderDetails()
    {
        return $this->hasMany(FolderDetail::class);
    }

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    public static function generateNomorSuratJalan(): string
    {
        $prefix = 'SJ-'.now()->format('Ym');

        $suratTerakhir = self::where('no_surat', 'like', $prefix.'-%')
            ->orderByDesc('no_surat')
            ->first();

        if ($suratTerakhir) {
            $nomorTerakhir = (int) substr($suratTerakhir->no_surat, -4);
            $nomorUrut = $nomorTerakhir + 1;
        } else {
            $nomorUrut = 1;
        }

        return $prefix.'-'.str_pad($nomorUrut, 4, '0', STR_PAD_LEFT);
    }
}
