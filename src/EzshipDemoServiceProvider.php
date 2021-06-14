<?php

namespace Hosomikai\Ezship;

use Illuminate\Support\ServiceProvider;

class EzshipDemoServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__ . '/../routes/web.php';

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'Kotsms');
    }
}
