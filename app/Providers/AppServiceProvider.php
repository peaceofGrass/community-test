<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

use Laravel\Scout\EngineManager;
use ScoutEngines\Elasticsearch\ElasticsearchEngine;
use Elasticsearch\ClientBuilder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(100);

        // 公共专题部分
        \View::composer('layout.sidebar', function($view) {
            $topics = \App\Topic::all();
            $view->with('topics', $topics);
        });

//        resolve(EngineManager::class)->extend('elasticsearch', function () {
//            return new ElasticsearchEngine(ClientBuilder::fromConfig(config('scout.elasticsearch.config')), config('scout.elasticsearch.index'));
//        });

        \DB::listen(function($query){
            $sql = $query->sql;
            $bindings = $query->bindings;
            $time = $query->time;

            if ($time > 2) {
                \Log::debug(var_export(compact('sql', 'bindings', 'time'), true));
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
