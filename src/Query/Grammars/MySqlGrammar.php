<?php

namespace Hoyvoy\CrossDatabase\Query\Grammars;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\Grammars\MySqlGrammar as IlluminateMySqlGrammar;

class MySqlGrammar extends IlluminateMySqlGrammar
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
        // Check for cross database query to attach database name
        if (strpos($table, '<-->') !== false) {
            list($prefix, $table, $database) = explode('<-->', $table);
            $wrappedTable = $this->wrapTable($table, true);
            $wrappedTablePrefixed = $this->wrap($prefix.$table, true);
            if ($wrappedTable != $wrappedTablePrefixed) {
                return 'from '.$this->wrap($database).'.'.$wrappedTablePrefixed.' as '.$wrappedTable;
            }
            return 'from '.$this->wrap($database).'.'.$wrappedTablePrefixed;
        }

        return 'from '.$this->wrapTable($table);
    }
}
