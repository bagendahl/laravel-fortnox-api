<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-02-19
 * Time: 20:19
 */

namespace Tarre\Fortnox;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Tarre\Fortnox\Api\AbsenceTransactions\AbsenceTransaction;
use Tarre\Fortnox\Api\AbsenceTransactions\FortnoxAbsenceTransaction;
use Tarre\Fortnox\Api\Articles\Article;
use Tarre\Fortnox\Api\Articles\FortnoxArticle;
use Tarre\Fortnox\Api\Customers\Customer;
use Tarre\Fortnox\Api\Customers\FortnoxCustomer;
use Tarre\Fortnox\Api\Invoices\FortnoxInvoice;
use Tarre\Fortnox\Api\Invoices\Invoice;
use Tarre\Fortnox\Api\Orders\FortnoxOrder;
use Tarre\Fortnox\Api\Orders\Order;
use Tarre\Fortnox\Api\PriceLists\FortnoxPriceList;
use Tarre\Fortnox\Api\PriceLists\PriceList;
use Tarre\Fortnox\Api\Prices\FortnoxPrice;
use Tarre\Fortnox\Api\Prices\Price;
use Tarre\Fortnox\Api\Suppliers\FortnoxSupplier;
use Tarre\Fortnox\Api\Suppliers\Supplier;
use Tarre\Fortnox\Api\TaxReductions\FortnoxTaxReduction;
use Tarre\Fortnox\Api\TaxReductions\TaxReduction;


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
        $this->app->singleton('command.fortnox.install', Console\AuthFortnoxToken::class);
        $this->app->singleton('command.fortnox.test', Console\TestConnection::class);
        $this->commands('command.fortnox.install');
        $this->commands('command.fortnox.test');

        // api
        $this->app->bind(FortnoxOrder::class, Order::class);
        $this->app->bind(FortnoxCustomer::class, Customer::class);
        $this->app->bind(FortnoxInvoice::class, Invoice::class);
        $this->app->bind(FortnoxArticle::class, Article::class);
        $this->app->bind(FortnoxSupplier::class, Supplier::class);
        $this->app->bind(FortnoxAbsenceTransaction::class, AbsenceTransaction::class);
        $this->app->bind(FortnoxPriceList::class, PriceList::class);
        $this->app->bind(FortnoxPrice::class, Price::class);
        $this->app->bind(FortnoxTaxReduction::class, TaxReduction::class);

    }

}
