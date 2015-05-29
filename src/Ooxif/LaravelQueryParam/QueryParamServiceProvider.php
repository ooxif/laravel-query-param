<?php

namespace Ooxif\LaravelQueryParam;

use BadMethodCallException;
use Illuminate\Contracts\Foundation\Application as ApplicationContract;
use Illuminate\Support\ServiceProvider;

class QueryParamServiceProvider extends ServiceProvider
{
    protected $managerClass = 'Ooxif\LaravelQueryParam\DatabaseManager';
    
    public function register()
    {
        $app = $this->app;

        if (!$app->bound('db')) {
            throw new BadMethodCallException(__METHOD__ . ' must be called after Illuminate\Database\DatabaseServiceProvider::register()');
        }
        
        if ($app->resolved('db')) {
            throw new BadMethodCallException(__METHOD__ . ' must be called before resolving "db"');
        }
        
        $app->alias('db', $this->managerClass);
        
        $app->singleton('db', function (ApplicationContract $app) {
            return $this->newDatabaseManager($app);
        });
    }

    /**
     * @param ApplicationContract $app
     * @return DatabaseManager
     */
    protected function newDatabaseManager(ApplicationContract $app)
    {
        $cls = $this->managerClass;

        return new $cls($app, $app['db.factory']);
    }
}