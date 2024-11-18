<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('WEATHER_APP_KEY');
    }

    public function fetchWeatherData(string $location)
    {
        try {
            $response = Http::get('http://api.weatherapi.com/v1/current.json', [
                'key' => $this->apiKey,
                'q' => $location,
                'aqi' => 'no',
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Failed to fetch weather data', ['response' => $response->body()]);
            return null;
        } catch (\Exception $e) {
            Log::error('Error fetching weather data', ['error' => $e->getMessage()]);
            return null;
        }
    }
}
