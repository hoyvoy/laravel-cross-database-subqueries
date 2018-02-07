<?php

namespace Hoyvoy\CrossDatabase\Connectors;

use Illuminate\Database\Connection;
use Hoyvoy\CrossDatabase\MySqlConnection;
use Hoyvoy\CrossDatabase\PostgresConnection;
use Hoyvoy\CrossDatabase\SqlServerConnection;
use Illuminate\Database\Connectors\ConnectionFactory as IlluminateConnectionFactory;
use PDO;

class ConnectionFactory extends IlluminateConnectionFactory
{
    /**
     * @param string       $driver
     * @param \Closure|PDO $connection
     * @param string       $database
     * @param string       $prefix
     * @param array        $config
     *
     * @return \Illuminate\Database\ConnectionInterface
     */
    protected function createConnection($driver, $connection, $database, $prefix = '', array $config = [])
    {
        if ($resolver = Connection::getResolver($driver)) {
            return $resolver($connection, $database, $prefix, $config);
        }

        switch ($driver) {
            case 'mysql':
                return new MySqlConnection($connection, $database, $prefix, $config);
            case 'pgsql':
                return new PostgresConnection($connection, $database, $prefix, $config);
            case 'sqlsrv':
                return new SqlServerConnection($connection, $database, $prefix, $config);
        }

        return parent::createConnection($driver, $connection, $database, $prefix, $config);
    }
}
