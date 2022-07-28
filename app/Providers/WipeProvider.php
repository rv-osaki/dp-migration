<?php

namespace App\Providers;

use Illuminate\Database\Console\WipeCommand;
use Illuminate\Support\ServiceProvider;

class WipeProvider extends ServiceProvider
{

    protected $commands = [
        'Wipe' => 'command.wipe',
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCommands(array_merge(
            $this->commands
        ));
    }

    /**
     * Register the given commands.
     *
     * @param  array  $commands
     * @return void
     */
    protected function registerCommands(array $commands)
    {
        foreach (array_keys($commands) as $command) {
            $this->{"register{$command}Command"}();
        }

        $this->commands(array_values($commands));
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerWipeCommand()
    {
        $this->app->singleton('command.wipe', function ($app) {
            return new WipeCommand($app['db']);
        });
    }

}
