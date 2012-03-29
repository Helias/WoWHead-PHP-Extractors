<?php
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);

//Configuration
$mysql_host="localhost";
$mysql_username="username";
$mysql_password="password";
$database="database";

// Worth
$multipler1=1/10; // mingold=gold * $multipler1
$multipler2=2; // maxgold=gold* $multipler2
?>
<form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<title>Controller</title>
<p>Choose a tip of loot</p>
<select name="Controller">
<option value="0">--</option>
<option value="1">Loot</option>
<option value="2">Pickpocketloot</option>
<option value="3">Skinloot</option>
<option value="4">Worth</option>
</select>
<p><input type="submit" value="Choose"></p>
</form>
<?php
$connect=mysql_connect ($mysql_host, $mysql_username, $mysql_password);
$connectdb=mysql_select_db("$database", $connect);
$Choose=$_POST['Controller'];
if (!$connect)
{
	echo "\nCan't connect at server! You must configure this file before open it!\n";
}
if (!$connectdb)
{
	echo "\nCan't connect at database! You must configure this file before open it!\n";
}
else
{
	if($Choose==0)
	{
		echo "You must select a option!";
	}
	elseif ($Choose == 1)
	{
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
	}
	elseif ($Choose == 2)
	{
		$querypickpockets=mysql_query("SELECT entry FROM creature_template WHERE entry IN (SELECT id FROM creature WHERE id IN (SELECT entry FROM creature_template WHERE entry>0 AND pickpocketloot=0)) ORDER BY entry;");
		while ($executes=mysql_fetch_array($querypickpockets, MYSQL_ASSOC))
		{
			$querypickpocket=mysql_query("SELECT pickpocketloot FROM creature_template WHERE entry={$executes['entry']};");
			echo "\n Checking {$executes['entry']}";
			$data=file_get_contents("http://old.wowhead.com/npc={$executes['entry']}");
			if (strpos($data,"'pickpocketing'"))
			{
				while ($execute = mysql_fetch_array($querypickpocket, MYSQL_ASSOC)){$pickpocketloot=$execute['pickpocketloot'];}
				if ($pickpocketloot=="0")
				{
					$file=fopen("PickpocketCode.sql", "a+");
					fwrite($file, "\n{$executes['entry']}\n");
					fclose($file);
				}
			}
		}
	}
	elseif ($Choose == 3)
	{
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
	}
	elseif ($Choose == 4)
	{
		$querygolds=mysql_query("SELECT entry,mingold,maxgold FROM creature_template WHERE entry IN (SELECT id FROM creature WHERE id IN (SELECT entry FROM creature_template WHERE entry>0 AND maxgold=0 AND mingold=0)) ORDER BY entry;");
		while ($executes=mysql_fetch_array($querygolds, MYSQL_ASSOC))
		{
			$querygold=mysql_query("SELECT mingold FROM creature_template WHERE entry={$executes['entry']};");
			echo "\n Checking {$executes['entry']}";
			$data=file_get_contents("http://old.wowhead.com/npc={$executes['entry']}");
			if (strpos($data,"']Worth: ['"))
			{
				while ($execute = mysql_fetch_array($querygold, MYSQL_ASSOC)){$gold=$execute['mingold'];}
				if ($gold=="0")
				{
					$golds=substr($data, strpos($data, "money=")+6, 6);
					$mingold=$golds*$multipler1;
					$maxgold=$golds*$multipler2;
					$name=substr($data, strpos($data, "<title>")+7, strpos($data, " - NPC - World of Warcraft</title>")-(strpos($data, "<title>")+7));
					$sql_fix="UPDATE `creature_template` SET `mingold`=$mingold, `maxgold`=$maxgold WHERE `entry`={$executes['entry']};";
					$file=fopen("WorthCode.sql", "a+");
					fwrite($file, "\n{$executes['entry']}");
					fclose($file);
				}
			}
		}
	}
}
echo "\nCheck the files \"Code.sql\"\n";
?>