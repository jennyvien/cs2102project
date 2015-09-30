<html>
<head> <title> Register Employers </title>
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
<h1> Register as Employer</h1>
</td> </tr>
</table>
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
<form method="POST">
	Email:<input type="text" name="Email" id="Email"><br><br/>
	Company:<input type="text" name="Company" id="Company"><br><br/>
	First Name:<input type="text" name="FirstName" id="FirstName"><br><br/>
	Last Name:<input type="text" name="LastName" id="LastName"><br><br/>	
	Phone Number:<input type="text" name="Number" id="Number"><br><br/>
	Password:<input type="text" name="Password" id="Password"><br><br/>
<input type="submit" name="formSubmit" value="Submit">
</form>

<?php
if(isset($_POST['formSubmit']))
{
	$sql = "insert into Employers values ('".$_POST['Email']."','".$_POST['Company']."','".$_POST['FirstName']."','".$_POST['LastName']."','".$_POST['Number']."','".$_POST['Password']."')";
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid,OCI_COMMIT_ON_SUCCESS);
	oci_free_statement($stid);
	echo "<meta http-equiv=\"refresh\" content=\"0;JobOffers.php\">";	
}
?>

<?php
oci_close($dbh);
?>

</body>
</html>