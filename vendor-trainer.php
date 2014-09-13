<?php
include 'connect.php';

//$querys=mysql_query("SELECT entry FROM creature_template WHERE entry IN (SELECT id FROM creature WHERE id IN (SELECT entry FROM creature_template WHERE entry>0 AND npcflag=0)) ORDER BY entry;");
$querys=mysql_query("SELECT entry FROM creature_template WHERE entry IN (SELECT id FROM creature WHERE id IN (SELECT entry FROM creature_template WHERE entry>0 AND npcflag=0)) ORDER BY entry;");

while ($executes=mysql_fetch_array($querys, MYSQL_ASSOC))
{
	echo "\n Checking {$executes['entry']}";
	$query=mysql_query("SELECT npcflag FROM creature_template WHERE entry={$executes['entry']};");
	$data=file_get_contents("http://www.wowhead.com/npc={$executes['entry']};");
	if (strpos($data,"'sells'"))
	{
		while ($execute = mysql_fetch_array($query, MYSQL_ASSOC)){$npcflag=$execute['npcflag'];}
		if ($npcflag=="0")
		{
			$file=fopen("Vendor.sql", "a+");
			fwrite($file, "\n{$executes['entry']}");
			fclose($file);
			echo "\n Found bugged: {$executes['entry']}!";
		}
	}
	elseif (strpos($data,"''teaches-recipe'"))
	{
		while ($execute = mysql_fetch_array($query, MYSQL_ASSOC)){$npcflag=$execute['npcflag'];}
		if ($npcflag=="0")
		{
			$file=fopen("TrainerCode.sql", "a+");
			fwrite($file, "\n{$executes['entry']}");
			fclose($file);
			echo "\n Found bugged: {$executes['entry']}!";
		}
	}
}
echo "\n";
?>