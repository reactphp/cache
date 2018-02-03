<?php

namespace React\Cache;

use React\Promise;

class ArrayCache implements CacheInterface
{
    private $data = array();

    public function get($key)
    {
        if (!isset($this->data[$key])) {
            return Promise\resolve();
        }

        return Promise\resolve($this->data[$key]);
    }

    public function set($key, $value)
    {
        $this->data[$key] = $value;
        return Promise\resolve(true);
    }

    public function remove($key)
    {
        unset($this->data[$key]);
        return Promise\resolve(true);
    }
}
