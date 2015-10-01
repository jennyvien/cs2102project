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
<h1> Job Description</h1>
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
<<<<<<< Updated upstream
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
=======
	$job_title=$_GET['job_title'];
	echo "Title: " . $job_title;
	
	$sql="SELECT e.company FROM employers e WHERE e.email='" . $_GET['employer'] . "'";
	$stid=oci_parse($dbh, $sql);
	oci_execute($stid, OCI_DEFAULT);
	$row = oci_fetch_array($stid);
	$employer=$row[0];
	echo "<br> Company: " . $employer . "";
	
	$description=$_GET['description']; 
	echo "<br> Job Description: " . $description . "";
	$city=$_GET['city'];
	$country=$_GET['country'];
	echo "<br> Location: " . $city . ", " . $country;
	$pos_type=$_GET['pos_type'];
	echo "<br> Position type: " . $pos_type . "";
	$salary=$_GET['salary'];
	echo "<br> Salary: $" . $salary . "/year";
		
>>>>>>> Stashed changes
?>
</body>
</html>