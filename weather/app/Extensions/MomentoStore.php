<?php

namespace App\Extensions;

use Illuminate\Contracts\Cache\Store;
use Momento\Cache\CacheOperationTypes\CacheGetResponse;
use Momento\Cache\CacheOperationTypes\CacheSetResponse;
use Momento\Cache\Errors\UnknownError;
use Momento\Cache\SimpleCacheClient;

class MomentoStore implements Store
{
    protected SimpleCacheClient $client;
    protected string $cacheName;

    public function __construct(SimpleCacheClient $client, string $cacheName)
    {
        $this->client = $client;
        $this->cacheName = $cacheName;
        $this->client->createCache($cacheName);
    }

    public function get($key): CacheGetResponse
    {
        return $this->client->get($this->cacheName, $key);
    }

    public function many(array $keys)
    {
        throw new UnknownError("many operations is currently not supported.");
    }

    public function put($key, $value, $seconds): CacheSetResponse
    {
        return $this->client->set($this->cacheName, $key, $value, $seconds);
    }

    public function putMany(array $values, $seconds)
    {
        throw new UnknownError("putMany operations is currently not supported.");
    }

    public function increment($key, $value = 1)
    {
        throw new UnknownError("increment operations is currently not supported.");
    }

    public function decrement($key, $value = 1)
    {
        throw new UnknownError("decrement operations is currently not supported.");
    }

    public function forever($key, $value)
    {
        throw new UnknownError("forever operations is currently not supported.");
    }

    public function forget($key)
    {
        throw new UnknownError("forget operations is currently not supported.");
    }

    public function flush()
    {
        throw new UnknownError("flush operations is currently not supported.");
    }

    public function getPrefix()
    {
    }
}
