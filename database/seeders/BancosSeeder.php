<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class BancosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bancos')->delete();
        $bancos = array(
            ['clave' => '002', 'nombre' => 'BANAMEX'],
            ['clave' => '006', 'nombre' => 'BANCOMEXT'],
            ['clave' => '009', 'nombre' => 'BANOBRAS'],
            ['clave' => '012', 'nombre' => 'BBVA BANCOMER'],
            ['clave' => '014', 'nombre' => 'SANTANDER'],
            ['clave' => '019', 'nombre' => 'BANJERCITO'],
            ['clave' => '021', 'nombre' => 'HSBC'],
            ['clave' => '030', 'nombre' => 'BAJIO'],
            ['clave' => '032', 'nombre' => 'IXE'],
            ['clave' => '036', 'nombre' => 'INBURSA'],
            ['clave' => '037', 'nombre' => 'INTERACCIONES'],
            ['clave' => '042', 'nombre' => 'MIFEL'],
            ['clave' => '044', 'nombre' => 'SCOTIABANK'],
            ['clave' => '058', 'nombre' => 'BANREGIO'],
            ['clave' => '059', 'nombre' => 'INVEX'],
            ['clave' => '060', 'nombre' => 'BANSI'],
            ['clave' => '062', 'nombre' => 'AFIRME'],
            ['clave' => '072', 'nombre' => 'BANORTE'],
            ['clave' => '102', 'nombre' => 'THE ROYAL BANK'],
            ['clave' => '103', 'nombre' => 'AMERICAN EXPRESS'],
            ['clave' => '106', 'nombre' => 'BAMSA'],
            ['clave' => '108', 'nombre' => 'TOKYO'],
            ['clave' => '110', 'nombre' => 'JP MORGAN'],
            ['clave' => '112', 'nombre' => 'BMONEX'],
            ['clave' => '113', 'nombre' => 'VE POR MAS'],
            ['clave' => '116', 'nombre' => 'ING'],
            ['clave' => '124', 'nombre' => 'DEUTSCHE'],
            ['clave' => '126', 'nombre' => 'CREDIT SUISSE'],
            ['clave' => '127', 'nombre' => 'AZTECA'],
            ['clave' => '128', 'nombre' => 'AUTOFIN'],
            ['clave' => '129', 'nombre' => 'BARCLAYS'],
            ['clave' => '130', 'nombre' => 'COMPARTAMOS'],
            ['clave' => '131', 'nombre' => 'BANCO FAMSA'],
            ['clave' => '132', 'nombre' => 'BMULTIVA'],
            ['clave' => '133', 'nombre' => 'ACTINVER'],
            ['clave' => '134', 'nombre' => 'WAL-MART'],
            ['clave' => '135', 'nombre' => 'NAFIN'],
            ['clave' => '136', 'nombre' => 'INTERBANCO'],
            ['clave' => '137', 'nombre' => 'BANCOPPEL'],
            ['clave' => '138', 'nombre' => 'ABC CAPITAL'],
            ['clave' => '139', 'nombre' => 'UBS BANK'],
            ['clave' => '140', 'nombre' => 'CONSUBANCO'],
            ['clave' => '141', 'nombre' => 'VOLKSWAGEN'],
            ['clave' => '143', 'nombre' => 'CIBANCO'],
            ['clave' => '145', 'nombre' => 'BBASE'],
            ['clave' => '166', 'nombre' => 'BANSEFI'],
            ['clave' => '168', 'nombre' => 'HIPOTECARIA FEDERAL'],
            ['clave' => '600', 'nombre' => 'MONEXCB'],
            ['clave' => '601', 'nombre' => 'GBM'],
            ['clave' => '602', 'nombre' => 'MASARI'],
            ['clave' => '605', 'nombre' => 'VALUE'],
            ['clave' => '606', 'nombre' => 'ESTRUCTURADORES'],
            ['clave' => '607', 'nombre' => 'TIBER'],
            ['clave' => '608', 'nombre' => 'VECTOR'],
            ['clave' => '610', 'nombre' => 'B&B'],
            ['clave' => '614', 'nombre' => 'ACCIVAL'],
            ['clave' => '615', 'nombre' => 'MERRILL LYNCH'],
            ['clave' => '616', 'nombre' => 'FINAMEX'],
            ['clave' => '617', 'nombre' => 'VALMEX'],
            ['clave' => '618', 'nombre' => 'UNICA'],
            ['clave' => '619', 'nombre' => 'MAPFRE'],
            ['clave' => '620', 'nombre' => 'PROFUTURO'],
            ['clave' => '621', 'nombre' => 'CB ACTINVER'],
            ['clave' => '622', 'nombre' => 'OACTIN'],
            ['clave' => '623', 'nombre' => 'SKANDIA'],
            ['clave' => '626', 'nombre' => 'CBDEUTSCHE'],
            ['clave' => '627', 'nombre' => 'ZURICH'],
            ['clave' => '628', 'nombre' => 'ZURICHVI'],
            ['clave' => '629', 'nombre' => 'SU CASITA'],
            ['clave' => '630', 'nombre' => 'CB INTERCAM'],
            ['clave' => '631', 'nombre' => 'CI BOLSA'],
            ['clave' => '632', 'nombre' => 'BULLTICK CB'],
            ['clave' => '633', 'nombre' => 'STERLING'],
            ['clave' => '634', 'nombre' => 'FINCOMUN'],
            ['clave' => '636', 'nombre' => 'HDI SEGUROS'],
            ['clave' => '637', 'nombre' => 'ORDER'],
            ['clave' => '638', 'nombre' => 'AKALA'],
            ['clave' => '640', 'nombre' => 'CB JPMORGAN'],
            ['clave' => '642', 'nombre' => 'REFORMA'],
            ['clave' => '646', 'nombre' => 'STP'],
            ['clave' => '647', 'nombre' => 'TELECOMM'],
            ['clave' => '648', 'nombre' => 'EVERCORE'],
            ['clave' => '649', 'nombre' => 'SKANDIA'],
            ['clave' => '651', 'nombre' => 'SEGMTY'],
            ['clave' => '652', 'nombre' => 'ASEA'],
            ['clave' => '653', 'nombre' => 'KUSPIT'],
            ['clave' => '655', 'nombre' => 'SOFIEXPRESS'],
            ['clave' => '656', 'nombre' => 'UNAGRA'],
            ['clave' => '659', 'nombre' => 'OPCIONES EMPRESARIALES DEL NOROESTE'],
            ['clave' => '901', 'nombre' => 'CLS'],
            ['clave' => '902', 'nombre' => 'INDEVAL'],
            ['clave' => '670', 'nombre' => 'LIBERTAD'],
        );

        DB::table('bancos')->insert($bancos);
    }
}
