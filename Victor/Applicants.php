<html>
<head> <title> Register Applicants </title> </head>

<body bgcolor="#9F81F7">
<table>
<tr> <td column = '100'>
<h1> Register as Applicants</h1>
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
	Name: <input type="text" name="Name" id="Name"><br><br>
	Email:<input type="text" name="Email" id="Email"><br><br>
	Phone Number:<input type="text" name="Number" id="Number"><br><br>
	Password:<input type="text" name="Password" id="Password"><br><br>
	Resume:<br>
	<textarea rows="4" cols="50" name="Resume" id="Resume">
Enter Resume here...</textarea><br>
<input type="submit" name="formSubmit" value="Submit">
</form>

<?php
if(isset($_GET['formSubmit']))
{
	$sql = "insert into Applicants values ('".$_GET['Name']."','".$_GET['Email']."','".$_GET['Number']."','".$_GET['Password']."','".$_GET['Resume']."')";
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid,OCI_COMMIT_ON_SUCCESS);
	oci_free_statement($stid);
}
?>

<?php
oci_close($dbh);
?>

</body>
</html>