<?php

namespace Hoyvoy\CrossDatabase;

use Hoyvoy\CrossDatabase\CanCrossDatabaseShazaamInterface;
use Illuminate\Database\SqlServerConnection as IlluminateSqlServerConnection;
use Hoyvoy\CrossDatabase\Query\Grammars\SqlServerGrammar as SqlServerQueryGrammar;

class SqlServerConnection extends IlluminateSqlServerConnection implements CanCrossDatabaseShazaamInterface
{
	/**
     * Get the default query grammar instance.
     *
     * @return \Illuminate\Database\Query\Grammars\SqlServerGrammar
     */
    protected function getDefaultQueryGrammar()
    {
        return $this->withTablePrefix(new SqlServerQueryGrammar);
    }
}
