<html>
<head> <title>Job Offer Listings</title> 
<link rel="stylesheet" href="CSS/styles.css">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>


<body>
<table>
<tr> <td column = '100'>
<h1> Job Offers Listings</h1>
</td> </tr>
<?php
putenv('ORACLE_HOME=/oraclient');
$dbh = ocilogon('e0009809', 'crse1510', '(DESCRIPTION =
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
	$sql="SELECT * FROM joboffers j ORDER BY j.jobnum";
	$stid=oci_parse($dbh, $sql);
	oci_execute($stid, OCI_DEFAULT);
	while($row = oci_fetch_array($stid)) {
		$job_title=str_replace(' ', '%20', $row[0]);
		$employer=str_replace(' ', '%20', $row[1]);
		$job_description=str_replace(' ', '%20', $row[2]);
		$city=str_replace(' ', '%20', $row[3]);
		$country=str_replace(' ', '%20', $row[4]);
		$pos_type=str_replace(' ', '%20', $row[5]);
		$salary=$row[5];
		
		// For the individual URl
		echo "<tr>";
		echo "<td>";
		echo "<a href=JobOfferDescription.php onclick=\"StoreJobNum()\">" .$row[2] . "</a>";
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