<?php

namespace App\Services;

use App\Contracts\CounterContract;

class DummyCounter implements CounterContract
{
    public function increment(string $key, array $tag=null): int
    {
        dd("I'm a dummy counter noty implemented yet!");

        return 0;
    }
}
