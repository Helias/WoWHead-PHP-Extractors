<?php
include 'connect.php';

// Worth
$multipler1=1/10; // mingold=gold * $multipler1
$multipler2=2; // maxgold=gold* $multipler2

$querygolds=mysql_query("SELECT entry,mingold,maxgold FROM creature_template WHERE entry IN (SELECT id FROM creature WHERE id IN (SELECT entry FROM creature_template WHERE entry>0 AND maxgold=0 AND mingold=0)) ORDER BY entry;");
while ($executes=mysql_fetch_array($querygolds, MYSQL_ASSOC))
{
	$querygold=mysql_query("SELECT mingold FROM creature_template WHERE entry={$executes['entry']};");
	echo "\n Checking {$executes['entry']}";
	$data=file_get_contents("http://old.wowhead.com/npc={$executes['entry']}");
	if (strpos($data,"']Worth: ['"))
	{
		while ($execute = mysql_fetch_array($querygold, MYSQL_ASSOC)){$gold=$execute['mingold'];}
		if ($gold=="0")
		{
			$golds=substr($data, strpos($data, "money=")+6, 6);
			$mingold=$golds*$multipler1;
			$maxgold=$golds*$multipler2;
			$name=substr($data, strpos($data, "<title>")+7, strpos($data, " - NPC - World of Warcraft</title>")-(strpos($data, "<title>")+7));
			$sql_fix="UPDATE `creature_template` SET `mingold`=$mingold, `maxgold`=$maxgold WHERE `entry`={$executes['entry']};";
			$file=fopen("WorthCode.sql", "a+");
			fwrite($file, "\n{$executes['entry']}");
			fclose($file);
		}
	}
}
?>