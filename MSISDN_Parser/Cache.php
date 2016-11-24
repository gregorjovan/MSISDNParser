<?php

/**
 * Provides a generic cache mechanism for caching output of a method.
 */
class Cache
{
    /**
     * Fetches cached output of the passed class/method.
     * If the cached value is not found the method is executed and it's
     * response stored in cache.
     * @param  object  $obj    Object with the method
     * @param  string  $method Name of the method
     * @param  array   $args   Optional arguments for the method
     * @param  integer $ttl    TTL for the cached response
     * @return mixed           Output of the method
     */
    public function get($obj, $method, $args = array(), $ttl = 60)
    {
        $key = $this->generateKey($obj, $method, $args);
        if ($this->cacheExists($key)) {
            return $this->cacheGet($key);
        } else {
            $data = $this->callMethod($obj, $method, $args);
            $this->cacheSet($key, $data, $ttl);
            return $data;
        }
    }
    /**
     * Generates a cache key from passed variables
     * @param  object $obj    Object with the method
     * @param  string $method Name of the method
     * @param  array  $args   Optional argument for the method
     * @return string         Cache key
     */
    protected function generateKey($obj, $method, $args)
    {
        return sprintf(
            "MSISDN_CACHEABLE_%s",
            md5(get_class($obj).$method.serialize($args))
        );
    }
    /**
     * Check if the given key is already set
     * @param  string  $key Cache key
     * @return boolean      ?exists
     */
    protected function cacheExists($key)
    {
        return \apc_exists($key);
    }
    /**
     * Reads the value of the cache key from the cache layer
     * @param  string $key Cache key
     * @return mixed       Cached data
     */
    protected function cacheGet($key)
    {
        return \apc_fetch($key);
    }
    /**
     * Stores the data under the cache key
     * @param  string   $key  Cache key
     * @param  mixed    $data Value to cache
     * @param  integer  $data TTL in seconds
     * @return        [description]
     */
    protected function cacheSet($key, $data, $ttl)
    {
        return \apc_store($key, $data, $ttl);
    }
    /**
     * Executes the required method and returns it's output.
     * @param  object $obj    Object with the method
     * @param  string $method Name of the method
     * @param  array  $args   Optional arguments
     * @return mixed          Method's output
     */
    protected function callMethod($obj, $method, $args)
    {
        return call_user_func_array(array($obj, $method), $args);
    }
}