<?php

namespace Core\Commands;

use Core\Classes\Illuminate\Console\GeneratorCommand;

class MakeScopeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     */
    protected $name = 'make:scope';

    /**
     * The console command description.
     */
    protected $description = 'Create a new Eloquent model class';

    /**
     * The type of class being generated.
     */
    protected string $type = 'Scope';

    /**
     * Name of the class directory.
     */
    protected string $directory = 'Scopes';

    /**
     * Create a class in the core or section
     */
    protected bool $is_core = false;

    /**
     * Get the stub file for the generator.
     */
    protected function getStub(): string
    {
        return base_path('app/Core/Stubs/scope.stub');
    }
}
