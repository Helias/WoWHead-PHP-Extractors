<?php
include 'connect.php';
$querypickpockets=mysql_query("SELECT entry FROM creature_template WHERE entry IN (SELECT id FROM creature WHERE id IN (SELECT entry FROM creature_template WHERE entry>0 AND pickpocketloot=0)) ORDER BY entry;");
while ($executes=mysql_fetch_array($querypickpockets, MYSQL_ASSOC))
{
	$querypickpocket=mysql_query("SELECT pickpocketloot FROM creature_template WHERE entry={$executes['entry']};");
	echo "\n Checking {$executes['entry']}";
	$data=file_get_contents("http://www.wowhead.com/npc={$executes['entry']}");
	if (strpos($data,"'pickpocketing'"))
	{
		while ($execute = mysql_fetch_array($querypickpocket, MYSQL_ASSOC)){$pickpocketloot=$execute['pickpocketloot'];}
		if ($pickpocketloot=="0")
		{
			$file=fopen("PickpocketCode.sql", "a+");
			fwrite($file, "\n{$executes['entry']}");
			fclose($file);
		}
	}
}
?>