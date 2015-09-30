<html>
<head> <title>Job Offer Description</title> 
<link rel="stylesheet" href="CSS/styles.css">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>

<body bgcolor="#D8D8D8">

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
	$sql="SELECT * FROM joboffers order by jobnum";
	$stid=oci_parse($dbh, $sql);
	oci_execute($stid, OCI_DEFAULT);
	while($row = oci_fetch_row($stid)) {
		echo "<div class=\"row\">";
		echo "<div class=\"row\">";
		echo "<div class=\"col-xs-offset-4 col-xs-4\">";
		echo "<h1>" .$row[2] . "</h1>";
		echo "</div>";
		echo "<div class=\"row\">";
		echo "<h6>" .$row[1] . "</h6>";  
		echo "<h6>" .$row[4] . "</h6>";  
		echo "<h6>" .$row[8] . "</h6>";  
		echo "<h6>" .$row[9] . "</h6>";  
		echo "</div>";
		echo "</div>";
	}
}
?>

<?php
oci_close($dbh);
?>
</body>
</html>