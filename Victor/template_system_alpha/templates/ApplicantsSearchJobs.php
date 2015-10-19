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
{% extends "base_applicant.html"%}
{% block content %}
<form method = "GET">
	Search:<input type="text" name="searchContent" id="searchContent"><br><br>
	<input type="submit" name="submit" value="Submit">
</form>


<?php
if(isset($_GET['submit']))
{
	$sql = "SELECT title, description FROM JobOffers WHERE title = '".$_GET['searchContent']."'OR description = '".$_POST['searchContent']."'"; 
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
{% endblock%}