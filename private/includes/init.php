<?php
require_once 'config.php';

spl_autoload_register(function ($class_name) {
    require_once PRIVATE_PATH . '/classes/' . $class_name . '.php';
});
