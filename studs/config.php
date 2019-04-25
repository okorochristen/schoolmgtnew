<?php
$mysql_hostname = "localhost";
$mysql_user = "root";
$mysql_password = "oduduabasi";
$mysql_database = "schoolman";

// $mysql_hostname = "localhost";
// $mysql_user = "beginnersbasicsc_mgt";
// $mysql_password = "ilovedaniel";
// $mysql_database = "beginnersbasicsc_mgt";

$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
mysql_select_db($mysql_database, $bd) or die("Could not select database");

?>