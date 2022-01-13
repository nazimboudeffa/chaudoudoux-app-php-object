<?php

/**
 * Convert arrays to Object
 *
 * @param array $array Arrays
 * @param string $class class name ,else it will be object of stdClass
 *
 * @return object
 */
function arrayObject($array, $class = 'stdClass') {
    $object = new $class;
    if(empty($array)) {
            return false;
    }
    foreach($array as $key => $value) {
            if(strlen($key)) {
                    if(is_array($value)) {
                            $object->{$key} = arrayObject($value, $class);
                    } else {
                            $object->{$key} = $value;
                    }
            }
    }
    return $object;
}

/**
 * Get system directory paths
 *
 * @return object
 */
function chaudoudoux_route() {
    $root     = str_replace("\\", "/", dirname(dirname(__FILE__)));
    $defaults = array(
            'www' => "$root/",
            'libs' => "$root/libraries/",
            'classes' => "$root/classes/",
            'actions' => "$root/actions/",
            'locale' => "$root/locale/",
            'sys' => "$root/system/",
            'configs' => "$root/configurations/",
            'themes' => "$root/themes/",
            'pages' => "$root/pages/",
            'com' => "$root/components/",
            'admin' => "$root/admin/",
            'forms' => "$root/forms/",
            'upgrade' => "$root/upgrade/",
            'cache' => "{$root}/cache/",
            'js' => "$root/javascripts/",
            'system' => "$root/system/",
            'components' => "$root/components"
    );
    return arrayObject($defaults);
}

/**
 * Register a class for autoloading 
 *
 * @param array $classes A classes list with the path
 * 
 * @return void
 */
function chaudoudoux_register_class(array $classes = array()) {
    global $Chaudoudoux;
    foreach($classes as $name => $class) {
            if(!empty($name) && file_exists($class)) {
                    $Chaudoudoux->classes[$name] = $class;
            } else {
                    throw new Exception("Unable to register a class `{$name}` with non-existing physical class file at location `{$class}`");
            }
    }
}

/**
 * Auto loading classes
 *
 * @param string $name of the class
 * 
 * @return void
 */
function chaudoudoux_autoload_classes($name = '') {
        global $Chaudoudoux;
        if(isset($Chaudoudoux->classes[$name]) && file_exists($Chaudoudoux->classes[$name])) {
                        require_once($Chaudoudoux->classes[$name]);
        }
}

/**
 * Force Object
 * Sometimes php can't get object class ,
 * so we need to make sure that object have class name
 *
 * @param object $object Object
 *
 * @return object
 */
function forceObject(&$object) {
        if(!is_object($object) && gettype($object) == 'object')
                        return ($object = unserialize(serialize($object)));
        return $object;
}

spl_autoload_register('chaudoudoux_autoload_classes');