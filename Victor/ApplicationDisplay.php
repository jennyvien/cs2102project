<?php
// Standard login required preamble
// To use, place as the FIRST LINE of the page
session_start();
if (!isset($_SESSION["LoggedIn"]) or $_SESSION["LoggedIn"] == 0 or $_SESSION["Employer"] == 1){
	header("Location: ApplicantsLogin.php");
}
?>

<!--Display a list of applications applicant has submitted. -->
<html>
<head> <title> Job Application </title> 

<link rel="stylesheet" href="CSS/styles.css">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<style>
	#table, #table tr, #table td, #table th {
		border: 1px solid black;
		padding: 0.4em;
	}
</style>

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
</head>

<body>
<div class="container-fluid tiffblue">
		<div class="col-xs-offset-3 col-xs-6">
			<div class="row">
				<h1 class="title">Your Applications</h1>
			</div>
			<div class="row">
				<div class="col-xs-offset-2 col-xs-8">
				<?php
					$sql="SELECT a.date_applied, j.title, e.company
						FROM applications a, joboffers j, employers e
						WHERE a.applicants = '" .$_SESSION["Email"]."'
						and a.employers = e.email
						and a.joboffers = j.jobnum";	
					$stid=oci_parse($dbh, $sql);
					oci_execute($stid, OCI_DEFAULT);
				?>	
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
				</div>
			</div>	
		</div>	
	</div>	
</body>
</html>