<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Throwable;

abstract class BaseService
{
    /**
     * Run a callback inside a database transaction.
     *
     * @param callable $callback
     * @return mixed
     * @throws Throwable
     */
    protected function transaction(callable $callback): mixed
    {
        return DB::transaction($callback);
    }
}
