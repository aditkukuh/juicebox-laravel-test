<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
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

        $weatherData = [
            [
                "location" => [
                    "name" => "Perth",
                    "region" => "Western Australia",
                    "country" => "Australia",
                    "lat" => -31.9333,
                    "lon" => 115.8333,
                    "tz_id" => "Australia/Perth",
                    "localtime_epoch" => 1731918243,
                    "localtime" => "2024-11-18 16:24"
                ],
                "current" => [
                    "last_updated_epoch" => 1731917700,
                    "last_updated" => "2024-11-18 16:15",
                    "temp_c" => 29.3,
                    "temp_f" => 84.7,
                    "is_day" => 1,
                    "condition" => [
                        "text" => "Sunny",
                        "icon" => "//cdn.weatherapi.com/weather/64x64/day/113.png",
                        "code" => 1000
                    ],
                    "wind_mph" => 10.5,
                    "wind_kph" => 16.9,
                    "wind_degree" => 148,
                    "wind_dir" => "SSE",
                    "pressure_mb" => 1010.0,
                    "pressure_in" => 29.82,
                    "precip_mm" => 0.0,
                    "precip_in" => 0.0,
                    "humidity" => 32,
                    "cloud" => 22,
                    "feelslike_c" => 28.4,
                    "feelslike_f" => 83.1,
                    "windchill_c" => 29.3,
                    "windchill_f" => 84.7,
                    "heatindex_c" => 28.4,
                    "heatindex_f" => 83.1,
                    "dewpoint_c" => 11.0,
                    "dewpoint_f" => 51.8,
                    "vis_km" => 10.0,
                    "vis_miles" => 6.0,
                    "uv" => 3.4,
                    "gust_mph" => 16.9,
                    "gust_kph" => 27.3
                ]
            ]
        ];        

        Cache::put('weather_data', $weatherData);

        $response = $this->getJson(route('weather.getCurrentWeather'));

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'data' => $weatherData, 
                     'message' => 'Current weather data retrieved successfully.'
                 ]);
    }
}
