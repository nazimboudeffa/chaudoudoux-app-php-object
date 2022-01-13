<?php

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