<?php

namespace Caffeinated\Modules;

use Caffeinated\Modules\Contracts\Repository;
use Caffeinated\Modules\Exceptions\ModuleNotFoundException;
use Illuminate\Foundation\Application;

class Modules
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var Repository
     */
    protected $repository;

    /**
     * Create a new Modules instance.
     *
     * @param Application $app
     * @param Repository  $repository
     */
    public function __construct(Application $app, Repository $repository)
    {
        $this->app = $app;
        $this->repository = $repository;
    }

    /**
     * Register the module service provider file from all modules.
     *
     * @return void
     */
    public function register()
    {
        $modules = $this->repository->enabled();

        $modules->each(function ($module) {
            try {
                $this->registerServiceProvider($module);

                $this->autoloadFiles($module);

                $this->setGraphQLConfig($module);
            } catch (ModuleNotFoundException $e) {
                //
            }
        });
    }

    /**
     * Register the module service provider.
     *
     * @param array $module
     *
     * @return void
     */
    private function registerServiceProvider($module)
    {
        $serviceProvider = module_class($module['slug'], 'Providers\\ModuleServiceProvider');

        if (class_exists($serviceProvider)) {
            $this->app->register($serviceProvider);
        }
    }

    /**
     * Autoload custom module files.
     *
     * @param array $module
     *
     * @return void
     */
    private function autoloadFiles($module)
    {
        if (isset($module['autoload'])) {
            foreach ($module['autoload'] as $file) {
                $path = module_path($module['slug'], $file);

                if (file_exists($path)) {
                    include $path;
                }
            }
        }
    }

    /**
     * Set graphql config.
     *
     * @param array $module
     *
     * @return void
     */
    private function setGraphQLConfig($module)
    {
        // Set GraphQL Types
        config(['graphql.types' => array_merge(config('graphql.types'),
            config($module['slug'].'.graphql.types'))]);
        // Set GraphQL Query
        config(['graphql.schemas.default.query' => array_merge(config('graphql.schemas.default.query'),
            config($module['slug'].'.graphql.query'))]);
        // Set GraphQL mutation
        config(['graphql.schemas.default.mutation' => array_merge(config('graphql.schemas.default.mutation'),
            config($module['slug'].'.graphql.mutation'))]);
        // Set GraphQL middleware
        config(['graphql.schemas.default.middleware' => array_merge(config('graphql.schemas.default.middleware'),
            config($module['slug'].'.graphql.middleware'))]);
    }

    /**
     * Oh sweet sweet magical method.
     *
     * @param string $method
     * @param mixed  $arguments
     *
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        return call_user_func_array([$this->repository, $method], $arguments);
    }
}
