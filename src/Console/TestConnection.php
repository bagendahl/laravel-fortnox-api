<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-02-23
 * Time: 01:27
 */

namespace Tarre\Fortnox\Console;


use Config;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Tarre\Fortnox\Api\Customers\FortnoxCustomer;

class TestConnection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fortnox:test {seconds=60}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if everything is in order.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws GuzzleException
     */
    public function handle(FortnoxCustomer $fortnoxCustomer)
    {

        $this->info('[x] Checking config');

        $messages = [];

        if (!Config::has('laravel-fortnox')) {
            $messages[] = 'Configuration is missing. Publish the configuration "php artisan vendor:publish --tag="laravel-fortnox"';
        }else{
            $this->info('[x] Config ok!');
        }

        $this->info('[x] Testing API connection');
        if (!$fp = @fsockopen(gethostbyname('api.fortnox.se'), 443, $errno, $errStr, 5)) {
            $messages[] = 'Failed to establish HTTPS to the endpoint: ' . $errStr;
        } else {
            $this->info('[x] API connection ok!');
            fclose($fp);
        }

        // Check that the rate limit IS OK
        $numRequests = 0;
        $now = now();
        $nArgSeconds = intval($this->argument('seconds'));

        $this->info(sprintf('[x] Testing rate limit (This will take at least %d seconds)', $nArgSeconds));

        while ($now->diffInSeconds() < $nArgSeconds) {
            try {
                $fortnoxCustomer->take(10)->get()
                    ->each(function ($row) use ($fortnoxCustomer, &$numRequests) {
                        $numRequests++;
                        $fortnoxCustomer->getByDocumentNumber($row['CustomerNumber']);
                    });
            } catch (Exception $exception) {
                $messages[] = sprintf($exception->getMessage());
            }
        }

        $rps = round($numRequests / $now->diffInSeconds(), 2);
        $this->info('[x] Rate limit results:');
        $this->info(sprintf('%d requests made in %d seconds. %s RPS',
            $numRequests,
            $now->diffInSeconds(),
            $rps));

        if (count($messages) > 0) {
            $this->error(sprintf('%d error messages', count($messages)));
            foreach ($messages as $key => $message) {
                $this->warn('#' . ($key + 1) . ' => ' . $message);
            }
        }

    }


}
