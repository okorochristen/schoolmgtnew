<?php
// DB credentials.
$host = "localhost";
$username = "root";
$password = "password";
$database = "scho";

// Establish database connection.
$db = new mysqli($host, $username, $password, $database);
$connect_error = $db->connect_error;
if ($connect_error != null) {
	echo "database connection error ".$connect_error;
	exit;
}
?>