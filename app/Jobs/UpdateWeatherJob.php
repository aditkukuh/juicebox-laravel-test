<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class UpdateWeatherJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $response = Http::get('http://api.weatherapi.com/v1/current.json', [
            'key' => env('WEATHER_APP_KEY'),
            'q' => 'Perth',
            'aqi' => 'no',
        ]);

        if ($response->successful()) {
            Cache::put('weather_data', $response->json(), now()->addMinutes(15));
        } else {
            \Log::error('Gagal mengambil data cuaca dari API');
        }
    }
}