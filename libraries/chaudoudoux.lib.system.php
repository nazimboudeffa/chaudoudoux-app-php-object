<?php

/*
 * Load site settings , so the setting should not load agian and again
 */
global $Chaudoudoux;
$settings           = new ChaudoudouxSite;
$Chaudoudoux->siteSettings = $settings->getAllSettings();

/**
 * Get database settings
 *
 * @return object
 */
function chaudoudoux_database_settings() {
	global $Chaudoudoux;
	if (!isset($Chaudoudoux->port)) {
		$Chaudoudoux->port = false;
	}
	$defaults = array(
		'host' => $Chaudoudoux->host,
		'port' => $Chaudoudoux->port,
		'user' => $Chaudoudoux->user,
		'password' => $Chaudoudoux->password,
		'database' => $Chaudoudoux->database
	);
	return arrayObject($defaults);
}

/**
 * Add a hook to system, hooks are usefull for callback returns
 *
 * @param string $hook The name of the hook
 * @param string $type The type of the hook
 * @param callable $callback The name of a valid function or an array with object and method
 * @param int $priority The priority - 500 is default, lower numbers called first
 *
 * @return bool
 *
 * This part is contain code from project called Elgg 
 * 
 * See licenses/elgg/LICENSE.txt
 */
function chaudoudoux_add_hook($hook, $type, $callback, $priority = 200) {
	global $Chaudoudoux;
	
	if (empty($hook) || empty($type)) {
		return false;
	}
	
	if (!isset($Chaudoudoux->hooks)) {
		$Chaudoudoux->hooks = array();
	}
	if (!isset($Chaudoudoux->hooks[$hook])) {
		$Chaudoudoux->hooks[$hook] = array();
	}
	if (!isset($Chaudoudoux->hooks[$hook][$type])) {
		$Chaudoudoux->hooks[$hook][$type] = array();
	}
	
	if (!is_callable($callback, true)) {
		return false;
	}
	
	$priority = max((int) $priority, 0);
	
	while (isset($Chaudoudoux->hooks[$hook][$type][$priority])) {
		$priority++;
	}
	$Chaudoudoux->hooks[$hook][$type][$priority] = $callback;
	ksort($Chaudoudoux->hooks[$hook][$type]);
	return true;
	
}

/**
 * Trigger a callback
 *
 * @param string $event Callback event name
 * @param string $type The type of the callback
 * @param mixed $params Additional parameters to pass to the handlers
 *
 * @return bool
 */
function chaudoudoux_trigger_callback($event, $type, $params = null) {
	global $Chaudoudoux;
	$events = array();
	if (isset($Chaudoudoux->events[$event][$type])) {
		$events[] = $Chaudoudoux->events[$event][$type];
	}
	foreach ($events as $callback_list) {
		if (is_array($callback_list)) {
			foreach ($callback_list as $eventcallback) {
				$args = array(
					$event,
					$type,
					$params
				);
				if (is_callable($eventcallback) && (call_user_func_array($eventcallback, $args) === false)) {
					return false;
				}
			}
		}
	}
	
	return true;
}

/**
 * Register a callback
 *
 * @param string $event Callback event name
 * @param string $type The type of the callback
 * @params $priority callback priority
 * @param string $callback
 *
 * @return bool
 */
 function chaudoudoux_register_callback($event, $type, $callback, $priority = 200) {
	global $Chaudoudoux;
	if (empty($event) || empty($type)) {
		return false;
	}
	
	if (!isset($Chaudoudoux->events)) {
		$Chaudoudoux->events = array();
	}
	if (!isset($Chaudoudoux->events[$event])) {
		$Chaudoudoux->events[$event] = array();
	}
	if (!isset($Chaudoudoux->events[$event][$type])) {
		$Chaudoudoux->events[$event][$type] = array();
	}
	
	if (!is_callable($callback, true)) {
		return false;
	}
	
	$priority = max((int) $priority, 0);
	
	while (isset($Chaudoudoux->events[$event][$type][$priority])) {
		$priority++;
	}
	$Chaudoudoux->events[$event][$type][$priority] = $callback;
	ksort($Chaudoudoux->events[$event][$type]);
	return true;
	
}

/**
 * Call a hook
 *
 * @param string $hook The name of the hook
 * @param string $type The type of the hook
 * @param mixed $params Additional parameters to pass to the handlers
 * @param mixed $returnvalue An initial return value
 *
 * @return mix data
 */
function chaudoudoux_call_hook($hook, $type, $params = null, $returnvalue = null) {
	global $Chaudoudoux;
	$hooks = array();
	if (isset($Chaudoudoux->hooks[$hook][$type])) {
		$hooks[] = $Chaudoudoux->hooks[$hook][$type];
	}
	foreach ($hooks as $callback_list) {
		if (is_array($callback_list)) {
			foreach ($callback_list as $hookcallback) {
				if (is_callable($hookcallback)) {
					$args              = array(
						$hook,
						$type,
						$returnvalue,
						$params
					);
					$temp_return_value = call_user_func_array($hookcallback, $args);
					if (!is_null($temp_return_value)) {
						$returnvalue = $temp_return_value;
					}
				}
			}
		}
	}
	
	return $returnvalue;
}

/**
 * Output Ossn Error page
 *
 * @return mix data
 */
function chaudoudoux_error_page() {
	if (chaudoudoux_is_xhr()) {
		header("HTTP/1.0 404 Not Found");
	} else {
		$title                  = chaudoudoux_print('page:error');
		$contents['content']    = chaudoudoux_plugin_view('pages/contents/error');
		$contents['background'] = false;
		$content                = chaudoudoux_set_page_layout('contents', $contents);
		$data                   = chaudoudoux_view_page($title, $content);
		echo $data;
	}
	exit;
}

/**
 * Ossn php display erros settings
 *
 * @return (void);
 * @access pritvate;
 */
function chaudoudoux_errros() {
	$settings = chaudoudoux_site_settings('display_errors');
	if ($settings == 'on' || is_file(chaudoudoux_route()->www . 'DISPLAY_ERRORS')) {
		error_reporting(E_NOTICE ^ ~E_WARNING);
		
		ini_set('log_errors', 1);
		ini_set('error_log', chaudoudoux_route()->www . 'error_log');
		
		set_error_handler('_chaudoudoux_php_error_handler');
	} elseif ($settings !== 'on') {
		ini_set("log_errors", 0);
		ini_set('display_errors', 'off');
	}
}

/**
 * Get a site settings
 *
 * @param string $setting Settings Name like (site_name, language)
 *
 * @return string or null
 */
function chaudoudoux_site_settings($setting) {
	global $Chaudoudoux;
	if (isset($Chaudoudoux->siteSettings->$setting)) {
		//allow to override a settings
		return chaudoudoux_call_hook('load:settings', $setting, false, $Chaudoudoux->siteSettings->$setting);
	}
	return false;
}

/**
 * Check if the request is ajax or not
 *
 * @return bool
 */
function chaudoudoux_is_xhr() {
	if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
		return true;
	}
	return false;
}

/**
 * Ossn validate offset
 *
 * @return void
 */
function chaudoudoux_offset_validate() {
	//pagination offset should be better protected #627
	$offset = input('offset');
	if (!ctype_digit($offset)) {
		unset($_REQUEST['offset']);
	}
}

/**
 * Get site url
 *
 * @params $extend =>  Extned site url like http://site.com/my/extended/path
 *
 * @return string
 */
function chaudoudoux_site_url($extend = '', $action = false) {
	global $Chaudoudoux;
	$siteurl = "{$Chaudoudoux->url}{$extend}";
	if ($action === true) {
		$siteurl = chaudoudoux_add_tokens_to_url($siteurl);
	}
	return $siteurl;
}

/**
 * Get data directory contaning user and system files
 *
 * @params $extend =>  Extned data directory path like /home/htdocs/userdata/my/extend/path
 *
 * @return string
 */
function chaudoudoux_get_userdata($extend = '') {
	global $Chaudoudoux;
	return "{$Chaudoudoux->userdata}{$extend}";
}

chaudoudoux_errros();
chaudoudoux_register_callback('chaudoudoux', 'init', 'chaudoudoux_offset_validate');
//chaudoudoux_register_callback('chaudoudoux', 'init', 'chaudoudoux_system');