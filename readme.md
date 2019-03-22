## Laravel 5 Fortnox API Repository

* Type-hint support.
* Laravel-mindset when building

### Installation

1. First install the package `composer require tarre/laravel-fortnox-api`
2. **if you are below laravel 5.5** add `Tarre\Fortnox\ServiceProvider::class` provider to the `providers` array in `config/app.php`
3. run `php artisan fortnox:install` and follow the instructions. 
4. run `php artisan fortnox:test` to check if everything is OK



### Usage

You can access them via the `app()` helper. `$FortnoxOrder = app()->make(Tarre\Fortnox\Api\Orders\FortnoxOrder::class);`

Or thru methods that support type-hints, in controllers for example
 
**OrderController.php**
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tarre\Fortnox\Api\Orders\FortnoxOrder;

/**
 * @property FortnoxOrder fortnoxOrder
 */
class OrderController extends Controller
{
    public function __construct(FortnoxOrder $fortnoxOrder)
    {
        $this->fortnoxOrder = $fortnoxOrder;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function index()
    {
        return $this->fortnoxOrder->get();
    }

    /**
     * @param $documentNumber
     * @return \Illuminate\Support\Collection
     */
    public function show($documentNumber)
    {
        return $this->fortnoxOrder->getByDocumentNumber($documentNumber);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    public function store(Request $request)
    {
        return $this->fortnoxOrder->store($request->toArray());
    }

    /**
     * @param $documentNumber
     * @return \Illuminate\Http\Response
     */
    public function previewPdf($documentNumber)
    {
        return $this->fortnoxOrder->preview($documentNumber)->toResponse();
    }

    /**
     * @param $documentNumber
     * @return \Illuminate\Http\Response
     */
    public function downloadPdf($documentNumber)
    {
        return $this->fortnoxOrder->preview($documentNumber)->download('Order.pdf');
    }
}
```
Every API repository implements this interface
```php
interface BaseApiRepository
{
    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function setQueryKey($key, $value);

    /**
     * It’s possible to filter the results so that only specific items will be returned. The available filters is listed under the section “Filters” in the documentation for each resource.
     * @param $key
     * @return mixed
     */
    public function filter($key);

    /**
     * @param $number
     * @return $this
     */
    public function take($number);
    /**
     * Because of performance reasons both on our side and on yours, we encourage you to use the parameter limit as much as possible. This method correspond to they key "Limit"
     * @param $number
     * @return $this
     */
    public function skip($number);
    /**
     * Because of performance reasons both on our side and on yours, we encourage you to use the parameter limit as much as possible. This method correspond to they key "Offset"
     * @param $number
     * @return $this
     */
    public function page($number);
    /**
     * A result can be sorted, either ascending or descending, by specific fields. These fields are listed in the table under the section “Fields” in the documentation for each resource.
     * @param string $column
     * @param string $sortOrder
     * @return $this
     */
    public function sortBy(string $column, $sortOrder = 'ascending');
    /**
     * @param string $column
     * @param string $sortOrder
     * @return $this
     */
    public function orderBy(string $column, $sortOrder = 'ascending');
    
}
```
Which can be used to query your requests

```php
$FortnoxOrder = app()->make(Tarre\Fortnox\Api\Orders\FortnoxOrder::class);
$results = $FortnoxOrder->take(1)->skip(10)->orderBy('date')->get();
dd($results);
```

##### Available Repositories

```PHP
Tarre\Fortnox\Api\Orders\FortnoxOrder
```
```PHP
Tarre\Fortnox\Api\Invoices\FortnoxInvoice
```
```PHP
Tarre\Fortnox\Api\Customers\FortnoxCustomer
```
```PHP
Tarre\Fortnox\Api\Suppliers\FortnoxSupplier
```

```PHP
Tarre\Fortnox\Api\Articles\FortnoxArticle
```
```PHP
Tarre\Fortnox\Api\PriceLists\FortnoxPriceList
```








