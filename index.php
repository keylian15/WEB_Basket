<?php
require_once(dirname(__FILE__) . '/lib/security.lib.php');
require_once(dirname(__FILE__) . '/lib/myproject.lib.php');
// require_once(dirname(__FILE__) . '/class/myDbClass.php');
$db = require(dirname(__FILE__) . '/lib/mypdo.php');
if (GETPOST('debug') == true) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
}

include 'main.inc.php';
