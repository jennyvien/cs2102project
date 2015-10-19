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
{% extends "base_applicant.html" %}
<?php
	$sql="SELECT a.date_applied, j.title, e.company
		FROM applications a, joboffers j, employers e
		WHERE a.applicants = '" .$_SESSION["Email"]."'
		and a.employers = e.email
		and a.joboffers = j.jobnum";	
	$stid=oci_parse($dbh, $sql);
	oci_execute($stid, OCI_DEFAULT);
?>	

{% block content %}
<table id="table">
	<tr>
		<th>Date Applied</th>
		<th>Position</th>
		<th>Company</th>
	</tr>
<?php		
	while($row = oci_fetch_array($stid)) {
		echo "<tr>";
		echo "<td>" .$row[0]. "</td>";
		echo "<td>" .$row[1]. "</td>";
		echo "<td>" .$row[2]. "</td>";
		echo "</tr>";
	}
	
	oci_free_statement($stid);
	oci_close($dbh);
?>
</table>
{% endblock %}