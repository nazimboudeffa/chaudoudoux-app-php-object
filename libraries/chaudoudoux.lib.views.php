<?php

global $VIEW;
$VIEW = new stdClass;
$VIEW->register = array();

/**
 * Include a specific file
 *
 * @param string $file Valid file name;
 * @param array $params Options;
 * @last edit: $arsalanshah
 * @return mixed data
 */
function chaudoudoux_include($file = '', $params = array()) {
    if (!empty($file) && is_file($file)) {
        ob_start();
        $params = $params;
        include($file);
        $contents = ob_get_clean();
        return $contents;
    }

}

/**
 * View a file
 *
 * @param string $file valid file name of php file without extension;
 * @param array $params Options;
 * @last edit: $arsalanshah
 * @return mixed data
 */
function chaudoudoux_view($path = '', $params = array()) {
    global $VIEW;
    if (isset($path) && !empty($path)) {
        //call hook in case to over ride the view
        /*
        if (chaudoudoux_is_hook('halt', "view:{$path}")) {
            return chaudoudoux_call_hook('halt', "view:{$path}", $params);
        }
        */
        $path = chaudoudoux_route()->www . $path;
        $file = chaudoudoux_include($path . '.php', $params);
        return $file;
    }
}

/**
 * Fetch a layout;
 *
 * @last edit: $arsalanshah
 * @Reason: Initial;
 *
 * @param string $layout
 */
function chaudoudoux_set_page_layout($layout, $params = array()) {
    if (!empty($layout)) {
        //unused variabled removed below $arsalanshah
		//$theme = new OssnThemes;
        //$active_theme = $theme->getActive();
        return chaudoudoux_plugin_view("theme/page/layout/{$layout}", $params);
    }
}

/**
 * Add a context to page
 *
 * @param string $context Name of context;
 * @last edit: $arsalanshah
 *
 * @Reason: Initial;
 * @return void;
 */
function chaudoudoux_add_context($context) {
    global $VIEW;
    $VIEW->context = $context;
	return true;
}

/**
 * Register a view;
 *
 * @param string $view Path of view;
 * @param string|callable $file File name for view;
 * @last edit: $arsalanshah
 *
 * @reason: Initial;
 * @returnn mix data
 */
function chaudoudoux_extend_view($views, $file) {
    global $VIEW;
    $VIEW->register[$views][] = $file;
        return true;
}

/**
 * Fetch a register view
 *
 * @param string $layout Name of view;
 * @params  string $params Args for file;
 * @last edit: $arsalanshah
 *
 * @reason: Initial;
 * @return mixed data
 */
function chaudoudoux_fetch_extend_views($layout, $params = array()) {
    global $VIEW;
    if (isset($VIEW->register[$layout]) && !empty($VIEW->register[$layout])) {
        foreach ($VIEW->register[$layout] as $file) {
            if (!is_callable($file)) {
                $fetch[] = chaudoudoux_plugin_view($file, $params);
            } else {
                $fetch[] = call_user_func($file, chaudoudoux_get_context(), $params, current_url());
            }
        }
        return implode('', $fetch);
    }
}

/**
 * Ossn get default theme path
 *
 * @return string
 */
function chaudoudoux_default_theme() {
    return chaudoudoux_route()->themes . chaudoudoux_site_settings('theme') . '/';
}

/**
 * View page;
 *
 * @param  string $title Title for page;
 * @param string $content Content for page;
 *
 * @last edit: $arsalanshah
 * @reason Initial;
 * @return mixed data;
 */
function chaudoudoux_view_page($title, $content, $page = 'page') {
    $params['title'] = $title;
    $params['contents'] = $content;
    return chaudoudoux_plugin_view("theme/page/{$page}", $params);
}