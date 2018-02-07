<?php

namespace Hoyvoy\CrossDatabase\Query\Grammars;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\Grammars\MySqlGrammar as IlluminateMySqlGrammar;

class MySqlGrammar extends IlluminateMySqlGrammar
{
    /**
     * Compile the "from" portion of the query.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @param  string  $table
     * @return string
     */
    protected function compileFrom(Builder $query, $table)
    {
        // Check for cross database query to attach database name
        if (strpos($table, '<-->') !== false) {
            list($table, $database) = explode('<-->', $table);
            return 'from '.$this->wrap($database).'.'.$this->wrapTable($table);
        }
        return 'from '.$this->wrapTable($table);
    }
}
