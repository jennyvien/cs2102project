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
<html>
<head> <title> Create Job Offer </title> 
<link rel="stylesheet" href="CSS/styles.css">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>

<body bgcolor="#9F81F7">
<table>
<tr> <td column = '100'>
<h1> Create Job Offer</h1>
</td> </tr>
</table>
<form method="POST">
	Email: <input type="text" name="Email" id="Email"> <br><br>
	Password: <input type="text" name ="Password" id = "Password"><br><br>
	Title: <input type="text" name="Title" id="Title"><br><br>
	Keywords: <input type="text" name ="Keywords" id="Keywords"><br><br>
	Country:<input type="text" name ="Country" id="Country"><br><br>
	City:<input type="text" name ="City" id="City"><br><br>
	Area Code:<input type="text" name="Areacode" id="Areacode"><br><br>
	Position Type:<input type="text" name ="Postype" id="Postype"><br><br>
	Salary: <input type="text" name="Salary" id="Salary"><br><br>
	Description:<br>	
	<textarea rows="4" cols="50" name="Description" id="Description">
Enter Resume here...</textarea><br>
<input type="submit" name="formSubmit" value="Submit">
</form>

<?php
if(isset($_POST['formSubmit']))
{	
	$int = (is_numeric($_POST['Areacode']) ? (int)$_POST['Areacode'] : 0);
	$int2 = (is_numeric($_POST['Salary']) ? (int)$_POST['Salary'] : 0);
	$sql1 = "select count(*) from employers where email='".$_POST['Email']."' and password='".$_POST['Password']."'";
	$stid1 = oci_parse($dbh, $sql1);
	oci_execute($stid1,OCI_COMMIT_ON_SUCCESS);
	$row = oci_fetch_array($stid1);
	if ($row[0]>0)
	{
		$sql = "insert into jobOffers(employers,title,keywords,Description,city,country,area_code,Pos_type,salary) values ('".$_POST['Email']."',
			'".$_POST['Title']."','".$_POST['Keywords']."','".$_POST['Description']."','".$_POST['City']."','".$_POST['Country']."','".$int.
			"','".$_POST['Postype']."','".$int2.
			"')";
	
		$stid = oci_parse($dbh, $sql);
		oci_execute($stid,OCI_COMMIT_ON_SUCCESS);
		oci_free_statement($stid);
	}else
	{
		echo "Cannot find User";
	}
	oci_free_statement($stid1);
	echo "<meta http-equiv=\"refresh\" content=\"0;JobOffers.php\">";
}
?>

<?php
oci_close($dbh);
?>

</body>
</html>