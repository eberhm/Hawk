<?php

/**
 * This file is part of the Hawk Http Server
 *
 * (c) Christian Soronellas <christian@sistemes-cayman.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use \Hawk\Http\Request;

/**
 * A Mock Application driver for test purposes
 *
 * @author Christian Soronellas <christian@sistemes-cayman.es>
 */
class MockApplication implements \Hawk\Http\Application\ApplicationInterface
{
    public function execute(Request $request)
    {
        
    }

}