<?php

namespace Hoyvoy\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected $tablesPrefix = 'prefix_';

    /**
     * Get package providers.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \Hoyvoy\CrossDatabase\CrossDatabaseServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param Illuminate\Foundation\Application $app
     *
     * @return void
     */
    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.connections', [
            'mysql1' => [
                'driver'      => 'mysql',
                'host'        => '127.0.0.1',
                'port'        => '3306',
                'database'    => 'mysql1',
                'username'    => 'test',
                'password'    => 'test',
                'unix_socket' => '',
                'charset'     => 'utf8mb4',
                'collation'   => 'utf8mb4_unicode_ci',
                'prefix'      => '',
                'strict'      => true,
                'engine'      => null,
            ],
            'mysql2' => [
                'driver'      => 'mysql',
                'host'        => '127.0.0.1',
                'port'        => '3306',
                'database'    => 'mysql2',
                'username'    => 'test',
                'password'    => 'test',
                'unix_socket' => '',
                'charset'     => 'utf8mb4',
                'collation'   => 'utf8mb4_unicode_ci',
                'prefix'      => $this->tablesPrefix,
                'strict'      => true,
                'engine'      => null,
            ],
            'pgsql1' => [
                'driver'   => 'pgsql',
                'host'     => '127.0.0.1',
                'port'     => '3306',
                'database' => 'pgsql1',
                'username' => 'test',
                'password' => 'test',
                'charset'  => 'utf8',
                'prefix'   => '',
                'schema'   => 'public',
                'sslmode'  => 'prefer',
            ],
            'pgsql2' => [
                'driver'   => 'pgsql',
                'host'     => '127.0.0.1',
                'port'     => '3306',
                'database' => 'pgsql2',
                'username' => 'test',
                'password' => 'test',
                'charset'  => 'utf8',
                'prefix'   => $this->tablesPrefix,
                'schema'   => 'public',
                'sslmode'  => 'prefer',
            ],
            'sqlsrv1' => [
                'driver'   => 'sqlsrv',
                'host'     => '127.0.0.1',
                'port'     => '3306',
                'database' => 'sqlsrv1',
                'username' => 'test',
                'password' => 'test',
                'charset'  => 'utf8',
                'prefix'   => '',
            ],
            'sqlsrv2' => [
                'driver'   => 'sqlsrv',
                'host'     => '127.0.0.1',
                'port'     => '3306',
                'database' => 'sqlsrv2',
                'username' => 'test',
                'password' => 'test',
                'charset'  => 'utf8',
                'prefix'   => $this->tablesPrefix,
            ],
            'sqlite1' => [
                'driver'    => 'sqlite',
                'database'  => __DIR__.'/database/sqlite1.sqlite',
                'prefix'    => '',
            ],
            'sqlite2' => [
                'driver'    => 'sqlite',
                'database'  => __DIR__.'/database/sqlite2.sqlite',
                'prefix'    => $this->tablesPrefix,
            ],
        ]);
    }
}
