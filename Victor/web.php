<html>
<head> <title>Demo Job Offers</title> </head>

<body bgcolor="#9F81F7">
<table>
<tr> <td column = '100'>
<h1> Job Offers</h1>
</td> </tr>

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
	$sql="SELECT email from APPLICANTS";
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid, OCI_DEFAULT);
	echo "<table border=\"1\" >
	<col width=\"75%\">
	<col width=\"25%\">
	<tr>
	<th>email</th>
	</tr>";

	$row=oci_fetch_array($stid);
	echo $row[0];
	
	echo "</table>";	

}
?>

<?php
oci_close($dbh);
?>
</body>
</html>