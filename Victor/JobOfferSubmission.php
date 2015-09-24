<html>
<head> <title> Create Job Offer </title> </head>
<body bgcolor="#9F81F7">
<table>
<tr> <td column = '100'>
<h1> Create Job Offer</h1>
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

<form>
	Email: <input type="text" name="Email" id="Email"> <br><br>
	Password: <input type="text" name ="Password" id = "Password"><br><br>
	Job Number: <input type="number" name="JobNum" id="JobNum"><br><br>
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
if(isset($_GET['formSubmit']))
{	
	$int = (is_numeric($_GET['Areacode']) ? (int)$_GET['Areacode'] : 0);
	$int2 = (is_numeric($_GET['Salary']) ? (int)$_GET['Salary'] : 0);
	$sql1 = "select count(*) from employers where email='".$_GET['Email']."' and password='".$_GET['Password']."'";
	$stid1 = oci_parse($dbh, $sql1);
	oci_execute($stid1,OCI_COMMIT_ON_SUCCESS);
	$row = oci_fetch_array($stid1);
	if ($row[0]>0)
	{
		$sql = "insert into jobOffers values ('".$_GET['JobNum']."','".$_GET['Email']."',
			'".$_GET['Title']."','".$_GET['Keywords']."','".$_GET['Description']."','".$_GET['City']."','".$_GET['Country']."','".$int.
			"','".$_GET['Postype']."','".$int2.
			"')";
	
		$stid = oci_parse($dbh, $sql);
		oci_execute($stid,OCI_COMMIT_ON_SUCCESS);
		oci_free_statement($stid);
	}else
	{
		echo "Cannot find User";
	}
	oci_free_statement($stid1);
}
?>

<?php
oci_close($dbh);
?>

</body>
</html>