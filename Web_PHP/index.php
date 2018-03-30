<?php

require_once("config.php");

if (file_exists($web->getSiteFileName())) {
    include_once($web->getSiteFileName());
} else {
    include_once('pages/404.php');
}
$content->printContent();

?>
