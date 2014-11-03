<?php
/**
* File : RecursiveIt.php   
**/
class RecursiveIt implements RecursiveIterator
{
    private $_data;
    private $_position = 0;

    public function __construct(array $data) {
        $this->_data = $data;
    }

    public function valid() {
        return isset($this->_data[$this->_position]);
    }

    public function hasChildren() {
        return is_array($this->_data[$this->_position]);
    }

    public function next() {
        $this->_position++;
    }

    public function current() {
        return $this->_data[$this->_position];
    }

    public function getChildren() {
        return $this->_data[$this->_position];
    }

    public function rewind() {
        $this->_position = 0;
    }

    public function key() {
        return $this->_position;
    }
}