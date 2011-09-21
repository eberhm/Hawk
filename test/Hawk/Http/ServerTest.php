<?php

/**
 * This file is part of the Hawk Http Server
 *
 * (c) Christian Soronellas <christian@sistemes-cayman.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HawkTest\Http;

/**
 * A test suite for the Server class
 *
 * @author Christian Soronellas <christian@sistemes-cayman.es>
 */
class ServerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The server instance
     * 
     * @var \Hawk\Http\Server
     */
    protected $_server;
    
    /**
     * Set up the world!
     */
    public function setUp()
    {
        $this->_server = new \Hawk\Http\Server();
    }
    
    /**
     * Tear down
     */
    public function tearDown()
    {
        $this->_server = null;
    }
    
    /**
     * Test that server port cannot be a string
     */
    public function testPortCannotBeAString()
    {
        $this->_server->setPort('abc');
        
        $this->assertEquals(9000, $this->_server->getPort());
    }
    
    /**
     * Test that server address can be ipv4 or ipv6 only
     */
    public function testAddressCanOnlyBeIpv4OrIpv6()
    {
        $this->_server->setAddress('abc');
        
        $this->assertEquals('0.0.0.0', $this->_server->getAddress());
    }
    
    /**
     * @expectedException Exception
     */
    public function testServerOnlyCanRunWithARegisteredApplication()
    {
        $this->_server->run();
    }
    
    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testRuningServer()
    {
        require_once __DIR__ . '/_files/MockApplication.php';
        
        $this->_server->registerApplication(new \MockApplication());
        $this->_server->run();
        stream_socket_server('tcp://0.0.0.0:9000');
    }
}