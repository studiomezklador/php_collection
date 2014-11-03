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
        if (is_array(reset($this->items))) // Multi arrays ?
        {
            if ($this->has($key)) // using internal method has()
                return array_column($this->items, $key);
        }

        if ($this->has($key)) // Single associative array [same usage of has()] ?
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

    public function getKey()
    {
        if (is_array(reset($this->items)))
        {
            $res = [];
            foreach ($this->items as $it_key => $it_val)
            {
                $res[] = key($it_key);
            }
            var_dump($res);
            die();
        }
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

    public function first($v = false)
    {
        if (!isset($v))
            return reset($this->items);

        return reset($this->items[$v]);

    }

    public function last($v = false)
    {
        if (!isset($v))
            return end($this->items);

        return end($this->items[$v]);
    }

    /**
     * total: give the result of keys in this instance
     * @return array|int
     */
    public function total()
    {
        if (is_array(reset($this->items)))
            return count($this->fetchAllKeys($this->items));
        return (array) count($this->items);
    }

    public function orderBy($whatever, $descending = false)
    {
        $options = SORT_REGULAR;
        $results = $this->get($whatever);
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

class objCollection {
    protected $arr = [];
    public $methods = []; public $attr = [];

    public function __construct($table = [])
    {
        $this->methods = get_class_methods($this);
        $this->attr = get_class_vars(get_class($this));
        if (!empty($table)) $this->arr = $table;
    }

    public function __set($name, $value)
    {
        $this->arr[$name] = $value;
    }

    public function __get($name)
    {
        return $this->arr[$name];
    }

    public function __isset($name)
    {
        return isset($this->arr[$name]);
    }

    public function __unset($name)
    {
        if (isset($this->arr[$name])) unset($this->arr[$name]);
    }

    public function __call($methodname, $args)
    {
        $input = preg_split('~[A-Z]~',$methodname);
        $methodHere = (string) reset($input);
        $methodKey = (string) end($input);
        if (method_exists($this, $methodHere))
            return $this->$methodHere(strtolower($methodKey));

        return false;
    }

    public function has($key)
    {
        return array_key_exists($key, $this->arr);
    }

    public function all()
    {
        return $arr;
    }

    public function getby($key)
    {
        if ($this->has($key))
            return $this->arr[$key];
    }

    public function flush($key)
    {
        if ($this->has($key))
            unset($this->arr[$key]);
        return true;
    }
}