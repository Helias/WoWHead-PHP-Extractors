<?php
include 'connect.php';

// Worth
$multipler1 = 1/10; // mingold=gold * $multipler1
$multipler2 = 2; // maxgold=gold* $multipler2

//$querygolds=mysql_query("SELECT entry,mingold,maxgold FROM creature_template WHERE entry IN (SELECT id FROM creature WHERE id IN (SELECT entry FROM creature_template WHERE entry>$start AND maxgold=0 AND mingold=0)) ORDER BY entry;");
$querygolds = mysql_query("SELECT entry,mingold,maxgold FROM creature_template WHERE entry > $start AND maxgold=0 AND mingold=0 ORDER BY entry;");

while ($executes=mysql_fetch_array($querygolds, MYSQL_ASSOC))
{
	echo "\n Checking {$executes['entry']}";
	$data = getHTML("http://www.wowhead.com/npc={$executes['entry']}", 10);
	if (strpos($data,"\x5DWorth\x3A"))
	{
		if ($executes['mingold'] =="0")
		{
			$golds=substr($data, strpos($data, "money=")+6, 6);
			$mingold=$golds*$multipler1;
			$maxgold=$golds*$multipler2;
//			$name=substr($data, strpos($data, "<title>")+7, strpos($data, " - NPC - World of Warcraft</title>")-(strpos($data, "<title>")+7));
			$sql_fix="UPDATE `creature_template` SET `mingold`=$mingold, `maxgold`=$maxgold WHERE `entry`={$executes['entry']};";
			$file=fopen("Worth.txt", "a+");
			fwrite($file, "\n{$executes['entry']}");
			fclose($file);
			echo " -- worth"; // if the NPC is bugged print this
		}
	}
}
echo "\n";
?>