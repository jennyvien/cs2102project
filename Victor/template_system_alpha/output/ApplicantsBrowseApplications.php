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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--
	Maximus4T by 4Templates | http://www.4templates.com/free/ | @4templates
	Licensed under the Creative Commons Attribution 3.0 License
-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Maximus4T by 4Templates</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="http://fonts.googleapis.com/css?family=Oswald:400,700" rel="stylesheet" type="text/css" />
<link href="default.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="jquery.dropotron-1.0.js"></script>
<script type="text/javascript" src="init.js"></script>
</head>
<body>
<div id="header-wrapper">
	<div id="header">
		<div id="logo">
			<h1><a href="homepage.html">JobHunt</a></h1>
			<p>Employment made easy</p>
		</div>
	</div>
</div>
<div id="menu-wrapper">
	<div id="menu-content">
		<ul id="menu">
			<li class="first"><a href="ApplicantsPortal.php" accesskey="1" title=""><span>Home</span></a></li>
			<li><a href="ApplicantsBrowseApplications.php" accesskey="2" title=""><span>My applications</span></a></li>
			<li><a href="ApplicantsBrowseJobs.php" accesskey="3" title=""><span>Browse Offers</span></a></li>
			<li><a href="ApplicantsDetails.php" accesskey="4" title=""><span>Applicant Details</span></a></li>
			<li><a href="Logout.php" accesskey="5" title=""><span>Logout</span></a></li>
		</ul>
	</div>
	<div id="search">
		<form method="get" action="ApplicantsSearchJobs.php">
			<fieldset>
				<input type="text" name="s" id="search-text" title="Search our website" size="15" value="" />
				<input type="submit" id="search-submit" value="GO" />
			</fieldset>
		</form>
	</div>
</div>
<div id="banner-wrapper">
	<div id="banner">
		<div class="image"><a href="#"><img src="images/pics02.jpg" width="900" height="257" alt="" /></a></div>
		<div class="border"></div>
	</div>
</div>
<div id="page">
	<div class="bgtop"></div>
	<div class="content-bg">
		<div id="content">
			<div class="post">
				<h1 class="ctitle"> </h2>
				<div class="entry">
					<?php
					//Delete offers if delete request is present
					if (array_key_exists('Delete' ,$_POST)){
						$sql_del = "DELETE FROM Applications
							WHERE Applicants='" . $_POST['Applicants'] . "' AND
							Employers='" . $_POST['Employers'] . "' AND
							Joboffers='" . $_POST['Joboffers'] . "'";
						$stid_del=oci_parse($dbh, $sql_del);
						oci_execute($stid_del);
						oci_free_statement($stid_del);
					}
					?>

					<?php
					$table = "<table id=" . "table" . ">"
						. "<tr>" 
						. " <th>Date Applied</th>" 
						. "<th>Position</th>" 
						. "<th>Company</th>" 
						. "</tr>";
				
					$sql1 = "SELECT COUNT(*)
							FROM applications
							WHERE applicants = '" .$_SESSION["Email"]. "'";
					$stid1=oci_parse($dbh, $sql1);
					oci_execute($stid1, OCI_DEFAULT);
					$count = oci_fetch_array($stid1);
					if($count[0] < 1) {
						echo "No active applications to display.";
					} else {
						$sql_get_applications="SELECT * FROM applications WHERE applicants = '" .$_SESSION["Email"]. "'";
						$stid_get_applications=oci_parse($dbh, $sql_get_applications);
						oci_execute($stid_get_applications, OCI_DEFAULT);
						echo $table;
						while($row = oci_fetch_array($stid_get_applications, OCI_RETURN_NULLS)) {
							$sql_job_title = "SELECT title FROM joboffers 
											WHERE jobnum = '" .$row['JOBOFFERS']. "'
											AND employers ='" .$row['EMPLOYERS']. "'";
							$sql_company = "SELECT company FROM Employers WHERE email = '" .$row['EMPLOYERS']. "'";
							$stid_job_title = oci_parse($dbh, $sql_job_title);
							$stid_company = oci_parse($dbh, $sql_company);
							oci_execute($stid_job_title, OCI_DEFAULT);
							oci_execute($stid_company, OCI_DEFAULT);
							$job_title = oci_fetch_array($stid_job_title);
							$company = oci_fetch_array($stid_company);
							echo "<tr>";
							echo "<td>" .$row['DATE_APPLIED']. "</td>";
							echo "<td>" .$job_title[0]. "</td>";
							echo "<td>" .$company[0]. "</td>";
							echo "<td>" . "
							<form action='ApplicantsBrowseApplications.php' method='POST'>
							<input type='hidden' name='Applicants' value='" . $row['APPLICANTS'] . "'>
							<input type='hidden' name='Employers' value='" . $row['EMPLOYERS'] . "'>
							<input type='hidden' name='Joboffers' value='" . $row['JOBOFFERS'] . "'>
							<input type='submit' name='Delete' value='Delete'>
							</form>
							";
							echo "</tr>";
						}
						oci_free_statement($stid_job_title);
						oci_free_statement($stid_company);
						oci_free_statement($stid_get_applications);
					}
					oci_free_statement($stid1);
					oci_close($dbh);
					echo "</table>";
				?>
				</div>
			</div>
		</div>
	</div>
	<div class="bgbtm"></div>
</div>
</body>
</html>