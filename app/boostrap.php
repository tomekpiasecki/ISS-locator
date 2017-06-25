<?php

declare(strict_types = 1);

use Auryn\Injector as DiContainer;

error_reporting(E_ALL);

//TODO remove
ini_set('display_errors', '1');

require __DIR__ . DS . '..' . DS . "vendor" . DS . "autoload.php";

$diContainer = new DiContainer;

return $diContainer;