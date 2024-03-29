<?php

/**
 * This file is part of the Hawk Http Server
 *
 * (c) Christian Soronellas <christian@sistemes-cayman.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hawk\Http;

use Hawk\Http\Connection\Collection as ConnectionCollection;

/**
 * The Hawk HTTP server. A small, embeddable, non-blocking, event based http server written
 * in PHP.
 *
 * @author Christian Soronellas <christian@sistemes-cayman.es>
 */
class Server
{
    /**
     * The port where hawk will be listening
     * 
     * @var int
     */
    protected $_port;
    
    /**
     * The address where hawk will be binded
     * 
     * @var string
     */
    protected $_address;
    
    /**
     * The server socket
     * 
     * @var resource
     */
    protected $_socket;
    
    /**
     * The error number from try to creating a server socket stream
     * 
     * @var int
     */
    protected $_errorNumber;
    
    /**
     * The error string from try to creating a server socket stream
     * 
     * @var string
     */
    protected $_errorString;
    
    /**
     * The application that will get executed when serving requests
     * 
     * @var \Hawk\Http\ApplicationInferface
     */
    protected $_app;
    
    /**
     * Getter for the port
     * 
     * @return int
     */
    public function getPort()
    {
        return $this->_port;
    }

    /**
     * Setter for the port
     * 
     * @param int $port
     */
    public function setPort($port)
    {
        if (ctype_digit($port)) {
            $this->_port = $port;
        }
    }

    /**
     * Getter for the address
     * 
     * @return string
     */
    public function getAddress()
    {
        return $this->_address;
    }

    /**
     * Setter for the IP address. IPv4 and IPv6 addresses are supported
     * 
     * @param string $address 
     */
    public function setAddress($address)
    {
        if (false !== filter_var($address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6)) {
            $this->_address = $address;
        }
    }
    
    /**
     * The class constructor
     * 
     * @param string $address
     * @param int $port 
     */
    public function __construct($address = '0.0.0.0', $port = 9000)
    {
        if (!$this->_checkLibevent()) {
            throw new \RuntimeException('To use Hawk, Libevent must be installed and present!');
        }
        
        $this->setAddress($address);
        $this->setPort($port);
    }
    
    /**
     * Registers the application that will be executed on each request
     * 
     * @param \Hawk\Http\Application\ApplicationInterface $app
     */
    public function registerApplication(\Hawk\Http\Application\ApplicationInterface $app)
    {
        $this->_app = $app;
    }
    
    /**
     * Runs the server
     */
    public function run()
    {
        if (null === $this->_app) {
            throw new \Exception('An application must be registered before running Hawk!');
        }
        
        if (false === ($this->_socket = stream_socket_server($this->_getFormattedServerAddress(), $this->_errorNumber, $this->_errorString))) {
            throw new \RuntimeException('Unable to bind Hawk to the address: ' . $this->_getFormattedServerAddress());
        }
        
        stream_set_blocking($this->_socket, 0);
        
        $base = event_base_new();
        $event = event_new();
        
        $app = $this->_app;
        
        event_set($event, $this->_socket, EV_READ | EV_WRITE | EV_PERSIST, function ($socket, $flag, $base) use ($app) {
            ConnectionCollection::newConnection($socket, $flag, $base, $app);
        }, $base);
        
        event_base_set($event, $base);
        event_add($event);
        event_base_loop($base, EVLOOP_NONBLOCK);
    }
    
    /**
     * Check if Libevent its present
     * 
     * @return boolean
     */
    protected function _checkLibevent()
    {
        return extension_loaded('libevent');
    }
    
    /**
     * Gets the formatted address for Hawk to be able to bind itself to it.
     * 
     * @return string
     */
    protected function _getFormattedServerAddress()
    {
        return 'tcp://' . $this->getAddress() . ':' . $this->getPort();
    }
}