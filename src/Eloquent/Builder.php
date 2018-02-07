<?php

namespace Hoyvoy\CrossDatabase\Eloquent;

use Illuminate\Database\Eloquent\Builder as IlluminateEloquentBuilder;
use Illuminate\Database\Eloquent\Concerns\QueriesRelationships as IlluminateEloquentQueriesRelationships;
use Hoyvoy\CrossDatabase\Eloquent\Concerns\QueriesRelationships as CrossDatabaseQueriesRelationships;

class Builder extends IlluminateEloquentBuilder
{
    use IlluminateEloquentQueriesRelationships, CrossDatabaseQueriesRelationships {
    	CrossDatabaseQueriesRelationships::addHasWhere insteadof IlluminateEloquentQueriesRelationships;
    }
}
