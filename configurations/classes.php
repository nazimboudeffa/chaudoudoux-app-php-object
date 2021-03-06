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
$ChaudoudouxClasses = array(
		'Session',
		//'Factory',
		//'SiteException',
		'DatabaseException',
		'Base',
		//'Translit',
		//'Mail',
		//'Pagination',
		'Database',
		'Site',
		'Entities',
		'User',
		//'Object',
		//'Annotation',
		//'Themes',
		//'File',
		'Components',
		'Menu',
		//'System',
		//'Image',
);
foreach($ChaudoudouxClasses as $class){
		$loadClass['Chaudoudoux'.$class] = chaudoudoux_route()->classes . "Chaudoudoux{$class}.php";
}
chaudoudoux_register_class($loadClass);
