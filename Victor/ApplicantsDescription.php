<html>
<head> <title>Applicant's Application</title> 
<link rel="stylesheet" href="CSS/styles.css">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>


<body>
	<h1> Applicant's Application</h1>
<table>
<tr> <td column = '100'>

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
	$applicants=$_GET['applicants'];

	$sql="SELECT a.name, a.phonenumber, a.resume FROM applicants a WHERE a.email='" . $_GET['applicants'] . "'";
	$stid=oci_parse($dbh, $sql);
	oci_execute($stid, OCI_DEFAULT);
	$row = oci_fetch_array($stid);
	echo "Job ID: ".$_GET[jobid]."";
	echo "<br> Name: " . $row[0]."";
	echo "<br> Email: ".$_GET['applicants']."";
	echo "<br> Phone Number: ".$row[1]."";
	echo "<br> Date Applied: ".$_GET['date']."";
	echo "<br> Write Up: ".$_GET['writeup']."";
	echo "<br> Resume: ".$row[2]."";
		
?>
</table>
</body>
</html>