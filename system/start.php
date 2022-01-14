<?php

if(!defined("CHAUDOUDOUX_ALLOW_SYSTEM_START")){
	header("HTTP/1.0 404 Not Found");	
	exit;
}

global $Chaudoudoux;
if (!isset($Chaudoudoux)) {
    $Chaudoudoux = new stdClass;
}

include_once(dirname(dirname(__FILE__)) . '/libraries/chaudoudoux.lib.route.php');

if (!is_file(chaudoudoux_route()->configs . 'chaudoudoux.config.site.php') && !is_file(chaudoudoux_route()->configs . 'chaudoudoux.config.db.php')) {
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
    header("Location: install");
	exit;
}

include_once(chaudoudoux_route()->configs . 'libraries.php');
include_once(chaudoudoux_route()->configs . 'classes.php');

include_once(chaudoudoux_route()->configs . 'chaudoudoux.config.site.php');
include_once(chaudoudoux_route()->configs . 'chaudoudoux.config.db.php');

session_start();

foreach ($Chaudoudoux->libraries as $lib) {
    if (!include_once(chaudoudoux_route()->libs . "chaudoudoux.lib.{$lib}.php")) {
        throw new exception('Cannot include all libraries');
    }
}