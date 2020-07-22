<?php

namespace Tarre\Fortnox\Console;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;

class CheckVersion extends Command
{
    CONST version = '1.9.0';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fortnox:version';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check version.';

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
    public function handle()
    {
        $this->info('Laravel fortnox ' . self::version);

    }

    /**
     * @param $AuthorizationCode
     * @throws GuzzleException
     */

}
