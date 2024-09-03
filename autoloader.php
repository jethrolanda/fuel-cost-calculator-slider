<?php
spl_autoload_register(function ($class) {
  $namespace = 'FSCS\Plugin\\';

  if (strpos($class, $namespace) !== 0) {
    return;
  }

  $class = str_replace($namespace, '', $class);
  $class = str_replace('_', '-', $class);
  $class = str_replace('\\', DIRECTORY_SEPARATOR, strtolower($class)) . '.php';

  $directory = plugin_dir_path(__FILE__);
  $path = $directory . 'includes/class-fscs-' . $class;

  if (file_exists($path)) {
    require_once($path);
  }
});
