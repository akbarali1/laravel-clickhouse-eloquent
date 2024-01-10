<?php

namespace Tests\Models;

use LaravelClickhouseEloquent\BaseModel;

class Example2 extends BaseModel
{
    protected $connection = 'clickhouse2';
    protected $table = 'examples2';
}