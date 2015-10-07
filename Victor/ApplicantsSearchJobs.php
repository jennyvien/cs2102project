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
	$dbh = ocilogon('a0110801', 'crse1510', '(DESCRIPTION =
		(ADDRESS_LIST =
		 (ADDRESS = (PROTOCOL = TCP)(HOST = sid3.comp.nus.edu.sg)(PORT = 1521))
		)
		(CONNECT_DATA =
		 (SERVICE_NAME = sid3.comp.nus.edu.sg)
		)
	  )');
?>
<!-- Search Job offer descriptions and titles for word -->
<?php

?>

