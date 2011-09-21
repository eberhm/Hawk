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
 * The request test suite
 *
 * @author Christian Soronellas <christian@sistemes-cayman.es>
 */
class RequestTest extends \PHPUnit_Framework_TestCase
{
    protected $_request;
    
    public function setUp()
    {
        $this->_request = new \Hawk\Http\Request();
    }
    
    public function tearDown()
    {
        $this->_request = null;
    }
    
    public function testAssertTrue()
    {
        $this->assertTrue(true);
    }
}