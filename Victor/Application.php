<?php
// Standard login required preamble
// To use, place as the FIRST LINE of the page
session_start();
if (!isset($_SESSION["LoggedIn"]) or $_SESSION["LoggedIn"] == 0 or $_SESSION["Employer"] == 1){
	header("Location: ApplicantsLogin.php");
}
?>

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
<!-- Apply for a specific job (from browse screen) -->
<html>
<head> <title> Job Application </title> 
<link rel="stylesheet" href="CSS/styles.css">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>

<body bgcolor="#D8D8D8">
<table>
<tr> <td column = '100'>
<h1> Job Application</h1>
</td> </tr>
</table>

<form method="POST">

	Write Up:<br>	
	<textarea rows="4" cols="50" name="WriteUp" id="WriteUp">Write up..</textarea><br>
	<input type="submit" name="formSubmit" value="Submit">
</form>


<?php
if(isset($_POST['formSubmit']))
{
	$jobnum = $_GET['jobnum'];
	date_default_timezone_set('UTC');


	$sql = "Insert into Applications values('".$_SESSION['Email']."',sysdate,'".$_POST['WriteUp']."','".$_GET['employer']."', '".$_GET['jobnum']."')";
	$stid= oci_parse($dbh, $sql);
	oci_execute($stid,OCI_COMMIT_ON_SUCCESS);
	oci_free_statement($stid);

	echo "<meta http-equiv=\"refresh\" content=\"0;ApplicantsBrowseJobs.php\">";	
}
?>
<?php
oci_close($dbh);
?>

</body>
</html>