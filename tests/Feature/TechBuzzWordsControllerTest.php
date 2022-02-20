<?php

namespace Tests\Feature;

use App\Models\TechBuzzWords;
use Database\Seeders\TechBuzzWordsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class TechBuzzWordsControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(TechBuzzWordsSeeder::class);
    }

    /**
     * Search existing tech name.
     *
     * @return void
     */
    public function test_search_existing_tech_name()
    {
        $techName = TechBuzzWords::query()->first('key')->key;
        $response = $this->get(route('techs.search', ['tech' => $techName]));
        $response->assertStatus(200);
        $responseJson = $response->decodeResponseJson()->json();
        $this->assertContains($techName, $responseJson);
    }

    public function test_search_inexisting_tech_name() {
        $randomInexistingTechName = Str::random(40);
        while(TechBuzzWords::query()->where('key', $randomInexistingTechName)->exists()) {
            $randomInexistingTechName = Str::random(40);
        };
        $response = $this->get(route('techs.search', ['tech' => $randomInexistingTechName]));
        $response->assertStatus(200);
        $responseJson = $response->decodeResponseJson()->json();
        $this->assertEmpty($responseJson);
    }

    public function test_search_ninja_name() {
        $techWords = TechBuzzWords::query()->inRandomOrder()->limit(3)->get();
        $response = $this->get(route('getName', ['x' => $techWords->pluck('key')->join(',')]));
        $response->assertStatus(200);
        $responseJson = $response->decodeResponseJson()->json();
        $this->assertArrayHasKey('name', $responseJson);
        $this->assertEquals($techWords->pluck('value')->join(' ') ,$responseJson['name']);
    }
}
