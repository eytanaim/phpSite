<?php
require 'common.php';

databaseAttach();
createHtmlProlog();

// Database querying:
$query = 'SELECT * FROM coverage.agent_version_table order by id;';
$versionResult = mysql_query($query) or die('Query failed: ' . mysql_error());
//$query = 'SELECT * FROM coverage.os_table order by id;';
//$osResult = mysql_query($query) or die('Query failed: ' . mysql_error());
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
echo "</td><td width='15%'>";

// Os combo box
echo "<b>Os:</b><br/>";
echo "<p id='osCheckBoxesPlaceholder'></p>";
echo "</td><td width='15%'>";

/***********************************DB***************************************/
// db combo box
echo "<b>Os:</b><br/>";
echo "<p id='dbCheckBoxesPlaceholder'></p>";
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
</div>

<?php

createFooterMenu();
JavaScriptInitilizeInputsDefinitions();
JavaScriptGenerateInputFields();
createHtmlEpilog();
databaseDetach();

?>