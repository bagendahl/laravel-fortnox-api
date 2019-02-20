<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-02-19
 * Time: 20:19
 */

namespace Tarre\Fortnox;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Tarre\Fortnox\Api\Orders\FortnoxOrder;
use Tarre\Fortnox\Api\Orders\Order;


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
        // console commands
        $this->app->singleton('command.make.repo', Console\AuthFortnoxToken::class);
        $this->commands('command.make.repo');

        // api
        $this->app->bind(FortnoxOrder::class, Order::class);

    }

}
