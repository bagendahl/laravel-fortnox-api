<?php

namespace Tarre\Fortnox\Console;


use Config;
use Illuminate\Console\Command;

class AuthFortnoxToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel-fortnox:auth {accessToken}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Oauth Access Token.';

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
     */
    public function handle()
    {
        if (!Config::has('laravel-fortnox')) {
            $this->error('Missing config\\laravel-fortnox.php. Please run php artisan vendor:publish');
            return;
        }

        // TODO kolla om man har access token



    }
}
