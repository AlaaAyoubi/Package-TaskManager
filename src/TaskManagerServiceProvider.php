<?php

namespace Alaa\TaskManager;

use Illuminate\Support\ServiceProvider;

class TaskManagerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     */
    public function boot()
    {
        // Load package routes
        $this->loadRoutesFrom(__DIR__.'/Routes/web.php');

        // Load package views (namespace: taskmanager)
        $this->loadViewsFrom(__DIR__.'/Views', 'taskmanager');

        // Load package migrations
        $this->loadMigrationsFrom(__DIR__.'/Migrations');
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        //
    }
} 