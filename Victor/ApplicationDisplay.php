<?php
session_start();
if (!isset($_SESSION["LoggedIn"]) or $_SESSION["LoggedIn"] == 0){
	header("Location: ApplicantsLogin.php");
	$test = "NOT LOGGED IN";
}

?>
<html>
<head> <title>Application Listings</title> 
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
<h1> Application to Jobs Submitted</h1>
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
<form method= "POST">
	Company email: <input type="text" name="Cemail" id="Cemail">
	Password: <input type ="text" name ="Password" id="Password">
	<input type="submit" name="formSubmit" value="Search" > 
</form>
<?php
//Debugging, shows what variables are available in the session
echo '<pre>';
						var_dump($_SESSION);
						echo '</pre>';
						echo $test;
						?>
<?php
if(isset($_POST['formSubmit']))
{	
	$sql1 = "select count(*) from employers where email='".$_POST['Cemail']."' and password='".$_POST['Password']."'";
	$stid1 = oci_parse($dbh, $sql1);
	oci_execute($stid1,OCI_COMMIT_ON_SUCCESS);
	$row1 = oci_fetch_array($stid1);
	if ($row1[0]>0){
		$sql="SELECT a.applicants,a.joboffers,a.date_applied,a.writeup,a.joboffers FROM applications a where employers ='".$_POST['Cemail']."' ORDER BY a.date_applied";
		$stid=oci_parse($dbh, $sql);	
		oci_execute($stid, OCI_DEFAULT);
		while($row = oci_fetch_array($stid)) {
			$applicants=str_replace(' ', '%20', $row[0]);
			$jobid=str_replace(' ', '%20', $row[1]);
			$date=str_replace(' ', '%20', $row[2]);
			$writeup=str_replace(' ', '%20', $row[3]);
			$jobid=str_replace(' ', '%20', $row[4]);
			echo "<tr>";
			echo "<td>";
			echo "<a href=ApplicantsDescription.php?";
			echo "applicants=";
			echo $applicants;
			echo "&Cemail=";
			echo $_post['Cemail'];
			echo "&jobid=";
			echo $jobid;
			echo "&date=";
			echo $date;
			echo "&writeup=";
			echo $writeup;		
			echo "&jobid=";
			echo $jobid;	
			echo ">"; 
			echo $row[0];
			echo "</a>";
			echo "</td>";
			echo "</tr>";	

		}

	}
}
?>

<?php
oci_close($dbh);
?>
</body>
</html>