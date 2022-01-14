<?php
/**
 * Open Source Social Network
 *
 * @package   (openteknik.com).ossn
 * @author    OSSN Core Team <info@openteknik.com>
 * @copyright (C) OpenTeknik LLC
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */

/**
 * Registers an action.
 *
 * @param string $action The name of the action
 * @param string $filename The filename where this action is located.
 *
 * @return void
 */
function chaudoudoux_register_action($action, $file) {
    global $Chaudoudoux;
    $Chaudoudoux->action[$action] = $file;
}

/**
 * Unregister action
 *
 * @param string $action The name of the action
 *
 * @return void
 */
function chaudoudoux_unregister_action($action) {
    global $Chaudoudoux;
    unset($Chaudoudoux->action[$action]);
}

/**
 * Load action.
 *
 * @param string $action The name of the action
 *
 * @return void
 */
function chaudoudoux_action($action) {
    global $Chaudoudoux;
    if (isset($Chaudoudoux->action) && array_key_exists($action, $Chaudoudoux->action)
    ) {
        if (is_file($Chaudoudoux->action[$action])) {
			$params['action'] = $action;
            chaudoudoux_trigger_callback('action', 'load', $params);
            include_once($Chaudoudoux->action[$action]);
			if(chaudoudoux_is_xhr()){
				header('Content-Type: application/json');
				$vars = array();
				if(isset($_SESSION['chaudoudoux_messages']['success']) 
					&& !empty($_SESSION['chaudoudoux_messages']['success'])){
						$vars['success'] = $_SESSION['chaudoudoux_messages']['success'];
				}
				//danger = error bootstrap
				if(isset($_SESSION['chaudoudoux_messages']['danger']) 
					&& !empty($_SESSION['chaudoudoux_messages']['danger'])){
						$vars['error'] = $_SESSION['chaudoudoux_messages']['danger'];
				}
				if(isset($Chaudoudoux->redirect) && !empty($Chaudoudoux->redirect)){
					$vars['redirect'] = $Chaudoudoux->redirect;
				}
				if(isset($Chaudoudoux->ajaxData) && !empty($Chaudoudoux->ajaxData)){
					$vars['data'] = $Chaudoudoux->ajaxData;
				}
				unset($_SESSION['chaudoudoux_messages']);
				if(!empty($vars)){
					echo json_encode($vars);
				}
			}
        }
    } else {
        chaudoudoux_error_page();
    }
}