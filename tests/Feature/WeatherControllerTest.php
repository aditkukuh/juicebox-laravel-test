<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Mockery\MockInterface;
use App\Services\WeatherService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WeatherControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    /** @test */
    public function it_returns_weather_data_when_cached()
    {
        $WeatherService = \Mockery::mock(WeatherService::class, function(MockInterface $mock){
            $mock->shouldReceive('fetchWeatherData')->andReturn([]);
        });  

        Cache::put('weather_data', $WeatherService);

        $response = $this->getJson(route('weather.getCurrentWeather'));

        $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'data' => [],
            'message' => 'Current weather data retrieved successfully.'
        ]);
    }
}
