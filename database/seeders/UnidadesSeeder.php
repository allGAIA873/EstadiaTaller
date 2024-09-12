<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class UnidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('unidad_negocio')->delete();
        $unidades = array(
            array('area' => 'iTRENDS'),
            array('area' => 'Area 59'),
        );


        DB::table('unidad_negocio')->insert($unidades);
    }
}