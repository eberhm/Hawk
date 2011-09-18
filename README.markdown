Hawk
====
Hawk is a small, embeddable, non-blocking, event based http server written entirely in PHP.

```php
<?php
require_once __DIR__ . '/lib/SplClassLoader.php';

$loader = new SplClassLoader('Hawk', __DIR__ . '/src');
$loader->register();

$hawk = new \Hawk\Http\Server();
$hawk->registerApplicationHandler(new \My\Application\Handler());

$hawk->run();
```

Requirements
------------
1. PHP 5.3
2. Libevent >= 2.0.13