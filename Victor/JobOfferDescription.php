<?php
// Standard login required preamble
// To use, place as the FIRST LINE of the page
session_start();
if (!isset($_SESSION["LoggedIn"]) or $_SESSION["LoggedIn"] == 0 or $_SESSION["Employer"] == 1){
	header("Location: ApplicantsLogin.php");
}
?>
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
	$job_title=$_GET['job_title'];
	echo "Title: " . $job_title;
	$company=$_GET['company'];
	echo "<br> Company: " . $company . "";	
	$description=$_GET['description']; 
	echo "<br> Job Description: " . $description . "";
	$city=$_GET['city'];
	$country=$_GET['country'];
	echo "<br> Location: " . $city . ", " . $country;
	$pos_type=$_GET['pos_type'];
	echo "<br> Position type: " . $pos_type . "";
	$salary=$_GET['salary'];
	echo "<br> Salary: $" . $salary . "/year";
	echo "<br><br><a href=Application.php?jobnum=".$_GET['jobnum']."&employer=".$_GET['employer'].">Apply here</a>";	
?>

</body>
</html>