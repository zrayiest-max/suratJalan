<?php

namespace Database\Seeders;

use App\Models\Penerima;
use Illuminate\Database\Seeder;

class PenerimaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $penerimas = [
            ['nama' => 'Exp Sejahtera Tirta Mas', 'alamat' => 'Lorong 5 (Depo Spil Japfa) Jl. Laksda Moh. Nazir No.17, Perak Bar., Kec. Krembangan, Surabaya, Jawa Timur 60177, SURABAYA'],
            ['nama' => 'SRK Wahyudi (Mustafa CP Merauke)', 'alamat' => 'd/a. Kantor Perwakilan Kodam XVII/Cenderawasih, Jalan Mandala V No. 434 Desa Semambung Kec. Gedangan Kab. Sidoarjo.'],
            ['nama' => 'Lion Parcel', 'alamat' => 'Jl. Sutorejo Prima Utara No.PDD-9, Kalisari, Kec. Mulyorejo, Surabaya, Jawa Timur 60113'],
        ];

        foreach ($penerimas as $penerima) {
            Penerima::firstOrCreate([
                'nama' => $penerima['nama'],
                'alamat' => $penerima['alamat'],
            ]);
        }
    }
}
