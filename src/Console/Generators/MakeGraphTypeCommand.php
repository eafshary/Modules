<?php

namespace Caffeinated\Modules\Console\Generators;

use Caffeinated\Modules\Console\GeneratorCommand;
use Illuminate\Support\Str;

class MakeGraphTypeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module:gtype
    	{slug : The slug of the module.}
    	{name : The name of the graphType class.}
        {--query : Create a new query file for the graphType.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new module graphType class';

    /**
     * String to store the command type.
     *
     * @var string
     */
    protected $type = 'Module graphType';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (parent::handle() !== false) {
            // if ($this->option('migration')) {
            //     $table = Str::plural(Str::snake(class_basename($this->argument('name'))));

            //     $this->call('make:module:migration', [
            //         'slug'     => $this->argument('slug'),
            //         'name'     => "create_{$table}_table",
            //         '--create' => $table,
            //     ]);
            // }
        }
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/graphType.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return module_class($this->argument('slug'), 'GraphQL\Type');
    }
}
