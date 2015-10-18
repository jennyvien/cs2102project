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
<head> <title> Search Jobs </title> 
<link rel="stylesheet" href="CSS/styles.css">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>

<body bgcolor="pink">
<table>
<tr> <td column = '100'>
<h1> Search Jobs</h1>
</td> </tr>
</table>

<form method = "POST">
	Search:<input type="text" name="searchContent" id="searchContent"><br><br>
	<input type="submit" name="formSubmit" value="Submit">
</form>


<?php
if(isset($_POST['formSubmit']))
{
	$sql = "SELECT title, description FROM JobOffers WHERE title = '".$_POST['searchContent']."'OR description = '".$_POST['searchContent']."'"; 
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid,OCI_DEFAULT);
	$result = oci_num_rows($sql);
	if($result<1){
		echo "No result founded.";
	}
	while($row = oci_fetch_array($stid)) {
		echo "<tr>";
		echo "<td>";
		echo $row[0];
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