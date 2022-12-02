<?php

namespace App\Services;

use App\Contracts\CounterContract;
use Illuminate\Contracts\Cache\Factory as Cache;
use Illuminate\Contracts\Session\Session as Session;

class Counter implements CounterContract
{
    private $cache;
    private $session;
    private $timeout;
    private $supportsTags;

    public function __construct(Cache $cache, Session $session, int $timeout)
    {
        $this->cache = $cache;
        $this->session = $session;
        $this->timeout = $timeout;
        $this->supportsTags = method_exists($cache, 'tags');
    }

    public function increment(string $key, array $tags=null): int
    {
        $sessionId = $this->session->getId();
        $counterKey = "{$key}-counter";
        $usersKey = "{$key}-users";

        // $cache = $this->supportsTags && null !== $tags
        //     ? $this->cache->tags($tags) : $this->cache;  // COMMENTED OUT, I'M NOT USING TAGS

        $users = $this->cache->get($usersKey, []);
        $usersUpdate = [];
        $difference = 0;
        $now = now();

        foreach ($users as $userSessionId => $lastVisitTime) {
            if ($now->diffInMinutes($lastVisitTime) >= $this->timeout) {
                $difference--;
            } else {
                $usersUpdate[$userSessionId] = $lastVisitTime;
            }
        }

        if (
            !array_key_exists($sessionId, $users)
            || $now->diffInMinutes($users[$sessionId]) >= $this->timeout
        ) {
            $difference++;
        }

        $usersUpdate[$sessionId] = $now;
        $this->cache->forever($usersKey, $usersUpdate);

        if (! $this->cache->has($counterKey)) {
            $this->cache->forever($counterKey, 1);
        } else {
            $this->cache->increment($counterKey, $difference);
        }

        $counter = $this->cache->get($counterKey);

        return $counter;
    }
}
