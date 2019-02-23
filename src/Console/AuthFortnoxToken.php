<?php

namespace Tarre\Fortnox\Console;

use Config;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;

class AuthFortnoxToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fortnox:install';

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
     * @throws GuzzleException
     */
    public function handle()
    {
        $this->comment('');
        $this->comment('This guide will help you get started with Fortnox API');
        if (!Config::has('laravel-fortnox')) {
            $this->error('Missing config' . DIRECTORY_SEPARATOR . 'laravel-fortnox.php. Please publish the config');

            if ($this->confirm('Do you want to run "php artisan vendor:publish --tag=laravel-fortnox" ?', true)) {
                $this->call('vendor:publish', ['--tag' => 'laravel-fortnox']);
            }

            return;
        }

        if (!$this->confirm('Do you have an existing Access-Token or do you want to setup a new one using a unused Authorazation code?')) {

            if (Config::get('laravel-fortnox.fortnox_access_token')) {
                $this->warn('Access-Token already installed, to continue you have to remove your current Access-Token');
                if (!$this->confirm('Do you want to continue?')) {
                    $this->info('Aborted');
                    return;
                } else {
                    $this->removeAccessToken();
                }
            }

            $AuthorizationCode = $this->ask('Enter the Authorazation code / API-KOD from the Fortnox application');
            $this->installAccessToken($AuthorizationCode);
        } else {
            $AccessToken = $this->ask('Enter your existing Access-Token here');
            $this->removeAccessToken();
            $this->addAccessToken($AccessToken);
        }

    }

    /**
     * @param $AuthorizationCode
     * @throws GuzzleException
     */
    protected function installAccessToken($AuthorizationCode)
    {
        $client = new Client([
            'base_uri' => config('laravel-fortnox.base_uri') . '/',
            'headers' => [
                'Authorization-Code' => $AuthorizationCode,
                'Client-Secret' => config('laravel-fortnox.fortnox_client_secret'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]
        ]);

        try {
            $request = $client->request('customers');
            $content = $request->getBody()->getContents();
            $error = false;
        } catch (ClientException $exception) {
            $content = $exception->getResponse()->getBody()->getContents();
            $error = true;
        }

        $decodedData = json_decode($content, true);

        if ($error) {
            $this->error(sprintf('Failed to install Access-Token: %s', data_get($decodedData, 'ErrorInformation.Message', 'Unknown error')));
            return;
        }

        $AccessToken = data_get($decodedData, 'Authorization.AccessToken', null);

        $this->addAccessToken($AccessToken);

    }

    protected function removeAccessToken()
    {
        try {
            $fh = fopen('.env', 'r+');
            $oldEnv = fread($fh, filesize('.env'));
            $newEnv = preg_replace('/FORTNOX_ACCESS_TOKEN=[^\n]+\n*/m', '', $oldEnv);
            ftruncate($fh, 0);
            fwrite($fh, $newEnv);
        } catch (\Exception $exception) {
            $this->error('Failed to remove FORTNOX_ACCESS_TOKEN from the .env file. Please remove it manually');
            exit;
        }
    }

    protected function addAccessToken($AccessToken)
    {
        try {
            $fh = fopen('.env', 'a+');
            fwrite($fh, sprintf('FORTNOX_ACCESS_TOKEN=%s', $AccessToken) . PHP_EOL);
            $this->info(sprintf('Successfully installed Access-Token: %s', $AccessToken));
        } catch (\Exception $exception) {
            $this->warn(sprintf('Successfully retrieved Access-Token but failed to put it in the .env file. Please add it manually: FORTNOX_ACCESS_TOKEN=%s', $AccessToken));
        }
    }

}
