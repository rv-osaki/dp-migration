<?php

namespace App\Console\Commands;

use Illuminate\Database\Console\Seeds\SeederMakeCommand as BaseSeederMakeCommand;

class SeederMakeCommand extends BaseSeederMakeCommand
{

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->resolveStubPath('/app/Seeders/stub/seeder.stub');
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name)
    {

        $stub = parent::buildClass($name);
        return $this->replaceTable($stub, $name);
    }

    /**
     * Replace the table name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceTable($stub, $name)
    {
        $table = strtolower(str_replace($this->getNamespace($name).'\\', '', $name));

        return str_replace(['DummyTable', '{{ table }}', '{{table}}'], $table, $stub);
    }

}
