<?php

namespace Database\Seeders;

use App\Models\Merk;
use Illuminate\Database\Seeder;

class MerkSeeder extends Seeder
{
    public function run(): void
    {
        $merks = [
            ['nama' => 'JESSEN-MERAUKE'],
            ['nama' => 'KARIN-MERAUKE'],
            ['nama' => 'DISCA-MERAUKE'],
            ['nama' => 'BMART-MERAUKE'],
        ];

        foreach ($merks as $merk) {
            Merk::firstOrCreate($merk);
        }
    }
}
