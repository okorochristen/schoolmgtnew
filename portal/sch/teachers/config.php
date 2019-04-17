<?php
$mysql_hostname = "localhost";
$mysql_user = "u0563804_users";
$mysql_password = "o955l57va3";
$mysql_database = "u0563804_rhimoni";
$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
mysql_select_db($mysql_database, $bd) or die("Could not select database");

?>
define('DB_HOST','localhost');
define('DB_USER','');
define('DB_PASS','');
define('DB_NAME','');