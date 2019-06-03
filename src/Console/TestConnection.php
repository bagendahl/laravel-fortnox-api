<?php
/**
 * Created by PhpStorm.
 * User: Tarre
 * Date: 2019-02-23
 * Time: 01:27
 */

namespace Tarre\Fortnox\Console;


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
    protected $signature = 'fortnox:test';

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
        $this->info('Testing integration (This may take a while)');

        $messages = [];

        if (!\Config::has('laravel-fortnox')) {
            $messages[] = 'Configuration is missing. Publish the configuration';
        }

        if (!$fp = @fsockopen(gethostbyname('api.fortnox.se'), 443, $errno, $errStr, 5)) {
            $messages[] = 'Failed to establish HTTPS to the endpoint: ' . $errStr;
        } else {
            fclose($fp);
        }

        // Check that the rate limit IS OK
        try {
            $fortnoxCustomer->take(1)->get()
                ->each(function ($row) use ($fortnoxCustomer) {
                    for ($i = 1; $i <= (\Config::get('laravel-fortnox.rate_limit_burst') * 6); $i++) {
                        $fortnoxCustomer->getByDocumentNumber($row['CustomerNumber']);
                    }
                });
        } catch (\Exception $exception) {
            $messages[] = sprintf($exception->getMessage());
        }

        if (count($messages) > 0) {
            $this->error('Something went wrong');
            foreach ($messages as $key => $message) {
                $this->warn('#' . ($key + 1) . ' => ' . $message);
            }
        } else {
            $this->info('Everything is ok!');
        }

    }


}
