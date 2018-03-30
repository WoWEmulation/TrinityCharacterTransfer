<?php

//error_reporting(E_ALL);

set_time_limit(100);

require_once('classes/class_db.php');
require_once('classes/class_main.php');
require_once('classes/class_ra.php');
require_once('classes/class_content.php');
require_once('classes/class_web.php');
require_once('classes/class_login.php');
require_once('classes/class_parse.php');

##################################
##################################

$db = new dbConn ('localhost', 'root', 'heslo', 'characters', 'auth', 'world'); // (MySQL server, user, pw, db_characters, db_auth, db_world)
$auth = new Login;
$content = new Content;
$web = new Web;

$conf['ip'] = '127.0.0.1';
$conf['port'] = '3443';
$conf['Raminlvl'] = 3;


##################################
##################################


?>
