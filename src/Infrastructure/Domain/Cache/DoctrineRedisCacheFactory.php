<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\Infrastructure\Domain\Cache;

use Loobee\Ddd\Domain\Cache\CacheManagerInterface;
use Redis;
use Doctrine\Common\Cache\RedisCache as DoctrineRedisCache;

class DoctrineRedisCacheFactory implements CacheManagerInterface
{
    /**
     * @var DoctrineRedisCache
     */
    private $redis_cache;

    public function __construct($host = '127.0.0.1')
    {
        $redis = new Redis();
        $redis->connect($host);

        $this->redis_cache = new DoctrineRedisCache();
        $this->redis_cache->setRedis($redis);
    }

    public function fetch($prefix, $id)
    {
        $this->redis_cache->setNamespace($prefix);

        return $this->redis_cache->fetch($id);
    }

    public function contains($prefix, $id)
    {
        $this->redis_cache->setNamespace($prefix);

        return $this->redis_cache->contains($id);
    }

    public function save($prefix, $id, $data, $life_time = 0)
    {
        $this->redis_cache->setNamespace($prefix);

        return $this->redis_cache->save($id, $data, $life_time );
    }

    public function delete($prefix, $id)
    {
        $this->redis_cache->setNamespace($prefix);

        return $this->redis_cache->delete($id);
    }

    public function clean($prefix)
    {
        $this->redis_cache->setNamespace($prefix);

        return $this->redis_cache->deleteAll();
    }
}