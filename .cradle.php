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
