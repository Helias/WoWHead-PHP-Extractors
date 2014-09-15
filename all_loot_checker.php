<?php
include 'connect.php';

// Only NPC spawned:
// $queryloots=mysql_query("SELECT entry FROM creature_template WHERE entry IN (SELECT id FROM creature WHERE id IN (SELECT entry FROM creature_template WHERE entry > $start AND (lootid=0 OR skinloot=0 OR pickpocketloot=0))) ORDER BY entry;");

// All NPC
//$queryloots=mysql_query("SELECT entry, lootid, skinloot, pickpocketloot FROM creature_template WHERE entry > $start AND (lootid=0 OR skinloot=0 OR pickpocketloot=0) ORDER BY entry;");
$queryloots = mysql_query("SELECT entry, lootid, skinloot, pickpocketloot FROM creature_template WHERE entry > $start AND (lootid=0 OR skinloot=0 OR pickpocketloot=0) ORDER BY entry;");

while ($executes=mysql_fetch_array($queryloots, MYSQL_ASSOC))
{
	echo "\n Checking {$executes['entry']}";
	$data=getHTML("http://www.wowhead.com/npc={$executes['entry']}", 10);

	if (strpos($data,"tab_drops"))
	{
		if ($executes['lootid'] == "0")
		{
			$file=fopen("All_Loot.txt", "a+");
			fwrite($file, "\n{$executes['entry']}");
			fclose($file);
			echo " -- loot"; // if the NPC is bugged print this
		}
	}

	if (strpos($data,"tab_pickpocketing"))
	{
		if ($executes['pickpocketloot']=="0")
		{
			$file=fopen("All_Pickpocket.txt", "a+");
			fwrite($file, "\n{$executes['entry']}");
			fclose($file);
			echo " -- pickpocketloot"; // if the NPC is bugged print this
		}
	}
	
	if (strpos($data,"tab_skinning"))
	{
		if ($executes['skinloot']=="0")
		{
			$file=fopen("All_Skinning.txt", "a+");
			fwrite($file, "\n{$executes['entry']}");
			fclose($file);
			echo " -- skinloot"; // if the NPC is bugged print this
		}
	}
}
echo "\n";
?>