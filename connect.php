<?php
//Configuration
$mysql_host="127.0.0.1";
$mysql_username="username";
$mysql_password="password";
$database="database";
$connect=mysql_connect ($mysql_host, $mysql_username, $mysql_password);
$connectdb=mysql_select_db("$database", $connect);
if (!$connect ) {
  echo "mysql_connect : " . mysql_error() . "<br />";
  echo "Error code :" . mysql_errno() . "<br />";
  die('Error connecting to mysql');
}
?>