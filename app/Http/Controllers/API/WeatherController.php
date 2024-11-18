<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\API\BaseController;

class WeatherController extends BaseController
{
    public function getCurrentWeather()
    {
        $weatherData = Cache::get('weather_data');

        if (!$weatherData) {
            return $this->sendError('Weather data is not available.', 404);
        }

        return $this->sendResponse($weatherData, 'Current weather data retrieved successfully.');
    }
}
