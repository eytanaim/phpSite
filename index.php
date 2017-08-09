<html>
<head>
<link rel="stylesheet" type="text/css" href="2nd.css">
<link rel="stylesheet" type="text/css" href="jordyvanraaij.css">
</head>
<body align="center">

<div class="form-style-5">


<br/>
<h1>Agents Coverage Tool</h1>
<br/><br/><br/>
<?php
error_reporting(E_ALL ^ E_DEPRECATED);



if( isset($_POST['version']))
{
	$default_version = $_POST['version'];
}
else
{
	$default_version = 1;
}
if( isset($_POST['os']))
{
	$default_os = $_POST['os'];
}
else
{
	$default_os = 1;
}
if( isset($_POST['db']))
{
	$default_db = $_POST['db'];
}
else
{
	$default_db = 1;
}
if( isset($_POST['feature']))
{
	$default_feature = $_POST['feature'];
}
else
{
	$default_feature = 1;
}

// Connecting, selecting database
//phpinfo();

//$link = mysql_connect('localhost', 'root', 'root12')
$link = mysql_connect('10.100.43.225:3306', 'root', 'barbapapa')
    or die('Could not connect: ' . mysql_error());
mysql_select_db('coverage') or die('Could not select database');

/***********************************OS***************************************/
// Performing SQL query
$query = 'SELECT * FROM coverage.agent_version_table order by id;';
$versionResult = mysql_query($query) or die('Query failed: ' . mysql_error());
$query = 'SELECT * FROM coverage.os_table order by id;';
$osResult = mysql_query($query) or die('Query failed: ' . mysql_error());
$query = 'SELECT * FROM coverage.db_table order by id;';
$dbResult = mysql_query($query) or die('Query failed: ' . mysql_error());
$query = 'SELECT * FROM coverage.feature_table order by id;';
$ftrResult = mysql_query($query) or die('Query failed: ' . mysql_error());

?><form method="post" action="index.php">
<table align="center">
<tr>
<td>
<?php
// Os combo box
echo "Select agent version: <select name=\"version\">\n";
while ($line = mysql_fetch_array($versionResult, MYSQL_BOTH)) {
    echo "<option value=$line[0]";
	if ($default_version == $line[0])
	{
		echo " selected=\"selected\"";
	}
	echo ">$line[1]</option>";
}
echo "</select>\n";
echo "</td><td>";

// Os combo box
echo "Select platform: <select name=\"os\">\n";
while ($line = mysql_fetch_array($osResult, MYSQL_BOTH)) {
    echo "<option value=$line[0]";
	if ($default_os == $line[0])
	{
		echo " selected=\"selected\"";
	}
	echo ">$line[1]</option>";
}
echo "</select>\n";
echo "</td><td>";

/***********************************DB***************************************/
// db combo box
echo "Select database: <select name=\"db\">\n";
while ($line = mysql_fetch_array($dbResult, MYSQL_BOTH)) {
	echo "<option value=$line[0]";
	if ($default_db == $line[0])
	{
		echo " selected=\"selected\"";
	}
	echo ">$line[1]</option>";
}
echo "</select>\n";
echo "</td><td>";
/***********************************Feature***************************************/
// feature combo box
echo "Select feature: <select name=\"feature\">\n";
while ($line = mysql_fetch_array($ftrResult, MYSQL_BOTH)) {
	echo "<option value=$line[0]";
	if ($default_feature == $line[0])
	{
		echo " selected=\"selected\"";
	}
	echo ">$line[1]</option>";}
echo "</select>\n";

?>
</td>
</tr>
</table>
<br/>
<input style="width:15%" align="center" type="submit" name="submit" value="Check"></form>
<?php


// Closing connection
mysql_close($link);

if( isset($_POST['os']) and isset($_POST['db']) and isset($_POST['feature']))
{
	$link = mysql_connect('10.100.43.225', 'root', 'barbapapa')
	or die('Could not connect: ' . mysql_error());
	mysql_select_db('coverage') or die('Could not select database');

	$query = 'SELECT distinct mode_table.mode_name, connType_table.connType_name, coverage_table.comment
		FROM 
			coverage.coverage_table, coverage.feature_table, coverage.db_table, coverage.os_table, coverage.agent_version_table, coverage.connType_table, coverage.mode_table
		WHERE 
			coverage.coverage_table.AGENT_VERSION_ID = coverage.agent_version_table.id and (coverage.coverage_table.AGENT_VERSION_ID = ' . mysql_escape_string($_POST["version"]) . ') and
			coverage.coverage_table.OS_ID = coverage.os_table.id and (coverage.coverage_table.OS_ID = ' . mysql_escape_string($_POST["os"]) . ' or coverage.coverage_table.OS_ID = 1) and
			coverage.coverage_table.DB_ID = coverage.db_table.id and (coverage.db_table.id = ' . mysql_escape_string($_POST["db"]) . ' or coverage.db_table.id = 1) and
			coverage.coverage_table.FEATURE_ID = coverage.feature_table.id and (coverage.feature_table.id = ' . mysql_escape_string($_POST["feature"]) . ') and
			coverage.coverage_table.MODE_ID = coverage.mode_table.id and 
			coverage.coverage_table.CONNTYPE_ID = coverage.connType_table.id';
	$result = mysql_query($query) or die('Query failed: ' . mysql_error());

	// Printing results in HTML
	?>
	<h1>Results:</h1>

	<?php
	if (mysql_num_rows($result) == 0)
	{
		echo "<h1 style=\"background-color:rgba(238,113,106,1)\">Not supported</h1>";
	}
	else
	{
			?>
		<table align="center" style="width: 100%">
		<tr>
		<td >Technology</td>
		<td>Connection type</td>
		<td>Comments</td>
		</tr>
		<?php
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
			echo "\t<tr>\n";
			foreach ($line as $col_value) {
				echo "\t\t<td>$col_value</td>\n";
			}
			echo "\t</tr>\n";
		}
			?>	</table><?php
	}
}
?>



</div>
<br/><br/><br/><br/><br/>
<a href="update.php">update form</a>
<br/>
<img src="http://www.aws-partner-directory.com/PartnerDirectory/servlet/servlet.FileDownload?retURL=%2FPartnerDirectory%2Fapex%2FPartnerDetail%3FName%3DImperva&file=00P0L00000ZJ9H8UAL">
</body>
</html>
