<?php
// Standard login required preamble
// To use, place as the FIRST LINE of the page
session_start();
if (!isset($_SESSION["LoggedIn"]) or $_SESSION["LoggedIn"] == 0 or $_SESSION["Applicant"] == 1){
	header("Location: EmployersLogin.php");
}
?> 

{% extends "base_employer.html" %}

{% block content %}
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
	<?php
	{
    $sql1 = "SELECT a.applicants, a.date_applied FROM Applications a Where Employers = (SELECT email FROM Employers WHERE email = '".$_SESSION["Email"]."') ORDER BY a.jobnum";
	    $stid=oci_parse($dbh, $sql1);
	    oci_execute($stid, OCI_DEFAULT);
	    while($row = oci_fetch_array($stid)) {
	        echo <tr>;
	        echo <td>;
	        echo .$row[0].;
	        echo </td>;
	        echo <td>;
	        echo .$row[1].;
	        echo </td>;
	        echo </tr>;
	    }

	}
	?>
{% endblock %}