<?php
// Standard login required preamble
// To use, place as the FIRST LINE of the page

session_start();

if (!isset($_SESSION["LoggedIn"]) or $_SESSION["LoggedIn"] == 0){
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
			<p>Subtitle</p>
		</div>
	</div>
</div>
<div id="menu-wrapper">
	<div id="menu-content">
		<ul id="menu">
			<li class="first"><a href="#" accesskey="1" title=""><span>Home</span></a></li>
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
					
<table>
<tr> <td column = '100'>
<h1> Job Application</h1>
</td> </tr>
</table>

<form method="POST">

	Write Up:<br>	
	<textarea rows="4" cols="50" name="WriteUp" id="WriteUp">Write up..</textarea><br>
	<input type="submit" name="formSubmit" value="Submit">
</form>


<?php
if(isset($_POST['formSubmit']))
{
	$jobnum = $_GET['jobnum'];
	date_default_timezone_set('UTC');


	$sql = "Insert into Applications values('".$_SESSION['Email']."',sysdate,'".$_POST['WriteUp']."','".$_GET['employer']."', '".$_GET['jobnum']."')";
	$stid= oci_parse($dbh, $sql);
	oci_execute($stid,OCI_COMMIT_ON_SUCCESS);
	oci_free_statement($stid);

	echo "<meta http-equiv=\"refresh\" content=\"0;ApplicantsBrowseJobs.php\">";	
}
?>
<?php
oci_close($dbh);
?>

<?php
if(isset($_POST['Submit']))
{
	//Not vulnerable to sql injection
	$sql = 'SELECT * FROM  Applicants
			WHERE email = :email and
			password = :password' ;
	$stid = oci_parse($dbh, $sql);
	oci_bind_by_name($stid, ":email", $_POST["Email"]);
	oci_bind_by_name($stid, ":password", $_POST["Password"]);
	oci_execute($stid);
	$data = oci_fetch_array($stid);
	if (count($data) >1)
	{
		$_SESSION["LoggedIn"] = 1;
		$_SESSION["Username"] = $data["NAME"];
		$_SESSION["Email"] = $data["EMAIL"];
		echo '<META HTTP-EQUIV="Refresh" Content="0; URL=ApplicantsLoginResult.php">';
	}
	else{
		$_SESSION["Failed"] = 1;
	}
	oci_free_statement($stid);
	oci_close($dbh);
}
?>

				</div>
			</div>
		</div>
	</div>
	<div class="bgbtm"></div>
</div>
<div id="footer-content">
	<div class="bgtop"></div>
	<div class="content-bg">
		<div id="column1">
			<div class="box1">
				<h2>Just another widget</h2>
				<p>Mauris consectetur magna tempus enim sagittis et bibendum lacus et imperdiet. Maecenas semper et massa amet et odio mauris dui, id luctus amet ligula.</p>
			</div>
			<div class="box2">
				<h2>Just another widget</h2>
				<p>Mauris consectetur magna tempus enim sagittis et bibendum lacus et imperdiet. Maecenas semper et massa amet et odio mauris dui, id luctus amet ligula.</p>
			</div>
		</div>
		<div id="column2">
			<div class="box3">
				<h2>Just another widget</h2>
				<p>Mauris consectetur magna tempus enim sagittis et bibendum lacus et imperdiet. Maecenas semper et massa amet et odio mauris dui, id luctus amet ligula.</p>
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


















