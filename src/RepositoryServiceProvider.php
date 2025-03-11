<?php

namespace Zentnova\Repository;

use Illuminate\Support\ServiceProvider;
use Zentnova\Repository\Console\MakeRepositoryCommand;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        // ลงทะเบียน Artisan Command
        $this->commands([
            MakeRepositoryCommand::class,
        ]);

        // Publish stubs
        $this->publishes([
            __DIR__ . '/../stubs/' => base_path('stubs/zentnova-repository'),
        ], 'repository-stubs');
    }

    public function boot()
    {
        //
    }
}
