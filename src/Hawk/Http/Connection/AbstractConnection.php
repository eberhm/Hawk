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

namespace Hawk\Http\Request;

/**
 * A class that represents an AbstractConnection
 *
 * @author Christian Soronellas <christian@sistemes-cayman.es>
 */
abstract class AbstractConnection
{
    /**
     * The connection resource
     * 
     * @var resource
     */
    protected $_connection;
    
    /**
     * The event buffer resource
     * 
     * @var resource
     */
    protected $_buffer;
    
    /**
     * Reads from a given buffer
     * 
     * @param type $buffer
     * @param type $id
     * @return string
     */
    public function read($buffer, $id)
    {
        // Reads the buffer in packets of 256 bytes
        $dirtyRequest = '';
        while ($read = event_buffer_read($buffer, 256)) {
            $dirtyRequest .= $read;
        }
        
        // After read all the request from the buffer, create the request
        // object and set all the environment
        $request = Request::fromString($dirtyRequest);
    }
    
    /**
     * Writes data to the given buffer
     * 
     * @param resource $buffer
     * @param string $data
     * @return boolean
     */
    public function write($buffer, $data, $id)
    {
        return event_buffer_write($buffer, $data);
    }
    
    /**
     * An error ocurred on the buffer
     * 
     * @param type $buffer
     * @param type $error
     * 
     * @param type $id
     */
    public function error($buffer, $error, $id)
    {
        event_buffer_disable($this->_buffer, EV_READ | EV_WRITE);
        event_buffer_free($this->_buffer);
        fclose($this->_connection);
        
        unset($this->_buffer, $this->_connection);
    }
    
    /**
     * Class constructor
     * 
     * @param type $socket
     * @param type $flag
     * @param type $base 
     */
    public function __construct($socket, $flag, $base)
    {
        $this->_connection = stream_socket_accept($socket);
        stream_set_blocking($this->_connection, 0);

        $this->_buffer = event_buffer_new($this->_connection, array($this, 'read'), array($this, 'write'), array($this, 'error'), spl_object_hash($this));
        event_buffer_base_set($this->_buffer, $base);
        event_buffer_timeout_set($this->_buffer, 30, 30);
        event_buffer_watermark_set($this->_buffer, EV_READ | EV_WRITE, 0, 0xffffff);
        event_buffer_priority_set($this->_buffer, 10);
        event_buffer_enable($this->_buffer, EV_READ | EV_WRITE | EV_PERSIST);
    }
    
    /**
     * Getter for the connection ID
     * 
     * @return string
     */
    public function getConnectionId()
    {
        return spl_object_hash($this);
    }
    
    /**
     * Writes the response to the incoming connection
     * 
     * @param \Hawk\Http\Response $response
     */
    public function writeResponse(\Hawk\Http\Response $response)
    {
        file_put_contents($this->_connection, $response);
    }
    
    protected function _setEnvironment(\Hawk\Http\Request $request)
    {
        
    }
    
    /**
     * Extracts the Request.
     * 
     * @return \Hawk\Http\Request
     */
    protected abstract function _getRequest($dirtyRequest);
}