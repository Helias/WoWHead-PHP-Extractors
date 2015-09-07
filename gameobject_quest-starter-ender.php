<?php
include 'connect.php';
$queryQuestC = mysql_query("SELECT entry FROM gameobject_template WHERE entry > $start AND entry NOT IN (SELECT id FROM gameobject_queststarter) AND entry NOT IN (SELECT id FROM gameobject_questender) ORDER BY entry;");

while ($executes = mysql_fetch_array($queryQuestC, MYSQL_ASSOC))
{
	echo "\n Checking {$executes['entry']}";
	$data=getHTML("http://www.wowhead.com/object={$executes['entry']}", 10);
	if (strpos($data, "'starts'") or strpos($data, "'ends'"))
	{
		$file=fopen("Gameobject QuestStarterEnder.sql", "a+");
		fwrite($file, "\n{$executes['entry']}");
		fclose($file);
		echo " -- gameobject_queststarter/ender"; // if the Gameobject is missing print this
	}
}
echo "\n";
?>
