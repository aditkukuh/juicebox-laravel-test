<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\UpdateWeatherJob;

class DispatchWeatherJob extends Command
{
    protected $signature = 'weather:update';
    protected $description = 'Dispatches the UpdateWeatherJob to fetch current weather data';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        UpdateWeatherJob::dispatch();
        $this->info('Weather data update job dispatched.');
    }
}