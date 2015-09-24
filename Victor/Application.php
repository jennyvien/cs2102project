<html>
<head> <title> Job Application </title> </head>

<body bgcolor="#D8D8D8">
<table>
<tr> <td column = '100'>
<h1> Job Application</h1>
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

	Employer's Email:<input type="text" name ="Employer" id="Employer"><br><br>
	Job Number <input type="text" name="Num" id="Num"><br><br>
	Write Up:<br>	
	<textarea rows="4" cols="50" name="WriteUp" id="WriteUp">
Write up..</textarea><br>
<input type="submit" name="formSubmit" value="Submit">
</form>


<?php
if(isset($_GET['formSubmit']))
{
	$int = (is_numeric($_GET['Num']) ? (int)$_GET['Num'] : 0);
	date_default_timezone_set('UTC');


	$sql1 = "select count(*) from applicants where email='".$_GET['Email']."' and password='".$_GET['Password']."'";
	$stid1 = oci_parse($dbh, $sql1);
	oci_execute($stid1,OCI_COMMIT_ON_SUCCESS);
	$row = oci_fetch_array($stid1);

	$sql2 = "Select count(*) from joboffers where employers='".$_GET['Employer']."' and jobnum=".$int;
	$stid2 = oci_parse($dbh, $sql2);
	oci_execute($stid2,OCI_COMMIT_ON_SUCCESS);
	$row2 = oci_fetch_array($stid2);

	if ($row>0 and $row2>0){
		$sql = "Insert into Applications values('".$_GET['Email']."',sysdate,'".$_GET['WriteUp']."','".$_GET['Employer']."',".$int.")";
		$stid= oci_parse($dbh, $sql);
		oci_execute($stid,OCI_COMMIT_ON_SUCCESS);
		oci_free_statement($stid);
	}else{
		echo "Cannot find user or Job";
	}
	oci_free_statement($stid1);
	oci_free_statement($stid2);

}
?>
<?php
oci_close($dbh);
?>

</body>
</html>