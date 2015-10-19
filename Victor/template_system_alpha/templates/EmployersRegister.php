<?php
	session_start();
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
{%extends "base_employer.html" %}

{% block content %}
<table>
<tr> <td column = '100'>
<h1> Register as Employer</h1>
</td> </tr>
</table>
<form method="POST">
	Email:<input type="text" name="Email" id="Email" required><br><br/>
	Company:<input type="text" name="Company" id="Company" required><br><br/>
	First Name:<input type="text" name="FirstName" id="FirstName" required><br><br/>
	Last Name:<input type="text" name="LastName" id="LastName" required><br><br/>	
	Phone Number:<input type="text" name="Number" id="Number" required><br><br/>
	Password:<input type="text" name="Password" id="Password" required><br><br/>
<input type="submit" name="formSubmit" value="Submit">
</form>

<?php
if(isset($_POST['formSubmit']))
{
	foreach ($_POST as $_test){
		echo $_test;
	}
	$sql = "insert into Employers values ('".$_POST['Email']."','".$_POST['Company']."','".$_POST['FirstName']."','".$_POST['LastName']."','".$_POST['Number']."','".$_POST['Password']."')";
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid,OCI_COMMIT_ON_SUCCESS);
	oci_free_statement($stid);
	$_SESSION["LoggedIn"] = 1;
	$_SESSION["FirstName"] = $_POST["FirstName"];
	$_SESSION["Email"] = $_POST["Email"];
	$_SESSION["Company"] = $_POST["Company"];
	$_SESSION["Applicant"] = 0;
	$_SESSION["Employer"] = 1;
	echo "<meta http-equiv=\"refresh\" content=\"0;EmployersPortal.php\">";	
}
?>

<?php
oci_close($dbh);
?>
{% endblock %}