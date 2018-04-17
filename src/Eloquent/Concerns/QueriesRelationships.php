<?php

namespace Hoyvoy\CrossDatabase\Eloquent\Concerns;

use Hoyvoy\CrossDatabase\CanCrossDatabaseShazaamInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Str;

trait QueriesRelationships
{
    /**
     * Add the "has" condition where clause to the query.
     *
     * @param \Illuminate\Database\Eloquent\Builder            $hasQuery
     * @param \Illuminate\Database\Eloquent\Relations\Relation $relation
     * @param string                                           $operator
     * @param int                                              $count
     * @param string                                           $boolean
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
                $queryFrom = $hasQuery->getConnection()->getTablePrefix().'<-->'.$hasQuery->getQuery()->from.'<-->'.$subqueryConnection;
                $hasQuery->from($queryFrom);
            }
        }

        return parent::addHasWhere($hasQuery, $relation, $operator, $count, $boolean);
    }

    /**
     * Add subselect queries to count the relations.
     *
     * @param mixed $relations
     *
     * @return $this
     */
    public function withCount($relations)
    {
        if (empty($relations)) {
            return $this;
        }

        if (is_null($this->query->columns)) {
            $this->query->select([$this->query->from.'.*']);
        }

        $relations = is_array($relations) ? $relations : func_get_args();

        foreach ($this->parseWithRelations($relations) as $name => $constraints) {
            // First we will determine if the name has been aliased using an "as" clause on the name
            // and if it has we will extract the actual relationship name and the desired name of
            // the resulting column. This allows multiple counts on the same relationship name.
            $segments = explode(' ', $name);

            unset($alias);

            if (count($segments) == 3 && Str::lower($segments[1]) == 'as') {
                list($name, $alias) = [$segments[0], $segments[2]];
            }

            $relation = $this->getRelationWithoutConstraints($name);

            // Here we will get the relationship count query and prepare to add it to the main query
            // as a sub-select. First, we'll get the "has" query and use that to get the relation
            // count query. We will normalize the relation name then append _count as the name.
            $query = $relation->getRelationExistenceCountQuery(
                $relation->getRelated()->newQuery(), $this
            );

            $query->callScope($constraints);

            $query->mergeConstraintsFrom($relation->getQuery());

            // If connection implements CanCrossDatabaseShazaamInterface we must attach database
            // connection name in from to be used by grammar when query compiled
            if ($this->getConnection() instanceof CanCrossDatabaseShazaamInterface) {
                $subqueryConnection = $query->getConnection()->getDatabaseName();
                $queryConnection = $this->getConnection()->getDatabaseName();
                if ($queryConnection != $subqueryConnection) {
                    $queryFrom = $query->getConnection()->getTablePrefix().'<-->'.$query->getQuery()->from.'<-->'.$subqueryConnection;
                    $query->from($queryFrom);
                }
            }

            // Finally we will add the proper result column alias to the query and run the subselect
            // statement against the query builder. Then we will return the builder instance back
            // to the developer for further constraint chaining that needs to take place on it.
            $column = $alias ?? Str::snake($name.'_count');

            $this->selectSub($query->toBase(), $column);
        }

        return $this;
    }
}
