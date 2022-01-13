<?php

/**
 * Get input from user; using secure method;
 *
 * @param string  $input Name of input;
 * @param integer $noencode If you don't want to encode to html entities then add 1 as second arg in function.
 * @param boolean $strip Remove spaces from start and end of input
 *
 * @last edit: $arsalanshah
 * @reason: fix docs;
 * @return false|string
 */
function input($input, $noencode = '', $default = false, $strip = true) {
    $str  = false;
    //#1230 breaks when array is input #1474
    if(isset($_REQUEST[$input]) && !is_array($_REQUEST[$input])){
        $data_hook = ((strlen($_REQUEST[$input]) > 0) ? preg_replace('/\x20+/', ' ', $_REQUEST[$input]) : null);
    } else {
        if(!empty($_REQUEST[$input])){
            $data_hook = preg_replace('/\x20+/', ' ', $_REQUEST[$input]); 	
        } else {
            $data_hook = null;	
        }
    }
    $hook = chaudoudoux_call_hook('chaudoudoux', 'input', false, array(
            'input' => $input,
            'noencode' => $noencode,
            'default' => $default,
            'strip' => $strip,
            'data' => $data_hook,
    ));
    if ($hook) {
            $input    = $hook['input'];
            $noencode = $hook['noencode'];
            $default  = $hook['default'];
            $strip    = $hook['strip'];
            if (isset($hook['data']) && is_array($hook['data'])) {
                    foreach ($hook['data'] as $key => $value) {
                            $hook['data'][$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
                    }
                    return $hook['data'];
            }
            if (!isset($hook['data']) && $default) {
                    return $default;
            }
            if (isset($hook['data']) && empty($noencode)) {
                    $data = htmlspecialchars($hook['data'], ENT_QUOTES, 'UTF-8');
                    $str  = $data;
            } elseif ($noencode == true) {
                    $str = $data;
            }
            if (strlen($str) > 0) {
                    $str = chaudoudoux_emojis_to_entites($str);
                    if ($strip) {
                            return trim(chaudoudoux_input_escape($str));
                    } else {
                            return chaudoudoux_input_escape($str);
                    }
            }
    }
    return false;
}