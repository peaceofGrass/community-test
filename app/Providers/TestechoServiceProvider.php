<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Test\Testechoservice;

class TestechoServiceProvider extends ServiceProvider
{
    public function register() {
        $this->app->singleton('testecho', function() {
            return new Testechoservice();
        });
    }
}