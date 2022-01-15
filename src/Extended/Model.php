<?php

namespace KLisica\ApiFormula\Extended;

use KLisica\ApiFormula\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Model as OriginalModel;

class Model extends OriginalModel
{
    use Filterable;
    use HasFactory;
    use Uuid;

    protected $keyType = 'string';
    public $incrementing = false;
}
