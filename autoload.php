<?php

spl_autoload_register(function($class) {
  if (preg_match('#^USPC\\\\Feeds\\\\(.*)#', $class, $match)) {
    $file = __DIR__ . '/' . str_replace('\\', '/', $match[1]) . '.php';
    if (file_exists($file) && is_readable($file)) {
      require_once($file);
    }
  }
});
