<?php

namespace Hoyvoy\CrossDatabase;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\QueriesRelationships;
use Hoyvoy\CrossDatabase\Concerns\QueriesRelationships as CrossDatabaseQueriesRelationships;

class EloquentBuilder extends Builder
{
    use QueriesRelationships, CrossDatabaseQueriesRelationships {
    	CrossDatabaseQueriesRelationships::has insteadof QueriesRelationships;
    }
}
