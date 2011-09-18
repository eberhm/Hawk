<?php

/**
 * This file is part of the Hawk Http Server
 *
 * (c) Christian Soronellas <christian@sistemes-cayman.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hawk\Http\Connection;

/**
 * Description of Collection
 *
 * @author Christian Soronellas <christian@sistemes-cayman.es>
 */
class Collection implements \ArrayAccess
{
    /**
     * An array of active connections
     * 
     * @var array
     */
    protected $_connections;
    
    /**
     *
     * @var \Hawk\Http\Connection\Collection
     */
    protected static $_instance;
    
    public function offsetExists($offset)
    {
        return !empty($this->_connections[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->_connections[$offset];
    }

    public function offsetSet($offset, $value)
    {
        if (!($value instanceof Connection\Connection)) {
            throw new \Exception('The value must be an instance of \Hawk\Http\Connection\Connection');
        }
        
        $this->_connections[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->_connections[$offset]);
    }
    
    public static function getInstance()
    {
        if (null === $this->_instance) {
            static::$_instance = new static();
        }
        
        return static::$_instance;
    }
    
    public static function newConnection($socket, $flag, $base)
    {
        $collection = static::getInstance();
        
        

        // we need to save both buffer and connection outside
        $GLOBALS['connections'][$id] = $connection;
        $GLOBALS['buffers'][$id] = $buffer;
    }
    
    /**
     * Class constructor
     */
    private function __construct()
    {
        $this->_connections = array();
    }
    
    /**
     * __clone method implementation.
     */
    public function __clone()
    {
        throw new \Exception('This object cannot be cloned!');
    }
}