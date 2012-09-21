<?php

require_once __DIR__.'/../../../../vendor/autoload.php';

class QuickCacheException extends \Exception {};

if ( ! is_writable(__DIR__)) {
    exit(__DIR__.' must be writable so that we have a place to write and read cache files to for testing. Please change the permissions.');
}
