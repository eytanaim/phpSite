<?php
error_reporting(E_ALL ^ E_DEPRECATED);

/****UPDATE COVERAGE MATRIX PAGE HANDLER!****/


if( isset($_POST['os']) and isset($_POST['db']) and isset($_POST['feature']) and isset($_POST['mode']) and isset($_POST['conn']) and isset($_POST['version']) and isset($_POST['comment']))
{
	$link = mysql_connect('10.100.43.225', 'root', 'barbapapa')
	or die('Could not connect: ' . mysql_error());
	mysql_select_db('coverage') or die('Could not select database');

	foreach($_POST['version'] as $versionElement)
	{
		foreach($_POST['os'] as $osElement)
		{
			foreach($_POST['db'] as $dbElement)
			{
				foreach($_POST['feature'] as $featureElement)
				{
					foreach($_POST['mode'] as $modeElement)
					{
						foreach($_POST['conn'] as $connElement)
						{
												
							$query = 'insert into coverage_table(OS_ID, DB_ID, FEATURE_ID, MODE_ID, CONNTYPE_ID, AGENT_VERSION_ID, comment) values (
							' . mysql_escape_string($osElement) . ',
							' . mysql_escape_string($dbElement) . ',
							' . mysql_escape_string($featureElement) . ',
							' . mysql_escape_string($modeElement) . ',
							' . mysql_escape_string($connElement) . ',
							' . mysql_escape_string($versionElement) . ',
							"' . mysql_escape_string($_POST["comment"]) . '")';
						//	echo "$query\n";
							$result = mysql_query($query) or die('Query failed: ' . mysql_error());
						}
					}
				}
			}
		}
	}

}

/* Redirect to original form */
header("Location: update.php");/* Make sure that code below does not get executed when we redirect. */
?>