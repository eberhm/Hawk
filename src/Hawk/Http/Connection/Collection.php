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

use Hawk\Http\Connection\Connection,
    Hawk\Http\Application\ApplicationInterface;

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
     * The unique instance of this class
     * 
     * @var \Hawk\Http\Connection\Collection
     */
    protected static $_instance;
    
    /**
     * Implementation of the \ArrayAccess::offsetExists
     * @param type $offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return !empty($this->_connections[$offset]);
    }

    /**
     * Implementation of the \ArrayAccess::offsetGet
     * @param string $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->_connections[$offset];
    }

    /**
     * Implementation of the \ArrayAccess::offsetSet
     * @param string $offset
     * @param \Hawk\Http\Connection\Connection $value
     */
    public function offsetSet($offset, $value)
    {
        if (!($value instanceof Connection\Connection)) {
            throw new \Exception('The value must be an instance of \Hawk\Http\Connection\Connection');
        }
        
        $this->_connections[$offset] = $value;
    }

    /**
     * Implementation of the \ArrayAccess::offsetUnset
     * @param string $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->_connections[$offset]);
    }
    
    /**
     * The "singleton" method
     * 
     * @return \Hawk\Http\Connection\Connection
     */
    public static function getInstance()
    {
        if (null === $this->_instance) {
            static::$_instance = new static();
        }
        
        return static::$_instance;
    }
    
    /**
     * Registers a new connection into the collection
     * 
     * @param resource $socket
     * @param int $flag
     * @param resoure $base
     */
    public static function newConnection($socket, $flag, $base, ApplicationInterface $app)
    {
        $collection = static::getInstance();
        
        $connection = new Connection($socket, $flag, $base, $app);
        $this[$connection->getConnectionId()] = $connection;
        
        return $connection;
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