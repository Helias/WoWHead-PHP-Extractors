<html>
<head></head>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
<p>SELECT * FROM table WHERE entry IN <input type="text" name="entry"><input type="submit" value="Execute"></p>
</form>
<body>
<?php
$entry=$_POST['entry'];
$entry=str_replace("(", "", $entry);
$entry=str_replace(")", "", $entry);
$entry=str_replace(";", "", $entry);
echo $entry;
$arr=explode(",", $entry);
for ($n=0; $n<count($arr); $n++)
{
	$OnClick="OnClick='s$n()'";
	$string="\n<input type=\"submit\" value=\"$arr[$n]\" $OnClick>";
	echo "\n<script type=\"text/javascript\">var a".$n."=false; function s".$n."() { if(a".$n."==false){ a".$n."=true; document.getElementById('$arr[$n]').style.display='';}else { a".$n."=false; document.getElementById('$arr[$n]').style.display='none';}}</script>";
	echo "\n$string";
	echo "\n<iframe width=\"100%\" height=\"100%\" src=\"http://old.wowhead.com/npc=$arr[$n]#skinning\" id=\"$arr[$n]\" style=\"display:none;\"></iframe>";
}
?>
</body>
</html>