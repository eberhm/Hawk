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
 * The connection interface
 *
 * @author Christian Soronellas <christian@sistemes-cayman.es>
 */
interface ConnectionInterface
{
    /**
     * Reads from the given buffer
     */
    public function read($buffer, $id);
    
    /**
     * Writes to the given buffer
     */
    public function write($buffer, $id);
    
    /**
     * A callback that will be executed when an error occurs on the
     * connection
     */
    public function error($buffer, $error, $id);
}