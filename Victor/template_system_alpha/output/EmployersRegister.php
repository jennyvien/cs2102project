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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--
	Maximus4T by 4Templates | http://www.4templates.com/free/ | @4templates
	Licensed under the Creative Commons Attribution 3.0 License
-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TITLE OF JOBOFFER SITE</title>
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
			<li class="first"><a href="EmployersPortal.php" accesskey="1" title=""><span>Home</span></a></li>
			<li><a href="EmployersViewOffers.php" accesskey="2" title=""><span>My Offers</span></a></li>
			<li><a href="EmployersSubmitOffer.php" accesskey="3" title=""><span>Submit Job Offer</span></a></li>
			<li><a href="EmployersDetails.php" accesskey="4" title=""><span>Employer Details</span></a></li>
			<li><a href="Logout.php" accesskey="5" title=""><span>Logout</span></a></li>
		</ul>
	</div>
	<div id="search">
		<form method="get" action="">
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

				</div>
			</div>
		</div>
	</div>
	<div class="bgbtm"></div>
</div>
<div id="footer">
	<p><a href="http://www.4templates.com/free/">4Templates</a>  |  Photos by <a href="http://fotogrph.com/">Fotogrph</a></p>
</div>
</body>
</html>