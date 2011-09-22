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

/**
 * A Hawk Request
 *
 * @author Christian Soronellas <christian@sistemes-cayman.es>
 */
class Request
{
    /**
     * The requested path
     * 
     * @var string
     */
    protected $_path;
    
    public static function fromString($dirtyRequest)
    {
        $requestLines = explode('\r\n', $dirtyRequest);
        // Extract the first line. It will allways be the same
        
        foreach ($requestLines as $requestLine) {
            
        }
    }
}