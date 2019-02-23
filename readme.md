## Laravel 5 Fortnox API Repository

### Install



First install the package
```bash
composer require tarre/laravel-fortnox-api
```

**Only do this if you are below laravel 5.5** add `Tarre\Fortnox\ServiceProvider::class` provider to the `providers` array in `config/app.php`


### Example usage in controller.

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
