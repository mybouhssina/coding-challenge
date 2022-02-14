<?php

namespace Database\Seeders;

use App\Models\TechBuzzWords;
use Illuminate\Database\Seeder;

class TechBuzzWordsSeeder extends Seeder
{
    const NAME_BY_TECH = [
        'sass' => 'Crimson',
        'rails' => 'Drop',
        'html' => 'Shadow',
        'php' => 'Prestissimo',
        'cms' => 'WordPress',
        'http' => 'Guzzle',
        'email' => 'Mautic',
        'security' => 'zap',
        'queue' => 'Thumper'
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(self::NAME_BY_TECH as $tech => $name) {
            TechBuzzWords::query()->create([
                'key' => $tech,
                'value' => $name
            ]);
        }
    }
}
