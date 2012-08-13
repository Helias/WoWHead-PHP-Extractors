<?php
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);
?>
<form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<title>Controller</title>
<p>Choose an option</p>
<select name="Controller">
<option value="0">--</option>
<option value="1">Loot</option>
<option value="2">Pickpocketloot</option>
<option value="3">Skinloot</option>
<option value="4">Worth</option>
<option value="5">Vendor-Trainer</option>
</select>
<p><input type="submit" value="Choose"></p>
</form>
<?php
switch ($_POST['Controller'])
{
    case 1:
	include 'loot.php';
	break;
    case 2:
	include 'pickpocketloot.php';
        break;
    case 3:
        include 'skinloot.php';
        break;
    case 4:
        include 'worth.php';
        break;
    case 5:
        include 'vendor-trainer.php';
        break;
}
echo "\nSelect an option and check the generated code at \"Code.sql\"\n";
?>