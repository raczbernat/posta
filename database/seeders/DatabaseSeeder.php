<?php

namespace Database\Seeders;

use App\Models\Megye;
use App\Models\Telepules;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $adatok = [
            ['6000', 'Kecskemét', 'Bács-Kiskun'], ['7621', 'Pécs', 'Baranya'],
            ['5600', 'Békéscsaba', 'Békés'], ['3525', 'Miskolc', 'Borsod-Abaúj-Zemplén'],
            ['1011', 'Budapest', 'Budapest'], ['6720', 'Szeged', 'Csongrád-Csanád'],
            ['8000', 'Székesfehérvár', 'Fejér'], ['9021', 'Győr', 'Győr-Moson-Sopron'],
            ['4024', 'Debrecen', 'Hajdú-Bihar'], ['3300', 'Eger', 'Heves'],
            ['5000', 'Szolnok', 'Jász-Nagykun-Szolnok'], ['2500', 'Esztergom', 'Komárom-Esztergom'],
            ['3100', 'Salgótarján', 'Nógrád'], ['2000', 'Szentendre', 'Pest'],
            ['7400', 'Kaposvár', 'Somogy'], ['4400', 'Nyíregyháza', 'Szabolcs-Szatmár-Bereg'],
            ['7100', 'Szekszárd', 'Tolna'], ['9700', 'Szombathely', 'Vas'],
            ['8200', 'Veszprém', 'Veszprém'], ['8900', 'Zalaegerszeg', 'Zala'],
        ];

        foreach ($adatok as [$irsz, $nev, $megye]) {
            $m = Megye::firstOrCreate(['nev' => $megye]);
            Telepules::create(['irsz' => $irsz, 'nev' => $nev, 'megye_id' => $m->id]);
        }
    }
}
