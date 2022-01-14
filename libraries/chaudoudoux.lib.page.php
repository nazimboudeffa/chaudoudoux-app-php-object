<?php
/**
 * Register metatags init
 *
 * @return void
 */
function chaudoudoux_page_metatags() {
        chaudoudoux_extend_view('chaudoudoux/site/head', 'chaudoudoux_view_metatags');
}

/**
 * Register a page handler;
 * @params: $handler = page;
 * @params: $function = function which handles page;
 * @param string $handler
 * @param string $function
 *
 * @last edit: $arsalanshah
 * @Reason: Initial;
 */
function chaudoudoux_register_page($handler, $function) {
        global $Chaudoudoux;
        $pages = $Chaudoudoux->page[$handler] = $function;
        return $pages;
}

/**
* Unregister a page from syste,
* @param (string) $handler Page handler name;
*
* @last edit: $arsalanshah
* @return void;
*/
function chaudoudoux_unregister_page($handler) {
        global $Chaudoudoux;
        unset($Chaudoudoux->page[$handler]);
}

/**
 * Output a page.
 *
 * If page is not registered then user will see a 404 page;
 *
 * @param  (string) $handler Page handler name;
 * @param  (string) $page  handler/page;
 * @last edit: $arsalanshah
 * @Reason: Initial;
 *
 * @return mix|null data
 * @access private
 */
function chaudoudoux_load_page($handler, $page) {
    global $Chaudoudoux;
    $context = $handler;
    if(isset($page) && !empty($page)) {
            $context = "$handler/$page";
    }
    //set context
    chaudoudoux_add_context($context);

    $page = explode('/', $page);
    if(isset($Chaudoudoux->page) && isset($Chaudoudoux->page[$handler]) && !empty($handler) && is_callable($Chaudoudoux->page[$handler])) {
            //supply params to hook
            $params['page']    = $page;
            $params['handler'] = $handler;
            
            //[E] Allow to override page handler existing pages #1746
            $halt_view = false; //chaudoudoux_call_hook('page', 'override:view', $params, false);
            if($halt_view === false) {
                    //get page contents
                    ob_start();
                    call_user_func($Chaudoudoux->page[$handler], $page, $handler);
                    $contents = ob_get_clean();
            }
            if($halt_view) {
                    $contents = '';
            }
            return chaudoudoux_call_hook('page', 'load', $params, $contents);
    } else {
            return chaudoudoux_error_page();
    }
}
/**
 * View metatags
 * [E] Allow to use metatags in head #1996
 *
 * @return void
 */
function chaudoudoux_view_metatags() {
        global $Chaudoudoux;
        if(isset($Chaudoudoux->pageMetaTags)) {
                        $results = array();
                        foreach($Chaudoudoux->pageMetaTags as $name => $vars) {
                                        if(!empty($vars['value']) && isset($vars['property'])) {
                                                        $args = array();
                                                        if($vars['property'] === false) {
                                                                        $args['name'] = $name;
                                                        } else {
                                                                        $args['property'] = $name;
                                                        }
                                                        $args['content'] = $vars['value'];
                                                        $results[]       = chaudoudoux_plugin_view('output/meta', $args);
                                        }
                        }
                        echo PHP_EOL . implode(PHP_EOL, $results);
        }
}
chaudoudoux_register_callback('chaudoudoux', 'init', 'chaudoudoux_page_metatags');