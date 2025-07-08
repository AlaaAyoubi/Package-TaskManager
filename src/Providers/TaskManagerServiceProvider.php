<?php

namespace Alaa\TaskManager\Providers;

use Illuminate\Support\ServiceProvider;

class TaskManagerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     */
    public function boot()
    {
        // Load package routes
        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');

        // Load package views (namespace: taskmanager)
        $this->loadViewsFrom(__DIR__.'/../Views', 'taskmanager');

        // Load package migrations
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');

        // Load translations (namespace: taskmanager)
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'taskmanager');

        // Merge config
        $this->mergeConfigFrom(__DIR__.'/../Config/taskmanager.php', 'taskmanager');

        // Publishing config
        $this->publishes([
            __DIR__.'/../Config/taskmanager.php' => config_path('taskmanager.php'),
        ], 'taskmanager-config');

        // Publishing translations
        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/taskmanager'),
        ], 'taskmanager-lang');

        // Publishing views
        $this->publishes([
            __DIR__.'/../Views' => resource_path('views/vendor/taskmanager'),
        ], 'taskmanager-views');

        // Publishing migrations
        $this->publishes([
            __DIR__.'/../Database/Migrations' => database_path('migrations'),
        ], 'taskmanager-migrations');

        // Publishing Vue assets (if any)
        $this->publishes([
            __DIR__.'/../Assets/js/components' => resource_path('js/components/taskmanager'),
        ], 'taskmanager-vue');

        // Publishing seeders
        $this->publishes([
            __DIR__.'/../Database/Seeders' => database_path('seeders/vendor/taskmanager'),
        ], 'taskmanager-seeders');
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        //
    }
} 