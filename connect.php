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

$start = ""; //In wich entry the extractor must start

function getHTML($url, $timeout)
{
       $ch = curl_init($url); // initialize curl with given url
       curl_setopt($ch, CURLOPT_USERAGENT, "TrinityCore"); // set  useragent
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // write the response to a variable
       curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // follow redirects if any
       curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout); // max. seconds to execute
       curl_setopt($ch, CURLOPT_FAILONERROR, 1); // stop when it encounters an error
       return @curl_exec($ch);
}
?>