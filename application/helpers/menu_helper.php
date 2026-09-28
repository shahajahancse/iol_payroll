<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('activate_method')) {
    function activate_method($method) {
        // Getting CI class instance.
        $CI = get_instance();
        // Getting router class to active.
        $class = $CI->router->fetch_method();
        return ($class == $method) ? 'active' : '';
    }
}

if(!function_exists('activate_class')) {
    function activate_class($controller) {
      // Getting CI class instance.
      $CI = get_instance();
      // Getting router class to active.
      $class = $CI->router->fetch_class();
      return ($class == $controller) ? 'active open' : '';
    }
}

if(!function_exists('arrow_open')) {
    function arrow_open($controller) {
      // Getting CI class instance.
      $CI = get_instance();
      // Getting router class to active.
      $class = $CI->router->fetch_class();
      return ($class == $controller) ? 'open' : '';
    }
}

