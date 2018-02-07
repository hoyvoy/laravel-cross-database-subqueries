<?php

namespace Hoyvoy\CrossDatabase\Eloquent\Concerns;

use Closure;
use Hoyvoy\CrossDatabase\CanCrossDatabaseShazaamInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

trait QueriesRelationships
{
    /**
     * Add the "has" condition where clause to the query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder            $hasQuery
     * @param  \Illuminate\Database\Eloquent\Relations\Relation $relation
     * @param  string                                           $operator
     * @param  int                                              $count
     * @param  string                                           $boolean
     * 
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    protected function addHasWhere(Builder $hasQuery, Relation $relation, $operator, $count, $boolean)
    {
        // If connection implements CanCrossDatabaseShazaamInterface we must attach database
        // connection name in from to be used by grammar when query compiled
        if ($this->getConnection() instanceof CanCrossDatabaseShazaamInterface) {
            $subqueryConnection = $hasQuery->getConnection()->getDatabaseName();
            $queryConnection = $this->getConnection()->getDatabaseName();
            if ($queryConnection != $subqueryConnection) {
                $queryFrom = $hasQuery->getQuery()->from.'<-->'.$subqueryConnection;
                $hasQuery->from($queryFrom);
            }
        }

        return parent::addHasWhere($hasQuery, $relation, $operator, $count, $boolean);
    }
}
