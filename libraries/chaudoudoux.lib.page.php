<?php
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