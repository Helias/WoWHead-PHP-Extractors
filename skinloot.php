<?php
include 'connect.php';
$queryskinloots=mysql_query("SELECT entry FROM creature_template WHERE entry IN (SELECT id FROM creature WHERE id IN (SELECT entry FROM creature_template WHERE entry>0 AND skinloot=0)) ORDER BY entry;");
while ($executes=mysql_fetch_array($queryskinloots, MYSQL_ASSOC))
{
	$queryskinloot=mysql_query("SELECT skinloot FROM creature_template WHERE entry={$executes['entry']};");
	echo "\n Checking {$executes['entry']}";
	$data=file_get_contents("http://old.wowhead.com/npc={$executes['entry']}");
	if (strpos($data,"'skinning'"))
	{
		while ($execute = mysql_fetch_array($queryskinloot, MYSQL_ASSOC)){$skinloot=$execute['skinloot'];}
		if ($skinloot=="0")
		{
			$file=fopen("SkinningCode.sql", "a+");
			fwrite($file, "\n{$executes['entry']}");
			fclose($file);
		}
	}
}
?>