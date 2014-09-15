<?php
include 'connect.php';

//$querys=mysql_query("SELECT entry FROM creature_template WHERE entry IN (SELECT id FROM creature WHERE id IN (SELECT entry FROM creature_template WHERE entry > $start)) ORDER BY entry;");
$querys=mysql_query("SELECT entry, npcflag FROM creature_template WHERE entry > $start ORDER BY entry;");

while ($executes=mysql_fetch_array($querys, MYSQL_ASSOC))
{
	echo "\n Checking {$executes['entry']}";
	$data=getHTML("http://www.wowhead.com/npc={$executes['entry']};", 10);
	if (strpos($data,"tab_sells"))
	{
		if ($executes['npcflag'] == "0")
		{
			$file=fopen("Vendor.txt", "a+");
			fwrite($file, "\n{$executes['entry']}");
			fclose($file);
			echo "  - vendor"; // if the NPC is bugged print this
		}
	}
	
	if (strpos($data,"tab_teaches"))
	{
		if ($executes['npcflag'] == "0")
		{
			$file=fopen("Trainer.txt", "a+");
			fwrite($file, "\n{$executes['entry']}");
			fclose($file);
			echo " -- trainer"; // if the NPC is bugged print this
		}
	}
}
echo "\n";
?>