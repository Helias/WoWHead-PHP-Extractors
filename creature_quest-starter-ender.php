<?php
include 'connect.php';
$queryQuestC = mysql_query("SELECT entry FROM creature_template WHERE entry > $start AND entry NOT IN (SELECT id FROM creature_queststarter) AND entry NOT IN (SELECT id FROM creature_questender) ORDER BY entry;");

while ($executes = mysql_fetch_array($queryQuestC, MYSQL_ASSOC))
{
	echo "\n Checking {$executes['entry']}";
	$data=getHTML("http://www.wowhead.com/npc={$executes['entry']}", 10);
	if (strpos($data, "'starts'") or strpos($data, "'ends'"))
	{
		$file=fopen("Creature QuestStarterEnder.sql", "a+");
		fwrite($file, "\n{$executes['entry']}");
		fclose($file);
		echo " -- creature_queststarter/ender"; // if the NPC is missing print this
	}
}
echo "\n";
?>
