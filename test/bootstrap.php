<?php

/**
 * This file is part of the Hawk Http Server
 *
 * (c) Christian Soronellas <christian@sistemes-cayman.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require dirname(__DIR__) . '/lib/SplClassLoader.php';

$loader = new SplClassLoader('Hawk', dirname(__DIR__) . '/src');
$loader->register();