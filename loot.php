<?php
include 'connect.php';
$queryloots=mysql_query("SELECT entry FROM creature_template WHERE entry IN (SELECT id FROM creature WHERE id IN (SELECT entry FROM creature_template WHERE entry>0 AND lootid=0)) ORDER BY entry;");
while ($executes=mysql_fetch_array($queryloots, MYSQL_ASSOC))
{
	$queryloot=mysql_query("SELECT lootid FROM creature_template WHERE entry={$executes['entry']};");
	echo "\n Checking {$executes['entry']}";
	$data=file_get_contents("http://old.wowhead.com/npc={$executes['entry']}");
	if (strpos($data,"'drops'"))
	{
		while ($execute = mysql_fetch_array($queryloot, MYSQL_ASSOC)){$lootid=$execute['lootid'];}
		if ($lootid=="0")
		{
			$file=fopen("LootCode.sql", "a+");
			fwrite($file, "\n{$executes['entry']}");
			fclose($file);
		}
	}
}
?>