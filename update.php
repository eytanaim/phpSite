<html>
<head>
<link rel="stylesheet" type="text/css" href="2nd.css">
<link rel="stylesheet" type="text/css" href="jordyvanraaij.css">
</head>
<body align="center">


<div class="form-style-5">


<br/>
<h1>Agents Coverage Tool</h1>
<br/><br/>
<?php
error_reporting(E_ALL ^ E_DEPRECATED);

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
$query = 'SELECT * FROM coverage.mode_table order by id;';
$modeResult = mysql_query($query) or die('Query failed: ' . mysql_error());
$query = 'SELECT * FROM coverage.connType_table order by id;';
$connResult = mysql_query($query) or die('Query failed: ' . mysql_error());

?><form method="post" action="updateHandler.php">
<table align="left" style="width: 100%" text-align="left" valign="top">
<tr valign="top">
<td>
<?php
// Os combo box
echo "<b>Agent version:</b><br/>";
while ($line = mysql_fetch_array($versionResult, MYSQL_BOTH)) {
	echo "<input type=\"checkbox\" name=\"version[]\" value=$line[0]>$line[1]";
	echo "<br/>";
}
echo "</td><td>";

// Os combo box
echo "<b>Platform:</b><br/>";
while ($line = mysql_fetch_array($osResult, MYSQL_BOTH)) {
	echo "<input type=\"checkbox\" name=\"os[]\" value=$line[0]>$line[1]";
	echo "<br/>";
}
echo "</td><td>";

/***********************************DB***************************************/
// db combo box
echo "<b>Database:</b><br/>";
while ($line = mysql_fetch_array($dbResult, MYSQL_BOTH)) {
	echo "<input type=\"checkbox\" name=\"db[]\" value=$line[0]>$line[1]";
	echo "<br/>";
}
echo "</td><td>";
/***********************************Feature***************************************/
// feature combo box
echo "<b>Feature:</b><br/>";
while ($line = mysql_fetch_array($ftrResult, MYSQL_BOTH)) {
	echo "<input type=\"checkbox\" name=\"feature[]\" value=$line[0]>$line[1]";
	echo "<br/>";
}
echo "</td><td>";
/***********************************Feature***************************************/
// mode combo box
echo "<b>Technology:</b><br/>";
while ($line = mysql_fetch_array($modeResult, MYSQL_BOTH)) {
	echo "<input type=\"checkbox\" name=\"mode[]\" value=$line[0]>$line[1]";
	echo "<br/>";
}
echo "</td><td>";

/***********************************Feature***************************************/
// feature combo box
echo "<b>Connection type:</b><br/>";
while ($line = mysql_fetch_array($connResult, MYSQL_BOTH)) {
	echo "<input type=\"checkbox\" name=\"conn[]\" value=$line[0]>$line[1]";
	echo "<br/>";
}
echo "</td><td>";
/***********************************Textbox***************************************/
?>
</td>
</tr>
</table>
<p align="left"><b>Comments:</b>
<textarea rows="4" cols="10" name="comment">
</textarea>
<input style="width:15%" align="center" type="submit" name="submit" value="Update"></form>
</p>
<?php

// Closing connection
mysql_close($link);
?>



</div>
<br/><br/>
<img src="http://www.aws-partner-directory.com/PartnerDirectory/servlet/servlet.FileDownload?retURL=%2FPartnerDirectory%2Fapex%2FPartnerDetail%3FName%3DImperva&file=00P0L00000ZJ9H8UAL">
</body>
</html>
