<?php
error_reporting(E_ALL ^ E_DEPRECATED);

$databaselink;

function databaseAttach()
{
	$GLOBALS['databaselink'] = mysql_connect('10.100.43.225:3306', 'root', 'barbapapa')
    or die('Could not connect: ' . mysql_error());
	mysql_select_db('coverage') or die('Could not select database');
}

function databaseDetach()
{
	mysql_close($GLOBALS['databaselink']);
}

function createHtmlProlog()
{
	?>
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
}

function createFooterMenu()
{
	?>
		<br/>
		<div align="center">
			<a href="index.php">Search</a>
			<img src="http://www.alexander-bown.com/wp-content/uploads/2011/05/big-black-dot.jpg" width="6px" height="6px">
			<a href="update.php">Update</a>
		</div>
	<?php
}

function createHtmlEpilog()
{
	?>
		</div>
		<br/>
		<div align="center">
			<img src="http://www.aws-partner-directory.com/PartnerDirectory/servlet/servlet.FileDownload?retURL=%2FPartnerDirectory%2Fapex%2FPartnerDetail%3FName%3DImperva&file=00P0L00000ZJ9H8UAL">
		</div>
		<!-- This page was created by Eytan Naim et al-->	
	</body>
	</html>
	<?php
}

function JavaScriptInitilizeInputsDefinitions()
{
	echo "<script id='Initilize vars'>";
	
	/* Initilize os definitions: */	
	echo "var osGroups = [];";
	$query = 'SELECT * FROM coverage.os_group_table order by id;';
	$osGroupResult = mysql_query($query) or die('Query failed: ' . mysql_error());
	while($groupRow = mysql_fetch_assoc($osGroupResult)) {
		$query = 'SELECT * FROM coverage.os_table where OS_GROUP_ID = ' . mysql_escape_string($groupRow["id"]) . ' order by id;';
		$osResult = mysql_query($query) or die('Query failed: ' . mysql_error());
		echo "var osGroup = [];\n";
		while($osRow = mysql_fetch_assoc($osResult)) {
			echo "osGroup.push({osName: \"$osRow[os_name]\", osId: $osRow[id]});\n";
		}
		echo "osGroups.push({groupName: \"$groupRow[os_group_name]\", groupList: osGroup});\n";
	}
	
	/* Initilize db definitions: */	
	echo "var dbGroups = [];";
	$query = 'SELECT * FROM coverage.db_group_table order by id;';
	$dbGroupResult = mysql_query($query) or die('Query failed: ' . mysql_error());
	while($groupRow = mysql_fetch_assoc($dbGroupResult)) {
		$query = 'SELECT * FROM coverage.db_table where DB_GROUP_ID = ' . mysql_escape_string($groupRow["id"]) . ' order by id;';
		$dbResult = mysql_query($query) or die('Query failed: ' . mysql_error());
		echo "var dbGroup = [];\n";
		while($dbRow = mysql_fetch_assoc($dbResult)) {
			echo "dbGroup.push({dbName: \"$dbRow[db_name]\", dbId: $dbRow[id]});\n";
		}
		echo "dbGroups.push({groupName: \"$groupRow[db_group_name]\", groupList: dbGroup});\n";
	}
	
	echo "</script>";
}

function JavaScriptGenerateInputFields()
{
	?>
	<script id="Generate inputs">
		var string;
		
		string = "";
		for (var i = 0; i < osGroups.length; i++)
		{
			var groupName = osGroups[i]["groupName"];
			string += "<input name='osGroup' id='checkbox" + groupName + "' type='checkbox' onclick='osClickGroup(\"" + i + "\");'>" + groupName + "<br/>";
			string += "<div id='div" + groupName + "' class='hidden'>";
			for (var j = 0; j < osGroups[i]["groupList"].length; j++)
			{
				/* indent sub checkboxes */
				string += "&nbsp&nbsp&nbsp";
				string += "<input id='" + groupName + osGroups[i]["groupList"][j]["osId"] +
				"' name='os[]' value='" + osGroups[i]["groupList"][j]["osId"] +
				"' type='checkbox'>" +
				osGroups[i]["groupList"][j]["osName"] + "<br/>";	
			}
			string += "</div>";
		}
		document.getElementById("osCheckBoxesPlaceholder").innerHTML = string;
		
		string = "";
		for (var i = 0; i < dbGroups.length; i++)
		{
			var groupName = dbGroups[i]["groupName"];
			string += "<input name='osGroup' id='checkbox" + groupName + "' type='checkbox' onclick='dbClickGroup(\"" + i + "\");'>" + groupName + "<br/>";
			string += "<div id='div" + groupName + "' class='hidden'>";
			for (var j = 0; j < dbGroups[i]["groupList"].length; j++)
			{
				/* indent sub checkboxes */
				string += "&nbsp&nbsp&nbsp";
				string += "<input id='" + groupName + dbGroups[i]["groupList"][j]["dbId"] +
				"' name='db[]' value='" + dbGroups[i]["groupList"][j]["dbId"] +
				"' type='checkbox'>" +
				dbGroups[i]["groupList"][j]["dbName"] + "<br/>";	
			}
			string += "</div>";
		}
		document.getElementById("dbCheckBoxesPlaceholder").innerHTML = string;

		function osClickGroup(checkboxId) {
			var group = osGroups[checkboxId];
			var groupName = group["groupName"];
			if (document.getElementById("checkbox" + groupName).checked == true)
			{
				document.getElementById("div" + groupName).className = "";
				for (var i = 0; i < group["groupList"].length; i++)
				{
					var aaa = groupName + group["groupList"][i]["osId"];
					var bbb = document.getElementById(aaa);
					bbb.checked = true;
				}
			}
			else
			{
				document.getElementById("div" + groupName).className = "hidden";
				for (var i = 0; i < group["groupList"].length; i++)
				{
					document.getElementById(groupName + group["groupList"][i]["osId"]).checked = false;
				}
			}
		}
		
		function dbClickGroup(checkboxId) {
			var group = dbGroups[checkboxId];
			var groupName = group["groupName"];
			if (document.getElementById("checkbox" + groupName).checked == true)
			{
				document.getElementById("div" + groupName).className = "";
				for (var i = 0; i < group["groupList"].length; i++)
				{
					var aaa = groupName + group["groupList"][i]["dbId"];
					var bbb = document.getElementById(aaa);
					bbb.checked = true;
				}
			}
			else
			{
				document.getElementById("div" + groupName).className = "hidden";
				for (var i = 0; i < group["groupList"].length; i++)
				{
					document.getElementById(groupName + group["groupList"][i]["dbId"]).checked = false;
				}
			}
		}
	</script>
	<?php
}
?>

