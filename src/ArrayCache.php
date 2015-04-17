<?php

namespace React\Cache;

use React\Promise;

class ArrayCache implements CacheInterface
{
    /**
     * @var array
     */
    protected $data = array();

    /**
     * {@inheritdoc}
     */
    public function get($key)
    {
        if (!isset($this->data[$key])) {
            return Promise\reject();
        }

        return Promise\resolve($this->data[$key]);
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function remove($key)
    {
        unset($this->data[$key]);
    }
}
