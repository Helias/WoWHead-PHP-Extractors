<?php
include 'connect.php';

//$queryskinloots=mysql_query("SELECT entry FROM creature_template WHERE entry IN (SELECT id FROM creature WHERE id IN (SELECT entry FROM creature_template WHERE entry > $start AND skinloot=0)) ORDER BY entry;");
$queryskinloots=mysql_query("SELECT entry FROM creature_template WHERE entry > $start AND skinloot=0 ORDER BY entry;");

while ($executes=mysql_fetch_array($queryskinloots, MYSQL_ASSOC))
{
	$queryskinloot=mysql_query("SELECT skinloot FROM creature_template WHERE entry={$executes['entry']};");
	echo "\n Checking {$executes['entry']}";
	$data=getHTML("http://www.wowhead.com/npc={$executes['entry']}", 10);
	if (strpos($data,"tab_skinning"))
	{
		while ($execute = mysql_fetch_array($queryskinloot, MYSQL_ASSOC)){$skinloot=$execute['skinloot'];}
		if ($skinloot=="0")
		{
			$file=fopen("SkinningCode.sql", "a+");
			fwrite($file, "\n{$executes['entry']}");
			fclose($file);
			echo " -- skinloot"; // if the NPC is bugged print this
		}
	}
}
echo "\n";
?>