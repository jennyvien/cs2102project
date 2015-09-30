<html>
<head> <title>Job Offer Listings</title> </head>
<table>
<tr> <td column = '100'>
<h1> Job Offers Listings</h1>
</td> </tr>
<body>
<?php
putenv('ORACLE_HOME=/oraclient');
$dbh = ocilogon('a0110801', 'crse1510', '(DESCRIPTION =
	(ADDRESS_LIST =
	 (ADDRESS = (PROTOCOL = TCP)(HOST = sid3.comp.nus.edu.sg)(PORT = 1521))
	)
	(CONNECT_DATA =
	 (SERVICE_NAME = sid3.comp.nus.edu.sg)
	)
  )');
?>
<?php
{
	$sql="SELECT j.title FROM joboffers j ORDER BY j.jobnum";
	$stid=oci_parse($dbh, $sql);
	oci_execute($stid, OCI_DEFAULT);
	while($row = oci_fetch_array($stid)) {
		echo "<tr>";
		echo "<td>";
		echo "<a href=JobOfferDescription.php>" .$row[0] . "</a>";
		echo "</td>";
		echo "</tr>";
	}
}
?>

<?php
oci_close($dbh);
?>
</body>
</html>