<?php

namespace Hoyvoy\CrossDatabase\Query\Grammars;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\Grammars\SqlServerGrammar as IlluminateSqlServerGrammar;

class SqlServerGrammar extends IlluminateSqlServerGrammar
{
    /**
     * Compile the "from" portion of the query.
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @param string                             $table
     *
     * @return string
     */
    protected function compileFrom(Builder $query, $table)
    {
        $from = 'from '.$this->wrapTable($table);
        // Check for cross database query to attach database name
        if (strpos($table, '<-->') !== false) {
            list($table, $database) = explode('<-->', $table);
            $from = 'from '.$this->wrap($database).'.'.$this->wrap($table, true);
        }

        if (is_string($query->lock)) {
            return $from.' '.$query->lock;
        }

        if (!is_null($query->lock)) {
            return $from.' with(rowlock,'.($query->lock ? 'updlock,' : '').'holdlock)';
        }

        return $from;
    }
}
