<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use App\Services\WeatherService;

class UpdateWeatherJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $weatherService;

    public function __construct()
    {
        $this->weatherService = new WeatherService();
    }

    public function handle()
    {
        $weatherData = $this->weatherService->fetchWeatherData('Perth');

        if ($weatherData) {
            Cache::put('weather_data', $weatherData, now()->addMinutes(15));

            // Dispatch a new job to run after 1 hour
            dispatch(new self())->delay(now()->addMinutes(60));
        } else {
            \Log::error('Failed to update weather data');
        }
    }
}