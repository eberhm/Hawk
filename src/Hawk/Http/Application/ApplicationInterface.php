<?php

/**
 * This file is part of the Hawk Http Server
 *
 * (c) Christian Soronellas <christian@sistemes-cayman.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hawk\Http\Application;

use Hawk\Http\Request;

/**
 * The interface describing an Http Application
 *
 * @author Christian Soronellas <christian@sistemes-cayman.es>
 */
class ApplicationInterface
{
    /**
     * Executes the application
     */
    public function execute(Request $request);
}