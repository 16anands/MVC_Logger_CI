<?php
if(! defined('ENVIRONMENT') ){
    $domain = strtolower($_SERVER['HTTP_HOST']);
    switch($domain) {
        case 'localhost' :
            define('ENVIRONMENT','development');
            break;
        case '159.140.228.10' :
            define('ENVIRONMENT','testing');
            break;
        default :
            define('ENVIRONMENT','production');
            break;
    }
}
?>