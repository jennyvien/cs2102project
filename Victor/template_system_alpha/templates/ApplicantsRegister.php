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
{%extends "base_applicant.html" %}

{% block content %}
<form method="POST">
	Name: <input type="text" name="Name" id="Name"><br><br>
	Email: <input type="text" name="Email" id="Email"><br><br>
	Phone Number: <input type="text" name="Number" id="Number"><br><br>
	Password: <input type="text" name="Password" id="Password"><br><br>
	Resume: <br>
	<textarea rows="4" cols="50" name="Resume" id="Resume">Enter Resume here...</textarea><br>
    <input type="submit" name="Submission" value="Submit">
</form>
<?php
if(isset($_POST['Submission']))
{
	$sql = "insert into Applicants values ('".$_POST['Name']."','".$_POST['Email']."','".$_POST['Number']."','".$_POST['Password']."','".$_POST['Resume']."')";
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid,OCI_COMMIT_ON_SUCCESS);
	oci_free_statement($stid);
	echo "<meta http-equiv=\"refresh\" content=\"0;ApplicantsPortal\">";	
}
?>
<?php
oci_close($dbh);
?>
{%endblock %}