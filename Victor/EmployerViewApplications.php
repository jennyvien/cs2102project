<?php
// Standard login required preamble
// To use, place as the FIRST LINE of the page
session_start();
if (!isset($_SESSION["LoggedIn"]) or $_SESSION["LoggedIn"] == 0 or $_SESSION["Applicant"] == 1){
	header("Location: EmployersLogin.php");
}
?> 
<html>
<head>
	<title> List of Applications for Jobs Submitted</title>
	<link rel="stylesheet" href="CSS/styles.css">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	
</head>

<body>
	<?php
	$ora_acc = file_get_contents('oracle_acc.ini');
	putenv('ORACLE_HOME=/oraclient');
	$dbh = ocilogon($ora_acc, 'crse1510', '(DESCRIPTION =
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
    $sql1 = "SELECT * FROM JobOffers j Where Employers = (SELECT email FROM Employers WHERE email = '".$_GET['email']."') ORDER BY j.jobnum";
	    $stid=oci_parse($dbh, $sql1);
	    oci_execute($stid, OCI_DEFAULT);
	    while($row = oci_fetch_array($stid)) {
	        echo '<tr>';
	        foreach($row as $field) {
	            echo '<td>' . htmlspecialchars($field) . '</td>';
	        }
	        echo '</tr>';
	    }

	}
	?>

</body>
</html>