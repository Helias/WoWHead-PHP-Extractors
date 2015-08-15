<?php
include 'connect.php';
$queryQuestC=mysql_query("SELECT entry FROM creature_template WHERE entry > $start AND entry NOT IN (SELECT id FROM creature_queststarter) ORDER BY entry;");
while ($executes=mysql_fetch_array($queryQuestC, MYSQL_ASSOC))
{
	echo "\n Checking {$executes['entry']}";
	$data=getHTML("http://www.wowhead.com/npc={$executes['entry']}", 10);
	if (strpos($data,"'starts'"))
	{
		$file=fopen("QueststarterCreature.sql", "a+");
		fwrite($file, "\n{$executes['entry']}");
		fclose($file);
		echo " -- queststarter_creature"; // if the NPC is bugged print this
	}
}
echo "\n";
?>