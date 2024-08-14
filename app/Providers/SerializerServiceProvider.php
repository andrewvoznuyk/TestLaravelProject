<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;

class SerializerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(SerializerInterface::class, function ($app) {
            return SerializerBuilder::create()->build();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
