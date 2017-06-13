<?php
require_once 'Loader.php';
function autoloader($className) {
    Loader::getInstance()->getClassPath($className);
}

spl_autoload_register('autoloader');