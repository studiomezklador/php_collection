<?php

class Collection implements ArrayAccess, IteratorAggregate
{

    private $items = [];
    private $iterator;

    public function __construct($table = [])
    {
        $this->items = $table;
        if (!empty($table)) {
            //$this->iterator = new RecursiveArrayIterator($table);
        }
    }

    /**
     * @return string /// NOT WORKING YET!
     */
    public function _toString()
    {
        return $this->toJson();
    }

    /**
     * get: get a single / multiple key(s) from this instance, even if it's multiple array.
     * @param $key : single or multiple array
     * @return array|bool
     */
    public function get($key)
    {
        if (is_array(reset($this->items))) // Multi arrays
        {
            if ($this->has($key)) // using internal method has()
                return array_column($this->items, $key);
        }

        if ($this->has($key)) // Single associative array [same usage of has()]
        {
            return $this->items[$key];
        }

        return false; // nothing at all
    }

    /**
     * set: insert a key inside this instance /// Nothing setup for multiple array, YET!
     * @param $key : the KEY to set in the array
     * @param null $value : the VALUE to inject
     */
    public function set($key, $value = null)
    {
        $this->items[$key] = $value;
    }

    /**
     * allKeys: method to get all the keys inside a single / multiple Array.
     * @return array
     */
    public function getAllKeys()
    {
        if (is_array($this->items))
            return $this->fetchAllKeys($this->items);
        return array_keys($this->items);
    }

    /**
     * fetchAllKeys: special method for multiple array, with recursion (called in getAllKeys).
     * @param array $array
     * @return array
     */
    public function fetchAllKeys(array $array)
    {
        $keys = [];
        foreach ($array as $k => $v) {
            $keys[] = $k;
            if (is_array($v)) {
                $keys = array_merge($keys, $this->fetchAllKeys($v)); // See? Here's the recursion.
            }
        }
        return $keys;
    }

    /**
     * has: just checking if a key exists inside this instance.
     * @param $key
     * @param bool $offset
     * @return bool
     */
    public function has($key, $offset = false)
    {
        $lookup = ($offset != false) ? $offset : $this->items;

        if (is_array(reset($this->items)))
            return in_array($key, $this->getAllKeys(), true);

        return array_key_exists($key, $lookup);
    }

    public function listing($k, $v, $obj = false)
    {
        $result = [];
        foreach ($this->items as $item) {
            $result[$item[$k]] = $item[$v];
        }
        return ($obj != false) ? new Collection($result) : $result;
    }

    public function extract($key, $obj = false)
    {
        $result = [];
        foreach ($this->items as $item) {
            $result[] = $item[$key];
        }
        return ($obj != false) ? new Collection($result) : $result;
    }

    public function join($glue)
    {
        return implode($glue, $this->items);
    }

    public function max($k = false)
    {
        if ($k) {
            return $this->extract($k, true)->max();
        }
        return max($this->items);
    }

    public function min($k = false)
    {
        if ($k) {
            return $this->extract($k)->max();
        }
        return min($this->items);
    }

    public function first()
    {
        return reset($this->items);
    }

    public function last()
    {
        return end($this->items);

    }

    public function length()
    {
        return count($this->items);
    }

    public function orderBy($whatever, $descending = false)
    {
        $options = SORT_REGULAR;
        $results = $this->extract($whatever);
        if ($descending != true) {
            ksort($results, $options);
        } else {
            krsort($results, $options);
        }
        return $results;
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    public function toArray()
    {
        return array_map(function ($val) {
            return $val;
        }, $this->items);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        return $this->set($offset, $value);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     */
    public function offsetUnset($offset)
    {
        if ($this->has($offset)) unset($this->items[$offset]);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     */
    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    public function display($val)
    {
        return $this->{$val};
    }

}