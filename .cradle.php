<?php //-->

use Cradle\Framework\Flow;
use Cradle\Framework\Csrf\Controller;

Flow::register('csrf', function() use ($cradle) {
    static $cache = null;

    if(is_null($cache)) {
        $cache = new Controller($cradle);
    }

    return $cache;
});

$cradle->on('csrf-load', Flow::csrf()->load);
$cradle->on('csrf-render', Flow::csrf()->render);
$cradle->on('csrf-validate', Flow::csrf()->check);
