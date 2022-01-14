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

//register all available language
/*
$available_languages = chaudoudoux_get_available_languages();
foreach($available_languages as $language) {
		chaudoudoux_register_language($language, chaudoudoux_route()->locale . "chaudoudoux.{$language}.php");
}

chaudoudoux_default_load_locales();
*/
/**
 * Initialize the css library
 *
 * @return void
 */
function chaudoudoux_initialize() {
		$url = chaudoudoux_site_url();
		
		//$icon = chaudoudoux_site_url('themes/licorne/images/icon.png');
		
		/*
		chaudoudoux_register_sections_menu('newsfeed', array(
				'name' => 'newsfeed',
				'text' => chaudoudoux_print('news:feed'),
				'url' => "{$url}home",
				'parent' => 'links',
				'icon' => $icon
		));
		
		ossn_extend_view('ossn/js/head', 'javascripts/head');
		ossn_extend_view('ossn/admin/js/head', 'javascripts/head');
		//actions
		ossn_register_action('user/login', ossn_route()->actions . 'user/login.php');
		ossn_register_action('user/register', ossn_route()->actions . 'user/register.php');
		ossn_register_action('user/logout', ossn_route()->actions . 'user/logout.php');
		
		ossn_register_action('friend/add', ossn_route()->actions . 'friend/add.php');
		ossn_register_action('friend/remove', ossn_route()->actions . 'friend/remove.php');
		ossn_register_action('resetpassword', ossn_route()->actions . 'user/resetpassword.php');
		ossn_register_action('resetlogin', ossn_route()->actions . 'user/resetlogin.php');
		*/

		chaudoudoux_register_page('index', 'chaudoudoux_index_pagehandler');	
		chaudoudoux_register_page('home', 'chaudoudoux_user_pagehandler');
		/*
		ossn_register_page('login', 'ossn_user_pagehandler');
		ossn_register_page('registered', 'ossn_user_pagehandler');
		ossn_register_page('syserror', 'ossn_system_error_pagehandler');
		
		ossn_register_page('resetlogin', 'ossn_user_pagehandler');
		
		chaudoudoux_add_hook('newsfeed', "sidebar:left", 'newfeed_menu_handler');

		chaudoudoux_register_menu_item('footer', array(
				'name' => 'a_copyrights',
				'text' => chaudoudoux_print('copyright') . ' ' . chaudoudoux_site_settings('site_name'),
				'href' => chaudoudoux_site_url()
		));
		
		chaudoudoux_register_menu_item('footer', chaudoudoux_pow_lnk_args());

		chaudoudoux_extend_view('chaudoudoux/endpoint', 'author/view');
		*/
}

/**
 * Add left menu to newsfeed page
 *
 * @return menu
 */
function newfeed_menu_handler($hook, $type, $return) {
		$return[] = chaudoudoux_view_sections_menu('newsfeed');
		return $return;
}

/**
 * System Errors
 * @pages:
 *       unknown,
 *
 * @return boolean|null
 */
function ossn_system_error_pagehandler($pages) {
		$page = $pages[0];
		if(empty($page)) {
				$page = 'unknown';
		}
		switch($page) {
				case 'unknown':
						$error  = "<div class='ossn-ajax-error'>" . ossn_print('system:error:text') . "</div>";
						$params = array(
								'title' => ossn_print('system:error:title'),
								'contents' => $error,
								'callback' => false
						);
						echo ossn_plugin_view('output/ossnbox', $params);
						break;
		}
}

/**
 * Register basic pages
 * @pages:
 *       home,
 *    login,
 *       registered
 *
 * @return mixed contents
 */
function chaudoudoux_user_pagehandler($home, $handler) {
		switch($handler) {
				case 'home':
						if(!chaudoudoux_isLoggedin()) {
								//Redirect User to login page if session expired from home page #929
								redirect('login');
						}
						$title = chaudoudoux_print('news:feed');
						if(com_is_active('OssnWall')) {
								$contents['content'] = chaudoudoux_plugin_view('wall/pages/wall');
						}
						$content = chaudoudoux_set_page_layout('newsfeed', $contents);
						echo chaudoudoux_view_page($title, $content);
						break;
				case 'resetlogin':
						if(ossn_isLoggedin()) {
								redirect('home');
						}
						$user                = input('user');
						$code                = input('c');
						$contents['content'] = ossn_plugin_view('pages/contents/user/resetlogin');
						
						if(!empty($user) && !empty($code)) {
								$contents['content'] = ossn_plugin_view('pages/contents/user/resetcode');
						}
						$title   = ossn_print('reset:login');
						$content = ossn_set_page_layout('startup', $contents);
						echo ossn_view_page($title, $content);
						break;
				case 'login':
						if(ossn_isLoggedin()) {
								redirect('home');
						}
						$title               = ossn_print('site:login');
						$contents['content'] = ossn_plugin_view('pages/contents/user/login');
						$content             = ossn_set_page_layout('startup', $contents);
						echo ossn_view_page($title, $content);
						break;
				
				case 'registered':
						if(ossn_isLoggedin()) {
								redirect('home');
						}
						$title               = ossn_print('account:registered');
						$contents['content'] = ossn_plugin_view('pages/contents/user/registered');
						$content             = ossn_set_page_layout('startup', $contents);
						echo ossn_view_page($title, $content);
						break;
				
				default:
						ossn_error_page();
						break;
						
		}
}

/**
 * Register site index page
 * @pages:
 *       index or home,
 *
 * @return boolean|null
 */
function chaudoudoux_index_pagehandler($index) {
		if(chaudoudoux_isLoggedin()) {
				redirect('home');
		}
		$page = $index[0];
		if(empty($page)) {
				$page = 'home'; 
		}
		switch($page) {
				case 'home':
						echo chaudoudoux_plugin_view('pages/index');
						break;
				
				default:
						chaudoudoux_error_page();
						break;
						
		}
}
/**
 * Ossn pow lnk args
 * 
 * @return array
 */
function chaudoudoux_pow_lnk_args() {
		$pw  = base64_decode(OSSN_POW);
		$pow = ossn_string_decrypt($pw, 'ossn');
		$pow = trim($pow);
		
		$lnk = base64_decode(OSSN_LNK);
		$lnk = ossn_string_decrypt($lnk, 'ossn');
		$lnk = trim($lnk);
		
		return array(
				'name' => $pow,
				'text' => chaudoudoux_print($pow),
				'href' => $lnk,
				'priority' => 1000,
		);
}
/**
 * Loads system plugins before we load components.
 *
 * @return void
 */
function chaudoudoux_system_plugins_load() {
		//load system plugins before components load #451
		chaudoudoux_register_plugins_by_path(chaudoudoux_route()->system . 'plugins/');
}
chaudoudoux_register_callback('chaudoudoux', 'init', 'chaudoudoux_initialize');