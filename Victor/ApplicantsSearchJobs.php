<?php
// Standard login required preamble
// To use, place as the FIRST LINE of the page
session_start();
if (!isset($_SESSION["LoggedIn"]) or $_SESSION["LoggedIn"] == 0){
	header("Location: ApplicantsLogin.php");
}
?>
<?php
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
<!-- Search Job offer descriptions and titles for word -->

<form>
	Search:<input type="text" name="searchContent" id="searchContent"><br><br>
	<input type="submit" name="search" value="Submit">
</form>
<?php
if(isset($_GET['search']))
{
	// Show only job title and create a link to display job? Or just display everything?
	$sql = "SELECT * FROM JobOffers WHERE title LIKE '".$_POST['searchContent']."' OR description LIKE '".$_POST['searchContent']."'";
	$stid = oci_parse($dbh, $sql);
	oci_execute($stid,OCI_COMMIT_ON_SUCCESS);
	$result = oci_num_rows($sql);
	if($result<1){
		echo "No result founded.";
	}
	while($row = oci_fetch_array($stid)) {
		echo "<tr>";
		echo "<td>";
		echo "$row[0]";
		echo "</td>";
		echo "</tr>";
	}
}
?>

