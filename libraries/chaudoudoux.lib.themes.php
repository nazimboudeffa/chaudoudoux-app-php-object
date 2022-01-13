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
 
function chaudoudoux_themes_init(){
	chaudoudoux_register_plugins_by_path(chaudoudoux_default_theme() . 'plugins/');
}
chaudoudoux_register_callback('chaudoudoux', 'init', 'chaudoudoux_themes_init');