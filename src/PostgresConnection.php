<?php

namespace Hoyvoy\CrossDatabase;

use Hoyvoy\CrossDatabase\CanCrossDatabaseShazaamInterface;
use Illuminate\Database\PostgresConnection as IlluminatePostgresConnection;
use Hoyvoy\CrossDatabase\Query\Grammars\PostgresGrammar as PostgresQueryGrammar;

class PostgresConnection extends IlluminatePostgresConnection implements CanCrossDatabaseShazaamInterface
{
	/**
     * Get the default query grammar instance.
     *
     * @return \Illuminate\Database\Query\Grammars\PostgresGrammar
     */
    protected function getDefaultQueryGrammar()
    {
        return $this->withTablePrefix(new PostgresQueryGrammar);
    }
}
