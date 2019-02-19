<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-02-19
 * Time: 20:19
 */

namespace Tarre\Fortnox;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;


class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'laravel-fortnox.php' => config_path('laravel-fortnox.php'),
        ], 'laravel-fortnox');


    }

    public function register()
    {
        $this->app->singleton('command.make.repo', Console\AuthFortnoxToken::class);
        $this->commands('command.make.repo');

    }

}
